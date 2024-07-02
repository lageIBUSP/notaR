<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turma;
use App\Models\User;
use App\Models\Exercicio;
use App\Models\Nota;
use App\Models\Prazo;
use App\Models\Teste;
use App\Models\Topico;
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
        $alunos = User::factory()->count(5)->create();

        $turma_vazia = Turma::factory()->create();
	    $turmas = Turma::factory()->count(3)
            ->hasAttached($alunos)
            ->create();

        $topicos = Topico::factory()->count(2)->create();

        foreach ($topicos as $key => $topico) {
            Exercicio::factory()->count(2)
                ->has(Teste::factory()->count(2))
                ->for($topico)
                ->create();
        }

        Exercicio::factory()->count(3)
            ->has(Teste::factory()->count(2))
            ->create();

        $exercicios = Exercicio::all();

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
