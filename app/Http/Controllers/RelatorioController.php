<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turma;

class RelatorioController extends Controller
{
    
    /**
	 * Selecionar relatorio
	 *
	 * @param Illuminate\Http\Request $request;
	 * @return \Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$this->authorize('view', Relatorio::class);
		$rules = array(
			'turma' => 'sometimes|int|exists:turmas,id'
        );
        $data = $request->validate($rules);
        if(array_key_exists('turma',$data)) {
            return $this->relatorioNotas($data['turma']);
        } else {
            return View('relatorio.notas')
                ->with('turmas',Turma::all());
            ;
        }
    }

    /**
	 * Relatório de nota
	 *
     * @param  int  $turma
	 * @return \Illuminate\View\View
	 */
	public function relatorioNotas(int $turma)
	{
		$this->authorize('view', Relatorio::class);
        $turma = Turma::with(['users', 'prazos', 'prazos.exercicio', 'users.notas'])
            ->find($turma);

        return View('relatorio.notas')
                ->with('turma',$turma)
                ->with('turmas',Turma::all());
            ;
	}
}
