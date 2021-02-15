<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Turma;

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
			'description'=> 'required'
		);
		$data = $request->validate($rules);

		// store
		$turma = tap(new Turma($data))->save();
		return View('turma.show')->with('turma',$turma);
	}

	/**
	 * Show the profile of a given Turma.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View\View
	 */
	public function show($id)
	{
		$turma = Turma::findOrFail($id);
		return View('turma.show')->with('turma',$turma);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$turma = Turma::findOrFail($id);
		return View('turma.edit')->with('turma',$turma);
	}

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
                if ($this->somethingElseIsInvalid()) {
                $validator->errors()->add('field', 'Something is wrong with this field!');
                }
                });
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
        $turma = Turma::findOrFail($id);
        $this->authorize('edit',$turma);
        $rules = array(
                'name'       => 'required',
                'description'=> 'required'
                );
        $data = $request->validate($rules);
        $turma->update($data);

dd($request);
die();
        if (isset($data->maillist)) {
            $emails = explode("\n",$data->maillist);
            $pssw = $data->defaultpassword;
            foreach( $emails as $email ) {
                $newmember = User::updateOrCreate(['email' => $email],[]);
                if ($newmember->password == "") $newmember->update(['password' => Hash::make($pssw)]);
                $turma->users->save($user);
            }
        }

        return View('turma.show')->with('turma',$turma);
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
