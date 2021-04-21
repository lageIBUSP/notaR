<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * List users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return View('user.index')->with('users',User::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->authorize('create', User::class);
		return View('user.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->authorize('create', User::class);
		$rules = array(
			'name'      => 'required',
			'email'     => 'required|unique:users',
			'password'  => 'required',
            'is_admin'  => 'sometimes|boolean'
		);
		$data = $request->validate($rules);
        $user = new User($data);
        if(array_key_exists('is_admin', $data)) {
            $this->authorize('makeAdmin',$user);
        }

		// store
        $user->save();
		return redirect()->action([get_class($this),'show'],['user' => $user]);
	}

	/**
	 * Show the profile of a given User.
	 *
	 * @param  App\Models\User $user
	 * @return \Illuminate\View\View
	 */
	public function show(User $user)
	{
		$this->authorize('view', $user);
		return View('user.show')->with('user',$user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  App\Models\User $user
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user)
	{
		$this->authorize('edit', $user);
		return View('user.edit')
				->with('user',$user)
				->with('turmas', \App\Models\Turma::all())
				;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  App\Models\User $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user)
	{
		$this->authorize('edit', $user);
		$rules = [
			'name'       => 'required',
			'email'      => 'required',
            'is_admin'  => 'sometimes|boolean',
            'addturma'  => 'sometimes|int|exists:turmas,id|nullable',
		];
		$data = $request->validate($rules);
        if(isset($data['is_admin'])) {
            $this->authorize('makeAdmin',$user);
        }

        if(isset($data['addturma']) && $data['addturma']) {
			$turma = \App\Models\Turma::find($data['addturma']);
			$this->authorize('edit',$turma);
			$user->turmas()->save($turma);
        }
        $user->update($data);
		return redirect()->action([get_class($this),'show'],['user' => $user]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  App\Models\User $user
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		$this->authorize('delete', $user);
        $user->delete();
		return redirect()->action([get_class($this),'index']);
	}
}
