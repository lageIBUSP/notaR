<?php

namespace Database\Factories;

use App\Models\Nota;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nota::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nota' => $this->faker->numberBetween($min = 0, $max = 100),
            'codigo' => "x<-0",
            'testes' => [true,false]
        ];
    }
}
