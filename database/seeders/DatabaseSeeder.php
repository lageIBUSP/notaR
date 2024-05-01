<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turma;
use App\Models\User;
use App\Models\Exercicio;
use App\Models\Nota;
use App\Models\Prazo;
use App\Models\Teste;
use Monolog\Handler\SamplingHandler;

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
        $alunos = User::factory()->count(30)->create();

        $turma_vazia = Turma::factory()->create();
	    $turmas = Turma::factory()->count(10)
            ->hasAttached($alunos)
            ->create();

        $exercicios = Exercicio::factory()->count(30)
            ->has(Teste::factory()->count(3))
            ->create();


        foreach ($exercicios as $exercicio) {
            Nota::factory()->count(2)
                ->for($ind_user)
                ->for($exercicio)
                ->create();

            Prazo::factory()
                ->for($turma_vazia)
                ->for($exercicio)
                ->create();

            foreach ($turmas as $turma) {
                Prazo::factory()
                    ->for($turma)
                    ->for($exercicio)
                    ->create();
            }

            foreach ($alunos as $aluno) {
                Nota::factory()->count(5)
                    ->for($aluno)
                    ->for($exercicio)
                    ->create();
            }
        }
    }
}
