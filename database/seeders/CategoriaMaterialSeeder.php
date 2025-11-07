<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaMaterial; // Importe o Model

class CategoriaMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vamos criar algumas categorias padrão
        CategoriaMaterial::create(['nome' => 'Alvenaria', 'descricao' => 'Tijolos, blocos, cimento, argamassa.']);
        CategoriaMaterial::create(['nome' => 'Madeiras', 'descricao' => 'Tábuas, vigas, pontaletes, paletes.']);
        CategoriaMaterial::create(['nome' => 'Metais', 'descricao' => 'Ferragens, vergalhões, aço, alumínio.']);
        CategoriaMaterial::create(['nome' => 'Hidráulica', 'descricao' => 'Canos, tubos, conexões, pias, vasos.']);
        CategoriaMaterial::create(['nome' => 'Elétrica', 'descricao' => 'Fios, cabos, conduítes, tomadas.']);
        CategoriaMaterial::create(['nome' => 'Acabamentos', 'descricao' => 'Pisos, revestimentos, tintas, portas, janelas.']);
    }
}