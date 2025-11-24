<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaMaterial;

class CategoriaMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nome' => 'Alvenaria',
                'descricao' => 'Tijolos, blocos, cimento, areia, pedra, etc.',
            ],
            [
                'nome' => 'Acabamento',
                'descricao' => 'Pisos, azulejos, revestimentos, rejunte, argamassa, etc.',
            ],
            [
                'nome' => 'Madeira',
                'descricao' => 'Tábuas, vigas, ripas, compensados, portas, janelas, etc.',
            ],
            [
                'nome' => 'Elétrica',
                'descricao' => 'Fios, cabos, tomadas, interruptores, lâmpadas, disjuntores, etc.',
            ],
            [
                'nome' => 'Hidráulica',
                'descricao' => 'Tubos, conexões, torneiras, registros, caixas d\'água, etc.',
            ],
            [
                'nome' => 'Pintura',
                'descricao' => 'Tintas, vernizes, solventes, pincéis, rolos, lixas, etc.',
            ],
            [
                'nome' => 'Telhado e Cobertura',
                'descricao' => 'Telhas, calhas, rufos, mantas térmicas, etc.',
            ],
            [
                'nome' => 'Ferramentas',
                'descricao' => 'Ferramentas manuais e elétricas para construção.',
            ],
            [
                'nome' => 'Outros',
                'descricao' => 'Materiais diversos que não se encaixam nas outras categorias.',
            ],
        ];

        foreach ($categorias as $categoria) {
            CategoriaMaterial::firstOrCreate(
                ['nome' => $categoria['nome']],
                ['descricao' => $categoria['descricao']]
            );
        }
    }
}