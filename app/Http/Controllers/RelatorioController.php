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
        $turmas = Turma::orderBy('created_at', 'DESC')->has('users')->get();
		$rules = array(
			'turma' => 'sometimes|int|exists:turmas,id',
			'tipo' => 'sometimes|in:realizacao,notas'
        );
        $data = $request->validate($rules);
        if(array_key_exists('turma',$data) && array_key_exists('tipo',$data)) {
            return $this->relatorio($data['turma'], $data['tipo']);
        } else {
            return redirect()->action(
                [self::class, 'index'],
                ['turma' => $turmas->first()->id, 'tipo' => 'notas']
            );
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

                if ($tentou) {
                    $notaFinal = $notas->max('nota');
                    $notaFinalObj = $notas->where('nota',$notaFinal)->first();
                    $tentativas = count($notas->where('created_at','<=',$notaFinalObj->created_at));
                    $primeiroerro = $notaFinalObj->testes !== null ? array_keys(array_filter($notaFinalObj->testes)) : -1;

                    $arr->push([
                        'tentou' => $tentou,
                        'nota' =>  $notaFinal,
                        'tentativas' => $tentativas,
                        'primeiroerro' => $primeiroerro
                    ]);
                }
            }

            $tentaram = $arr->count();
            $prazo->resumo = [
                'tentaram' => number_format(100*$tentaram/$nusers, 1),
                'notamaxima' => $tentaram ? number_format(100*$arr->where('nota','100')->count()/$tentaram, 1) : '',
                'tentativas' => number_format($arr->average('tentativas'), 1),
                'media' => $tentaram ? number_format($arr->average('nota'), 1) ."%" : "",
//                'primeiroerro' => $tentaram ? $arr->mode('primeiroerro')[0] : ''
            ];
        }

        $turmas = Turma::orderBy('created_at', 'DESC')->has('users')->get();

        return View('relatorio.'.$tipo)
                ->with('turma', $turma)
                ->with('tipo', $tipo)
                ->with('turmas', $turmas);
	}

}
