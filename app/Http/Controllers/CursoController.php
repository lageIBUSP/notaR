<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Turma;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Curso::orderBy('name');
        $semCurso = Turma::whereDoesntHave('curso');
        /** @var \App\Models\User */
        $cursos = $cursos->with('turmas');

        return View('curso.index')->with('cursos', $cursos->get())
            ->with('semCurso', $semCurso->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View('curso.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Curso::class);
        $rules = array(
            'name' => 'required',
        );
        $data = $request->validate($rules);

        // store
        $curso = tap(new Curso($data))->save();

        // redirect to show
        return redirect()->action([get_class($this), 'show'], ['curso' => $curso]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        // index is the same for turma and curso
        return redirect()->action([get_class($this), 'index']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        $this->authorize('edit', $curso);
        return View('curso.edit')->with('curso', $curso);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        $this->authorize('edit', $curso);

        $rules = [
            'name' => 'required',
        ];
        $data = $request->validate($rules);
        $curso->update(['name' => $data['name']]);
        return redirect()->action([get_class($this), 'index']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        $this->authorize('delete', $curso);
        // remove turmas
        $curso->turmas()->detach();

        $curso->delete();
        return redirect()->action([get_class($this), 'index']);
    }

}
