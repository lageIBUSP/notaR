<?php

namespace Database\Factories;

use App\Models\Exercicio;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExercicioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exercicio::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => substr($this->faker->sentence(2), 0, -1),
            'enunciado' => $this->faker->paragraph,
            'precondicoes' => '',
            'impedimentos' => '',
        ];
    }
}
