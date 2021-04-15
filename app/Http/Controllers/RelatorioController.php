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
			'turma' => 'sometimes|int|exists:turmas,id',
			'tipo' => 'sometimes|in:realizacao,notas'
        );
        $data = $request->validate($rules);
        if(array_key_exists('turma',$data) && array_key_exists('tipo',$data)) {
            return $this->relatorio($data['turma'], $data['tipo']);
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
     * @param  string  $tipo
	 * @return \Illuminate\View\View
	 */
	public function relatorio(int $turma, string $tipo)
	{
		$this->authorize('view', Relatorio::class);
        $turma = Turma::with(['users', 'prazos', 'prazos.exercicio', 'users.notas'])
            ->find($turma);

        $nusers = $turma->users->count();
        foreach($turma->prazos as $prazo) {
            $arr = collect();
            foreach($turma->users as $user) {
                $notas = $user->notasValidas($prazo);
                $tentou = $notas->isNotEmpty();
                $notaFinal = $tentou ? $notas->max('nota') : 0;
                $notaFinalObj = $tentou? $notas->where('nota',$notaFinal)->first() : null;
                $tentativas = $tentou ? count($notas->where('created_at','<=',$notaFinalObj->created_at)) : 0;
                $primeiroerro = $tentou ? ($notaFinalObj->testes !== null ? array_keys(array_filter($notaFinalObj->testes)) : -1 ) : null;

                $arr->push([
                    'tentou' => $tentou,
                    'nota' =>  $notaFinal,
                    'tentativas' => $tentativas,
                    'primeiroerro' => $primeiroerro
                ]);
            }

            $tentaram = $arr->only('tentou')->count()/$nusers;
            $prazo->resumo = [
                'tentaram' => $tentaram,
                'notamaxima' => $arr->only('nota','100')->count()/$nusers,
                'tentativas' => $arr->average('tentativas'),
                'media' => $arr->average('nota'),
                'primeiroerro' => $tentaram ? $arr->mode('primeiroerro')[0] : ''
            ];
        }

        return View('relatorio.'.$tipo)
                ->with('turma', $turma)
                ->with('tipo', $tipo)
                ->with('turmas', Turma::all());
            ;
	}

}
