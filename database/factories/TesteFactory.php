<?php

namespace Database\Factories;

use App\Models\Teste;
use Illuminate\Database\Eloquent\Factories\Factory;

class TesteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teste::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'condicao' => $this->faker->lexify('?') . '==' . $this->faker->numberBetween(0,10),
            'dica' => $this->faker->sentence(2),
            'peso' => 1
        ];
    }
}
