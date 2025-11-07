<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\CategoriaMaterial;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anuncio>
 */
class AnuncioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // --- Nossas Listas em Português ---
        
        $titulos = [
            'Sobra de Tijolos Baianos (Lote)', 'Madeira de Pinus (Vigas)', 'Janela de Alumínio Usada',
            'Sobra de Argamassa (20kg)', 'Porta de Madeira Maciça', 'Lote de Pisos Cerâmicos',
            'Pia de Cozinha (Inox)', 'Vaso Sanitário com Caixa Acoplada', 'Fios Elétricos (Rolo 50m)',
            'Areia Média (Sobra de 1m³)', 'Pedras de Brita (Lote)', 'Telhas de Cerâmica (50 unidades)',
        ];

        $descricoes = [
            'Material em perfeito estado, sobrou da minha obra. Retirar no local.',
            'Usado, mas em boas condições. Ideal para pequenas reformas.',
            'Precisa de uma limpeza, mas a estrutura está intacta. Não entrego.',
            'Sobras de construção civil, disponíveis para retirada imediata.',
            'Lote fechado, não fraciono. Ótimo para quem está construindo.',
        ];

        $condicoes = ['Novo (Sobras)', 'Usado (Bom estado)', 'Usado (Requer reparo)'];
        $quantidades = ['100 unidades', '50m²', '10 peças', 'Lote de 20kg', 'Aprox. 1m³'];

        // --- A Definição do Anúncio ---

        return [
            // Pega um ID de usuário aleatório (dos 10 que criamos)
            'usuario_id' => User::all()->random()->id,
            // Pega um ID de categoria aleatório (das 6 que criamos)
            'categoria_material_id' => CategoriaMaterial::all()->random()->id,

            // USA OS DADOS EM PORTUGUÊS
            'titulo' => $this->faker->randomElement($titulos),
            'descricao' => $this->faker->randomElement($descricoes),
            'quantidade' => $this->faker->randomElement($quantidades),
            'condicao' => $this->faker->randomElement($condicoes),
            'status' => 'Publicado',

            // Gera um peso aleatório para o dashboard
            'peso_estimado_kg' => $this->faker->numberBetween(5, 500),
        ];
    }
}