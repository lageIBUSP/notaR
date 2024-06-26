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
        $this->authorize('list', User::class);
		return View('user.index')->with('users',User::with('turmas')->get());
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
			'password'  => 'required|min:8',
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
	 * @param  User $user
	 * @return \Illuminate\View\View
	 */
	public function show(User $user)
	{
		$this->authorize('view', $user);

        $prazos = $user->prazos->groupBy('futuro');
		$v = View('user.show')->with('user',$user);
        if ($prazos->isNotEmpty()) {
            if ($prazos->keys()->contains(0)) {
                $v = $v->with('prazosPassados',$prazos[0]);

            }
            if ($prazos->keys()->contains(1)) {
                $v = $v->with('prazosFuturos',$prazos[1]);
            }
        }
        return $v;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  User $user
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
	 * @param  User $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user)
	{
		$this->authorize('edit', $user);
		$rules = [
			'name'       => 'required',
			'email'      => 'required',
            'is_admin'  => 'sometimes|boolean',
			'password'  => 'sometimes|nullable|min:8',
            'addturma'  => 'sometimes|int|exists:turmas,id|nullable',
		];
		$data = $request->validate($rules);
        if(array_key_exists('password', $data) && !$data['password']) {
            unset($data['password']);
        }
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
	 * @param  User $user
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		$this->authorize('delete', $user);

        // remove de todas as turmas
        $user->turmas()->detach();
        $user->delete();
		return redirect()->action([get_class($this),'index']);
	}
}
