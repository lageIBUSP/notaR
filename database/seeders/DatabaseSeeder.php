<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turma;
use App\Models\User;
use App\Models\Exercicio;
use App\Models\Nota;
use App\Models\Prazo;
use App\Models\Teste;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
	    $ind_user = User::factory()->create();
        $alunos = User::factory()->count(3)->create();
	    $turma = Turma::factory()
            ->hasAttached($alunos)
            ->create();

        $turma_vazia = Turma::factory()->create();

        $exercicios = Exercicio::factory()->count(5)
             ->has(Teste::factory()->count(3))
             ->create();


        Prazo::factory()
            ->for($turma)
            ->for($exercicios[1])
            ->create();
        Prazo::factory()
            ->for($turma_vazia)
            ->for($exercicios[2])
            ->create();

        Nota::factory()->count(2)
            ->for($ind_user)
            ->for($exercicios[1])
            ->create();
        Nota::factory()->count(2)
            ->for($ind_user)
            ->for($exercicios[2])
            ->create();
        Nota::factory()->count(2)
            ->for($alunos[1])
            ->for($exercicios[1])
            ->create();
        Nota::factory()->count(2)
            ->for($alunos[2])
            ->for($exercicios[2])
            ->create();

    }
}
