<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Turma;
use App\Models\Curso;
use App\Models\User;
use App\Models\Exercicio;
use App\Models\Prazo;
use App\Rules\CsvRule;
use App\Utils\Csv;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TurmaController extends Controller
{
	/**
	 * Validate model input
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return mixed
	 */
	private function validateRequest(Request $request, Turma|null $model = null)
	{
        $rules = [
            'name'       => 'required|unique:turmas' . ($model ? ',name,' . $model->id : ''),
            'description'=> 'required',
			'curso_id' => 'sometimes|int|exists:cursos,id|nullable',
            'maillist'   => [
                'file',
                new CsvRule([
                    'name' => 'required',
                    'email' => 'required|email'
                ])
            ],
            'defaultpassword' => 'required_with:maillist',
            'copyfrom' => 'int|exists:turmas,id|nullable',
            'datainicial' => 'date|nullable'
        ];

        $data = $request->validate($rules);
        return ['name' => $data['name'], 'description' => $data['description'], 'curso_id' => $data['curso_id']];
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
        return redirect()->action([CursoController::class, 'index']);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return View
	 */
	public function create()
	{
		$this->authorize('create', Turma::class);
		return View('turma.create')
            ->with('turmas', Turma::all())
            ->with('cursos', Curso::all());
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
        $data = $this->validateRequest($request);

        DB::beginTransaction();
		// store
		$turma = tap(new Turma($data))->save();

        // bulk add users
        if ($request->maillist ?? "") {
            $this->bulkAddUsers($turma,
                new Csv($request->maillist->get()),
                $request->defaultpassword);
        }

        // copy prazos from another turma
        if ($request->copyfrom ?? "") {
            $original = Turma::find($request->copyfrom);
            if ($request->datainicial ?? "") {
                $original_firstdate = Carbon::parse($original->prazos()->min('prazo'));
                $new_firstdate = Carbon::parse($request->datainicial);
                $date_shift = $original_firstdate->diffInDays($new_firstdate);
            }
            foreach ($original->prazos as $prazo) {
                $newprazo = $prazo->replicate();
                if ($request->datainicial ?? "") {
                    $newprazo->shiftBy($date_shift);
                }
                $turma->prazos()->save($newprazo);
            }
        }
        DB::commit();

		return redirect()->action([get_class($this),'show'], ['turma' => $turma]);
	}

	/**
	 * Show the profile of a given Turma.
	 *
     * @param  \App\Models\Turma  $turma
	 * @return \Illuminate\View\View
	 */
	public function show(Turma $turma)
	{
        $prazos = $turma->prazosOrdered()->get()->groupBy('futuro');
		$v = View('turma.show')->with('turma',$turma);

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
     * @param  \App\Models\Turma  $turma
	 * @return View
	 */
	public function edit(Turma $turma)
	{
		$this->authorize('edit', $turma);

        $prazos = $turma->prazosOrdered()->get()->groupBy('futuro');
		$v = View('turma.edit')->with('turma',$turma)
            ->with('cursos', Curso::all());

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
	 * Show the form for editing the prazos
	 *
     * @param  \App\Models\Turma  $turma
	 * @return View
	 */
	public function editprazos(Turma $turma)
	{
		$this->authorize('edit', $turma);
		return View('turma.prazos')->with('turma',$turma)
        ->with('exercicios',Exercicio::orderBy('name')->get());
	}

    /**
     * Update the prazos in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function updateprazos(Request $request, Turma $turma)
	{
		$this->authorize('edit', $turma);
        $rules = array([
            'prazos' => 'required|array',
            'prazos.*' => 'nullable|date'
           ]);

        $validator = Validator::make($request->all(), $rules);
        $data = $validator->valid()['prazos'];

        foreach($data as $ex => $prazo) {
            $oldprazo = $turma->prazos->where('exercicio_id',$ex)->first();
            if($oldprazo) {
                if($prazo) {
                    $oldprazo->update(['prazo'=>$prazo]);
                }
                else {
                    $oldprazo->delete();
                }
            }
            else {
                if($prazo) {
                    Prazo::create(['prazo'=>$prazo
                                  ,'turma_id'=>$turma->id
                                  ,'exercicio_id'=>$ex
                                  ]);
                }
            }
        }

		return redirect()->action([get_class($this),'show'], ['turma' => $turma]);
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
        $data = $this->validateRequest($request, $turma);
        $turma->update($data);

        // bulk add users
        if ($request->maillist ?? "") {
            $this->bulkAddUsers($turma,
                new Csv($request->maillist->get()),
                $request->defaultpassword);
        }

		return redirect()->action([get_class($this),'show'], ['turma' => $turma]);

    }

	/**
	 * Remove user from turma
	 *
     * @param  \App\Models\Turma  $turma
     * @param  \App\Models\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function remove(Turma $turma, User $user)
	{
		$this->authorize('edit', $turma);
        $turma->users()->detach($user->id);
		return redirect()->action([get_class($this),'show'], ['turma' => $turma]);
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
        // remove users
        $turma->users()->detach();
        // remove prazos
        $turma->prazos()->delete();


        $turma->delete();
		return redirect()->action([get_class($this),'index']);
    }

    protected function bulkAddUsers (Turma $turma, Csv $csv, String $psswd)
    {
        foreach( $csv->getData() as $user ) {
            $email = $user['email'];
            $name = $user['name'];
            $newmember = User::where('email', $email)->first();
            if($newmember) {
                // if user not in turma, add
                if ($turma->users()->find($newmember) == null) {
                    $turma->users()->save($newmember);
                }
            } else {
                // if user doesn't exist, create new
                $newmember = User::create([
                    'email' => $email,
                    'name' => $name,
                    'password' => $psswd]);
                $turma->users()->save($newmember);
            }
        }
    }
}
