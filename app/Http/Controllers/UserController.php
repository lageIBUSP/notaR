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
			'email'     => 'required',
			'password'  => 'required'
		);
		$data = $request->validate($rules);

		// store
		$user = tap(new User($data))->save();
		return redirect('user');
	}

	/**
	 * Show the profile of a given User.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View\View
	 */
	public function show($id)
	{
		$user = User::findOrFail($id);
		$this->authorize('view', $user);
		return View('user.show')->with('user',$user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$user = User::findOrFail($id);
		$this->authorize('edit', $user);
		return View('user.edit')->with('user',$user);
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
		$user = User::findOrFail($id);
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
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$user = User::findOrFail($id);
		$this->authorize('delete', $user);
		//
	}
}
