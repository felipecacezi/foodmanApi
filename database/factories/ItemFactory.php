<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $ar_itens = [
            'Coca-cola', 'Fanta uva', 'Guaraná Antartica', 'Fanta laranja',
            'Hamburger', 'Queijo mussarela', 'Presunto', 'Ovo', 'Pão de hamburger', 'Alface', 'Tomate',
        ];

        return [
            'item_nome' => $this->faker->randomElement($ar_itens),
            'item_unidade_medida' => 'un',
            'item_qtd_minima' => $this->faker->numberBetween(0, 10),
            'item_qtd_maxima' => $this->faker->numberBetween(50, 100),
            'item_ativo' => 1,
        ];
    }
}
