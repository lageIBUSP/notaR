<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Exercicio;
use App\Models\User;
use App\Models\Teste;
use Illuminate\Support\Facades\DB;

class ExercicioController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return View('exercicio.index')->with('exercicios',Exercicio::all());
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
			'pesos.*' => 'required|numeric|min:0'
		);
		$data = $request->validate($rules);

		// store
		DB::transaction(function() use ($data) {
			$exercicio = tap(new Exercicio($data))->save();

			$n = count($data['dicas']);
			for ($i = 0; $i < $n; $i++) {
				$teste = Teste::create(['condicao' => $data['condicoes'][$i],
										'dica' => $data['dicas'][$i],
										'peso' => $data['pesos'][$i],
										'exercicio_id' => $exercicio->id
										]);
			}
		});

		return redirect('/exercicio/'.$exercicio->id);
	}

	/**
	 * Show the profile of a given Exercicio.
	 *
     * @param  \App\Models\Exercicio  $exercicio
	 * @return \Illuminate\View\View
	 */
	public function show(Exercicio $exercicio)
	{
		return View('exercicio.show')->with('exercicio',$exercicio);
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

		// mock de resposta do R
		try {
			$cnx = new \Sentiweb\Rserve\Connection('r');
			$r = $cnx->evalString($data['codigo']);

			$respostaR = [
				'status' => 'success',
				'mensagem' => $r 
			];
		}
		catch (\Sentiweb\Rserve\Exception $e){
			$respostaR = [
				'status' => 'fail',
				'mensagem' => 'Ocorreu um erro na execução do seu código! Corrija e tente novamente.' 
			];
		}
		
		return View('exercicio.show')->with('exercicio',$exercicio)->
					with('respostaR',$respostaR)->with('codigo',$data['codigo']);
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
			'pesos.*' => 'required|numeric|min:-1'
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

		return redirect('/exercicio/'.$exercicio->id);
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
        return redirect('exercicio');
        //...
    }
}
