<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Anuncio;
use App\Models\Solicitacao;
use App\Models\AgendamentoLogistica;
use App\Models\CategoriaMaterial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogisticaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        CategoriaMaterial::factory()->create();
    }

    public function test_fluxo_completo_doacao()
    {
        // 1. Cenário: Doador e Beneficiário
        $doador = User::factory()->create(['pontos' => 0]);
        $beneficiario = User::factory()->create();

        // 2. Doador cria anúncio
        $anuncio = Anuncio::factory()->create([
            'usuario_id' => $doador->id,
            'peso_estimado_kg' => 50,
            'status' => 'disponivel'
        ]);

        // 3. Beneficiário solicita
        $response = $this->actingAs($beneficiario)->postJson('/api/solicitacoes', [
            'anuncio_id' => $anuncio->id,
            'mensagem' => 'Preciso muito',
        ]);
        $response->assertStatus(201);
        $solicitacao = Solicitacao::first();

        // 4. Doador aprova
        $this->actingAs($doador)->postJson("/api/solicitacoes/{$solicitacao->id}/aprovar")
             ->assertStatus(200);
        
        $this->assertEquals('aprovada', $solicitacao->fresh()->status);

        // 5. Beneficiário agenda retirada
        $dataFutura = now()->addDays(2)->format('Y-m-d H:i:s');
        $response = $this->actingAs($beneficiario)->postJson('/api/agendamentos', [
            'solicitacao_id' => $solicitacao->id,
            'data_agendada' => $dataFutura,
        ]);
        $response->assertStatus(201);
        $agendamento = AgendamentoLogistica::first();

        // 6. Confirmar Coleta (Doador confirma que entregou)
        $this->actingAs($doador)->putJson("/api/agendamentos/{$agendamento->id}", [
            'confirmacao_retirada' => true
        ])->assertStatus(200);

        $this->assertEquals('Coletada', $agendamento->fresh()->status_logistica);

        // 7. Confirmar Entrega Final (Beneficiário confirma que recebeu/finalizou)
        // Nota: A lógica atual no controller atualiza para 'Entregue' se 'confirmacao_entrega' for true E status for 'Coletada'
        $this->actingAs($beneficiario)->putJson("/api/agendamentos/{$agendamento->id}", [
            'confirmacao_entrega' => true
        ])->assertStatus(200);

        $this->assertEquals('Entregue', $agendamento->fresh()->status_logistica);
        $this->assertEquals('doado', $anuncio->fresh()->status);

        // 8. Verificar Pontos do Doador (10 base + 50 peso = 60 pontos)
        $this->assertEquals(60, $doador->fresh()->pontos);
    }
}
