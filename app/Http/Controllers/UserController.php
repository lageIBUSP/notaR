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

		// store
		$user = tap(new User($data))->save();
		return redirect('user');
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
		return View('user.edit')->with('user',$user);
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
		$rules = array(
			'name'       => 'required',
			'email'      => 'required',
		);
		$data = $request->validate($rules);

        $user->update($data);
		return View('user.show')->with('user',$user);
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
        return redirect('user');
		//
	}
}
