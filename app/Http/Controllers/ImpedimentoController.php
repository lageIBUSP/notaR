<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Impedimento;

class ImpedimentoController extends Controller
{
    /**
     * List impedimentos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return View('impedimento.index')->with('impedimentos',Impedimento::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->authorize('create', Impedimento::class);
		return View('impedimento.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->authorize('create', Impedimento::class);
		$rules = array(
			'palavra'      => 'required|string',
		);
		$data = $request->validate($rules);
		// store
		$impedimento = tap(new Impedimento($data))->save();
		return redirect()->action([ImpedimentoController::class,'index']);
	}

	/**
	 * Show the profile of a given Impedimento.
	 *
	 * @param  App\Models\Impedimento $impedimento
	 * @return \Illuminate\View\View
	 */
	public function show(Impedimento $impedimento)
	{
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  App\Models\Impedimento $impedimento
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Impedimento $impedimento)
	{
		$this->authorize('edit', $impedimento);
		return View('impedimento.edit')->with('impedimento',$impedimento);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  App\Models\Impedimento $impedimento
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Impedimento $impedimento)
	{
		$this->authorize('edit', $impedimento);
		$rules = array(
			'palavra'       => 'required|string',
		);
		$data = $request->validate($rules);

        $impedimento->update($data);
		return $this->index();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  App\Models\Impedimento $impedimento
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Impedimento $impedimento)
	{
		$this->authorize('delete', $impedimento);
        $impedimento->delete();
		return $this->index();
	}
}
