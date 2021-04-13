<?php

namespace App\Http\Controllers;

use App\Models\Prazo;
use Illuminate\Http\Request;

class PrazoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prazo  $prazo
     * @return \Illuminate\Http\Response
     */
    public function show(Prazo $prazo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prazo  $prazo
     * @return \Illuminate\Http\Response
     */
    public function edit(Prazo $prazo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prazo  $prazo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prazo $prazo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prazo  $prazo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prazo $prazo)
    {
		$this->authorize('delete', $prazo);
        $turma = $prazo->turma;
        $prazo->delete();
		return $this->show($turma);
    }
}
