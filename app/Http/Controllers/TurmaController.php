<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Turma;
use App\Models\User;
use App\Models\Exercicio;
use App\Models\Prazo;

class TurmaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return View('turma.index')->with('turmas',Turma::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return View('turma.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->authorize('create', Turma::class);
		$rules = array(
			'name'       => 'required',
			'description'=> 'required',
		);
		$data = $request->validate($rules);

		// store
		$turma = tap(new Turma($data))->save();
		return View('turma.show')->with('turma',$turma);
	}

	/**
	 * Show the profile of a given Turma.
	 *
     * @param  \App\Models\Turma  $turma
	 * @return \Illuminate\View\View
	 */
	public function show(Turma $turma)
	{
		return View('turma.show')->with('turma',$turma);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
     * @param  \App\Models\Turma  $turma
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Turma $turma)
	{
		$this->authorize('edit', $turma);
		return View('turma.edit')->with('turma',$turma);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Turma $turma)
    {
        $this->authorize('edit',$turma);
        $rules = array(
                'name'       => 'required',
                'description'=> 'required'
                );
        $data = $request->validate($rules);
        $turma->update($data);

        // bulk add users
        if ($request->maillist ?? "") {
            $emails = explode("\n",$request->maillist);
            $pssw = $request->defaultpassword;
            foreach( $emails as $email ) {
                $newmember = User::where('email',$email)->first();
                if(!$newmember) {  
                    $newmember = User::create(['email' => $email]);
                    $newmember->password = $pssw;
                }
                $turma->users()->save($newmember);
            }
        }

        return View('turma.show')->with('turma',$turma);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Turma $turma)
    {
		$this->authorize('delete', $turma);
        $turma->delete();
        return redirect('turma');
    }
}
