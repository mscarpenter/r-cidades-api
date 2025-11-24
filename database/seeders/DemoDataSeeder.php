<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CategoriaMaterial;
use App\Models\Anuncio;
use App\Models\Solicitacao;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Criar Categorias
        $categorias = [
            ['nome' => 'Tijolos e Blocos', 'descricao' => 'Tijolos cerâmicos, blocos de concreto, etc.'],
            ['nome' => 'Madeira', 'descricao' => 'Vigas, tábuas, compensados'],
            ['nome' => 'Metais', 'descricao' => 'Ferro, aço, alumínio'],
            ['nome' => 'Portas e Janelas', 'descricao' => 'Portas de madeira, janelas de alumínio'],
            ['nome' => 'Pisos e Revestimentos', 'descricao' => 'Cerâmicas, porcelanatos, azulejos'],
            ['nome' => 'Louças e Metais', 'descricao' => 'Pias, vasos, torneiras'],
        ];

        foreach ($categorias as $cat) {
            CategoriaMaterial::create($cat);
        }

        // 2. Criar Usuários
        $doadores = [
            [
                'name' => 'João Silva',
                'email' => 'joao@example.com',
                'password' => Hash::make('password123'),
                'tipo' => 'doador',
                'telefone' => '(11) 98765-4321',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'pontos' => 150,
            ],
            [
                'name' => 'Carlos Oliveira',
                'email' => 'carlos@example.com',
                'password' => Hash::make('password123'),
                'tipo' => 'doador',
                'telefone' => '(21) 97654-3210',
                'cidade' => 'Rio de Janeiro',
                'estado' => 'RJ',
                'pontos' => 200,
            ],
            [
                'name' => 'Ana Costa',
                'email' => 'ana@example.com',
                'password' => Hash::make('password123'),
                'tipo' => 'doador',
                'telefone' => '(31) 96543-2109',
                'cidade' => 'Belo Horizonte',
                'estado' => 'MG',
                'pontos' => 80,
            ],
        ];

        $beneficiarios = [
            [
                'name' => 'Maria Santos',
                'email' => 'maria@example.com',
                'password' => Hash::make('password123'),
                'tipo' => 'beneficiario',
                'telefone' => '(11) 95432-1098',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
            ],
            [
                'name' => 'Pedro Alves',
                'email' => 'pedro@example.com',
                'password' => Hash::make('password123'),
                'tipo' => 'beneficiario',
                'telefone' => '(21) 94321-0987',
                'cidade' => 'Rio de Janeiro',
                'estado' => 'RJ',
            ],
        ];

        $usuariosDoadores = collect($doadores)->map(fn($d) => User::create($d));
        $usuariosBeneficiarios = collect($beneficiarios)->map(fn($b) => User::create($b));

        // 3. Criar Anúncios
        $anuncios = [
            [
                'titulo' => 'Sobras de Tijolos 8 Furos - 500 unidades',
                'descricao' => 'Tijolos em perfeito estado, sobrou da minha obra. Retirar no local em São Paulo.',
                'quantidade' => '500 unidades',
                'condicao' => 'novo',
                'peso_estimado_kg' => 250,
                'categoria_material_id' => 1,
                'status' => 'disponivel',
            ],
            [
                'titulo' => 'Vigas de Madeira de Pinus - 10 peças',
                'descricao' => 'Vigas de 3 metros cada, em bom estado. Ideal para telhados.',
                'quantidade' => '10 peças',
                'condicao' => 'usado',
                'peso_estimado_kg' => 120,
                'categoria_material_id' => 2,
                'status' => 'disponivel',
            ],
            [
                'titulo' => 'Janelas de Alumínio Branco - 4 unidades',
                'descricao' => 'Janelas de correr, 1,20m x 1,00m cada. Vidros intactos.',
                'quantidade' => '4 unidades',
                'condicao' => 'usado',
                'peso_estimado_kg' => 60,
                'categoria_material_id' => 4,
                'status' => 'disponivel',
            ],
            [
                'titulo' => 'Lote de Cerâmicas Brancas - 15m²',
                'descricao' => 'Cerâmicas 30x30cm, cor branca. Sobra de reforma.',
                'quantidade' => '15m²',
                'condicao' => 'novo',
                'peso_estimado_kg' => 180,
                'categoria_material_id' => 5,
                'status' => 'disponivel',
            ],
            [
                'titulo' => 'Porta de Madeira Maciça com Batente',
                'descricao' => 'Porta de entrada, 2,10m x 0,90m. Precisa de lixamento.',
                'quantidade' => '1 unidade',
                'condicao' => 'usado',
                'peso_estimado_kg' => 45,
                'categoria_material_id' => 4,
                'status' => 'disponivel',
            ],
            [
                'titulo' => 'Blocos de Concreto - 200 unidades',
                'descricao' => 'Blocos estruturais 14x19x39cm. Novos, nunca usados.',
                'quantidade' => '200 unidades',
                'condicao' => 'novo',
                'peso_estimado_kg' => 300,
                'categoria_material_id' => 1,
                'status' => 'disponivel',
            ],
            [
                'titulo' => 'Pia de Cozinha em Inox - Dupla',
                'descricao' => 'Pia de embutir, duas cubas. Pequeno amassado na lateral.',
                'quantidade' => '1 unidade',
                'condicao' => 'usado',
                'peso_estimado_kg' => 8,
                'categoria_material_id' => 6,
                'status' => 'disponivel',
            ],
            [
                'titulo' => 'Telhas de Cerâmica Romana - 100 unidades',
                'descricao' => 'Telhas em bom estado, cor natural. Retirada em BH.',
                'quantidade' => '100 unidades',
                'condicao' => 'usado',
                'peso_estimado_kg' => 150,
                'categoria_material_id' => 1,
                'status' => 'disponivel',
            ],
            [
                'titulo' => 'Tábuas de Madeira Variadas - Lote',
                'descricao' => 'Tábuas de diferentes tamanhos, ótimas para paletes ou artesanato.',
                'quantidade' => 'Lote de 30kg',
                'condicao' => 'usado',
                'peso_estimado_kg' => 30,
                'categoria_material_id' => 2,
                'status' => 'disponivel',
            ],
            [
                'titulo' => 'Vaso Sanitário com Caixa Acoplada',
                'descricao' => 'Vaso branco, modelo convencional. Funcionando perfeitamente.',
                'quantidade' => '1 unidade',
                'condicao' => 'usado',
                'peso_estimado_kg' => 25,
                'categoria_material_id' => 6,
                'status' => 'disponivel',
            ],
        ];

        // Distribuir anúncios entre os doadores
        foreach ($anuncios as $index => $anuncioData) {
            $doador = $usuariosDoadores[$index % $usuariosDoadores->count()];
            Anuncio::create(array_merge($anuncioData, ['usuario_id' => $doador->id]));
        }

        $this->command->info('✅ Dados de demonstração criados com sucesso!');
        $this->command->info('📧 Usuários criados (senha: password123):');
        $this->command->info('   - joao@example.com (Doador)');
        $this->command->info('   - carlos@example.com (Doador)');
        $this->command->info('   - ana@example.com (Doador)');
        $this->command->info('   - maria@example.com (Beneficiário)');
        $this->command->info('   - pedro@example.com (Beneficiário)');
        $this->command->info('📦 ' . count($anuncios) . ' anúncios criados');
    }
}
