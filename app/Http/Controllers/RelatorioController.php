<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turma;
use App\Utils\TmpFile;

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
        // Prepare return
        $turmas = Turma::orderBy('created_at', 'DESC')->has('users')->get();
        // Validate
		$rules = array(
			'turma' => 'sometimes|int|exists:turmas,id',
			'tipo' => 'sometimes|in:realizacao,notas',
            'export' => 'sometimes|bool'
        );
        $data = $request->validate($rules);
        if(array_key_exists('turma',$data) && array_key_exists('tipo',$data)) {
            $turma = Turma::with(['users', 'prazos', 'prazos.exercicio', 'users.notas'])->find($data['turma']);
            $tipo = $data['tipo'];
            $export = $data['export'];

            if ($tipo == 'notas') {
                $table = $this->relatorioNotas($turma);
            } else {
                $table = $this->relatorioRealizacao($turma);
            }

            if ($export) {
                $filename = TmpFile::generateTmpFileName('relatorio-'.$tipo.'-'.$turma->name, '.csv');
                $file = fopen($filename,'w');
                // write csv
                foreach($table as $row) {
                    fputcsv($file,$row);
                }
                fclose($file);

                return response()->download($filename)->deleteFileAfterSend(true);
            }

            return View('relatorio.'.$tipo)
                    ->with('tabela', $table)
                    ->with('turma', $turma)
                    ->with('tipo', $tipo)
                    ->with('export', $export)
                    ->with('turmas', $turmas);

        } else {
            return View('relatorio.notas')
                ->with('turmas', $turmas);
        }
    }

    /** Relatório de notas
     *
     * @param Turma $turma
     */
    public function relatorioNotas (Turma $turma) {
        $prazos = $turma->prazos->sortBy('exercicio.name');
        $colnames = $prazos->pluck('exercicio.name')
                           ->prepend('Email')
                           ->prepend('Nome');
        $mytable = collect();
        $mytable->push($colnames->all());
        foreach ($turma->users->sortBy(['name','email']) as $user) {
            $notas = $prazos->map( function ($prazo) use ($user) {
                return $user->notaFinal($prazo);
            });
            $myrow = $notas->prepend($user->email)
                           ->prepend($user->name);

            $mytable->push($myrow->all());
        }

        return $mytable;
    }

    /** Relatório de realização
     *
     * @param Turma $turma
     */
    public function relatorioRealizacao (Turma $turma) {

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
                'name'  => $prazo->exercicio->name,
                'tentaram' => number_format(100*$tentaram/$nusers, 1)."%",
                'notamaxima' => $tentaram ? number_format(100*$arr->where('nota','100')->count()/$tentaram, 1)."%" : '' ,
                'tentativas' => number_format($arr->average('tentativas'), 1),
                'media' => $tentaram ? number_format($arr->average('nota'), 1) : "",
//                'primeiroerro' => $tentaram ? $arr->mode('primeiroerro')[0] : ''
            ];
        }

        $colnames = ['Exercício','Tentaram','Tiveram nota máxima', 'Média de Tentativas', 'Média de Notas'];
        $mytable = $turma->prazos->pluck('resumo');
        $mytable->prepend($colnames);
        return $mytable;
    }
}
