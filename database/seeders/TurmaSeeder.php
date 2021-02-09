<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turma;
use App\Models\User;
use App\Models\Exercicio;

class TurmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    Turma::factory()
            ->count(2)
            ->has(User::factory()->count(3))
            ->create();
    }
}
