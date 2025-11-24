<?php

namespace Database\Factories;

use App\Models\Anuncio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Solicitacao>
 */
class SolicitacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'anuncio_id' => Anuncio::factory(),
            'beneficiario_id' => User::factory(),
            'mensagem' => $this->faker->sentence(),
            'status' => 'pendente',
        ];
    }
}
