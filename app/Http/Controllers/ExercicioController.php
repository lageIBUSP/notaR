<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Exercicio;
use App\Models\User;

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
			'titulo'       => 'required',
			'enunciado'=> 'required',
		);
		$data = $request->validate($rules);

		// store
		$exercicio = tap(new Exercicio($data))->save();
		return View('exercicio.show')->with('exercicio',$exercicio);
	}

	/**
	 * Show the profile of a given Exercicio.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View\View
	 */
	public function show($id)
	{
		$exercicio = Exercicio::findOrFail($id);
		return View('exercicio.show')->with('exercicio',$exercicio);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$exercicio = Exercicio::findOrFail($id);
		return View('exercicio.edit')->with('exercicio',$exercicio);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $exercicio = Exercicio::findOrFail($id);
        $this->authorize('edit',$exercicio);
        $rules = array(
                'titulo'       => 'required',
                'enunciado'=> 'required'
                );
        $data = $request->validate($rules);
        $exercicio->update($data);

        return View('exercicio.show')->with('exercicio',$exercicio);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
