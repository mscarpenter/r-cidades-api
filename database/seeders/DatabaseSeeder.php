<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Anuncio; // Importe o Anuncio
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Cria 10 usuários falsos
        User::factory(10)->create();

        // 2. Chama o seeder de Categorias
        $this->call([
            CategoriaMaterialSeeder::class,
        ]);

        // 3. Cria 50 anúncios falsos (usando a Factory que acabamos de definir)
        Anuncio::factory(50)->create();
    }
}