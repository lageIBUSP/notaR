<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Exercicio;
use App\Models\User;
use App\Models\Teste;
use App\Models\Impedimento;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ExercicioController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$exercicios = Exercicio::orderBy('name');
		if(!(Auth::user() && Auth::user()->isAdmin())) {
			$exercicios = $exercicios->published();
		}
		return View('exercicio.index')->with('exercicios',$exercicios->get());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->authorize('create', Exercicio::class);
		return View('exercicio.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->authorize('create', Exercicio::class);
		$rules = array(
			'name'       => 'required|string|unique:exercicios',
			'description'=> 'required',
			'precondicoes'=>'sometimes',
			'dicas'	=> 'array',
			'condicoes' => 'array',
			'pesos' => 'array',
			'dicas.*'	=> 'required',
			'condicoes.*' => 'required',
			'pesos.*' => 'required|numeric|min:0',
			'draft' => 'required|boolean',
		);
		$data = $request->validate($rules);

		// store
		$exercicio = new Exercicio($data);
		DB::transaction(function() use ($data, $exercicio) {
			$exercicio->save();

			$n = count($data['dicas']);
			for ($i = 0; $i < $n; $i++) {
				Teste::create(['condicao' => $data['condicoes'][$i],
								'dica' => $data['dicas'][$i],
								'peso' => $data['pesos'][$i],
								'exercicio_id' => $exercicio->id
								]);
			}
		});

		return $this->show($exercicio);
	}

	/**
	 * Show the profile of a given Exercicio.
	 *
     * @param  \App\Models\Exercicio  $exercicio
	 * @return \Illuminate\View\View
	 */
	public function show(Exercicio $exercicio)
	{
		$this->authorize('view', $exercicio);
		return View('exercicio.show')->with('exercicio',$exercicio);
	}

	/**
	 * Roda o corretoR usando o código
	 *
	 * @param  Exercicio $exercicio
     * @param  string $codigo
	 * @return Array
	 */
	private function corretoR (Exercicio $exercicio, string $file) {
		// resposta do R
		try {
			$cnx = new \Sentiweb\Rserve\Connection('r');

			$rcode = 'source("/usr/local/src/notar/corretor.R");'
					// database auth
					. 'dbusr  <- "'. env('DB_USERNAME') . '";'
					. 'dbpass <- "'. env('DB_PASSWORD') . '";'
					. 'dbname <- "'. env('DB_DATABASE') . '";'
					. 'con <- connect(dbusr, dbpass, dbname);'
					// import files
					. 'file.copy(list.files("/arquivos/",recursive=TRUE,full.names=TRUE),".");'
					// run corretoR
					. 'res <- notaR('. $exercicio->id .',"'.$file.'");'
					. 'unlink("*",recursive=TRUE);'
					. 'res;'
					;
			$r = $cnx->evalString($rcode);
		}
		catch (\Sentiweb\Rserve\Exception $e){
			return [
				'status' => 'danger',
				'mensagem' => 'Ocorreu um erro na correção do exercício! Por favor verifique seu código ou contate um administrador.' ,
				'resultado' => null,
				'nota' => 0
			];
		}
		
		// syntax error
		if ($r === null) {
			return [
				'status' => 'danger',
				'mensagem' => 'Ocorreu um erro na execução do seu código! Corrija e tente novamente.' ,
				'resultado' => $r,
				'nota' => 0
			];
		}

		// garantee that $r is an array ffs
		if(is_bool($r)) {
			$r = [$r];
		}

		// 100%
		if(in_array(false, $r, true) === false) {
			return [
				'status' => 'success',
				'mensagem' => 'Parabéns! Seu código passou em todos os testes! <br>'
							. 'Toca aqui!',
				'resultado' => $r,
				'nota' => 100
			];
		}

		// pega lista de testes
		$testes = $exercicio->testes;
		// calcula nota
		$nota = 0;
		$firstmistake = -1;
		for($i = 0; $i<count($testes); $i++) {
			if($r[$i]) {
				$nota += $testes[$i]->peso;
			}
			else if ($firstmistake == -1) {
				$firstmistake = $i;
			} 
		}
		$dica = $testes[$firstmistake]->dica;
		$notamax = $testes->sum('peso');
		$notanormalizada = 100*$nota/$notamax;

		return [
			'status' => 'warning',
			'mensagem' => $dica,
			'resultado' => $r,
			'nota' => $notanormalizada
		];

	}

	/**
	 * Ação de fazer exercício usando o form
	 *
	 * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exercicio  $exercicio
	 * @return \Illuminate\View\View
	 */
	public function submit(Request $request, Exercicio $exercicio)
	{
		$rules = array(
			'codigo' => 'required'
		);
		$data = $request->validate($rules);

		$validator = Validator::make($request->all(), $rules);

		$validator->after(function ($validator) use($data) {
			foreach(Impedimento::all()->pluck('palavra') as $palavra) {
				if (Str::contains($data['codigo'],$palavra)) {
					$validator->errors()->add(
						'codigo', 'Código não pode conter a palavra: '.$palavra
					);
				}
			}
		});
        if ($validator->fails()) {
            return redirect(URL::to('exercicio/'.$exercicio->id))
                        ->withErrors($validator)
                        ->withInput();
        }

		// corrigir EOL
		$codigo = str_replace("\r\n","\n",$data['codigo']);

		// salva um arquivo com o codigo
		$tempfile = '/temp/_'.time().md5($codigo);
		Storage::put($tempfile, $codigo);
		// corrige
		$respostaR = $this->corretoR($exercicio,$tempfile);
		// deleta arquivo temporário
		Storage::delete($tempfile);

		// salvar nota no banco de dados
		if(Auth::user() && !$exercicio->draft) {
			$exercicio->notas()->create([
				'nota' => $respostaR['nota'],
				'user_id' => Auth::user()->id,
				'testes' => $respostaR['resultado'],
				'codigo' => $codigo
			]);
		}
		
		return View('exercicio.show')->with('exercicio', $exercicio)->
					with('respostaR', $respostaR)->
					with('codigo', $codigo);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
     * @param  \App\Models\Exercicio  $exercicio
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Exercicio $exercicio)
	{
		$this->authorize('edit', $exercicio);
		return View('exercicio.edit')->with('exercicio',$exercicio)->with('exercicio.testes',$exercicio->testes);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exercicio  $exercicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exercicio $exercicio)
    {
        $this->authorize('edit',$exercicio);
        $rules = array(
			'name'       => 'required|string|unique:exercicios,name,'.$exercicio->id,
			'description'=> 'required',
			'precondicoes'=>'sometimes',
			'dicas'	=> 'array',
			'condicoes' => 'array',
			'pesos' => 'array',
			'dicas.*'	=> 'required',
			'condicoes.*' => 'required',
			'pesos.*' => 'required|numeric|min:-1',
			'draft' => 'required|boolean',
		);
		$data = $request->validate($rules);

		// store
		DB::transaction(function() use ($data, $exercicio) {
			$n = count($data['dicas']);
			$exercicio->update($data);
			$exercicio->testes()->delete(); // delete all testes because we're lazy
			for ($i = 0; $i < $n; $i++) {
				$teste = Teste::create(['condicao' => $data['condicoes'][$i],
										'dica' => $data['dicas'][$i],
										'peso' => $data['pesos'][$i],
										'exercicio_id' => $exercicio->id
										]);
			}
		});

		return $this->show($exercicio);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exercicio  $exercicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exercicio $exercicio)
    {
		$this->authorize('delete', $exercicio);
        $exercicio->delete();
		return $this->index();
    }
}
