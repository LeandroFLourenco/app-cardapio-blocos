<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->word(),
            'descricao' => $this->faker->sentence(),
            'imagem' => 'https://via.placeholder.com/250x150',
            'preco' => $this->faker->randomFloat(2, 5, 50),
            'quantidade' => $this->faker->numberBetween(0, 100),
            'ativo' => true,
        ];
    }
}
