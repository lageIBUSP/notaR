<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turma;

class RelatorioController extends Controller
{
    /**
	 * Relatório de nota
	 *
     * @param  int  $turma
	 * @return \Illuminate\View\View
	 */
	public function relatorioNotas(int $turma)
	{
        $turma = Turma::with(['users', 'prazos', 'prazos.exercicio', 'users.notas'])
            ->find($turma);

        return View('relatorio.notas')
                ->with('turma',$turma)
            ;
	}
}
