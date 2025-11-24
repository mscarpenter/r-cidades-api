<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CategoriaMaterial;
use App\Models\Anuncio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnuncioTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Cria categorias necessárias para a factory
        CategoriaMaterial::factory()->count(3)->create();
    }

    public function test_usuario_autenticado_pode_criar_anuncio()
    {
        $user = User::factory()->create();
        $categoria = CategoriaMaterial::first();

        $response = $this->actingAs($user)->postJson('/api/anuncios', [
            'titulo' => 'Tijolos Sobrando',
            'descricao' => 'Lote de tijolos 8 furos',
            'quantidade' => '100 unidades',
            'condicao' => 'novo',
            'categoria_material_id' => $categoria->id,
            'peso_estimado_kg' => 50,
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['titulo' => 'Tijolos Sobrando']);

        $this->assertDatabaseHas('anuncios', ['titulo' => 'Tijolos Sobrando']);
    }

    public function test_qualquer_um_pode_listar_anuncios()
    {
        // Cria 5 anúncios
        Anuncio::factory()->count(5)->create();

        $response = $this->getJson('/api/anuncios');

        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }

    public function test_dono_pode_editar_anuncio()
    {
        $user = User::factory()->create();
        $anuncio = Anuncio::factory()->create(['usuario_id' => $user->id]);

        $response = $this->actingAs($user)->putJson("/api/anuncios/{$anuncio->id}", [
            'titulo' => 'Título Editado',
            'descricao' => $anuncio->descricao,
            'quantidade' => $anuncio->quantidade,
            'condicao' => $anuncio->condicao,
            'categoria_material_id' => $anuncio->categoria_material_id,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['titulo' => 'Título Editado']);
    }

    public function test_outro_usuario_nao_pode_editar_anuncio()
    {
        $dono = User::factory()->create();
        $outro = User::factory()->create();
        $anuncio = Anuncio::factory()->create(['usuario_id' => $dono->id]);

        $response = $this->actingAs($outro)->putJson("/api/anuncios/{$anuncio->id}", [
            'titulo' => 'Tentativa de Hack',
        ]);

        $response->assertStatus(403);
    }
}
