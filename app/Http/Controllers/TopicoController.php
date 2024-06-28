<?php

namespace App\Http\Controllers;

use App\Models\Topico;
use App\Models\Exercicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TopicoController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $topicos = Topico::orderBy('order');
    /** @var \App\Models\User */
    $user = Auth::user();
    if (optional($user)->isAdmin()) {
      $topicos = $topicos->with('exercicios');
    } else {
      $topicos = $topicos->with('exerciciosPublished');
    }

    $semTopico = Exercicio::whereDoesntHave('topico')->orderBy('name');
    return View('topico.index')->with('topicos', $topicos->get())
      ->with('semTopico', $semTopico->get());
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return View('topico.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $this->authorize('create', Topico::class);
    $rules = array(
      'name' => 'required',
    );
    $data = $request->validate($rules);

    // set order of new Topico
    $data['order'] = Topico::max('order') + 1;

    // store
    $topico = tap(new Topico($data))->save();

    // redirect to show
    return redirect()->action([get_class($this), 'show'], ['topico' => $topico]);
  }

  /**
   * Display the specified resource.
   */
  public function show(Topico $topico)
  {
    // index is the same for exercicio and topico
    return redirect()->action([get_class($this), 'index']);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Topico $topico)
  {
    $this->authorize('edit', $topico);
    return View('topico.edit')->with('topico', $topico);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Topico $topico)
  {
    $this->authorize('edit', $topico);

    $rules = [
      'name' => 'required',
    ];
    $data = $request->validate($rules);
    $topico->update(['name' => $data['name']]);
    return redirect()->action([get_class($this), 'index']);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Topico $topico)
  {
    $this->authorize('delete', $topico);
    // remove exercicios
    $topico->exercicios()->detach();

    $topico->delete();
    return redirect()->action([get_class($this), 'index']);
  }

  /**
   * Show form for reordering of Topico
   */
  public function sort()
  {
    $this->authorize('sort', Topico::class);
    $topicos = Topico::orderBy('order')->get();

    return View('topico.sort')->with('topicos', $topicos);
  }

  /**
   * Update order of topicos
   */
  public function order(Request $request)
  {
    $this->authorize('sort', Topico::class);
    $rules = [
      'topico_id.*' => 'required|int',
    ];

    $data = $request->validate($rules);

    // We want to commit all changes at once
    DB::beginTransaction();
    foreach($data['topico_id'] as $i => $id) {
      $model = Topico::find($id);
      $model->update(['order' => $i]);
    }
    DB::commit();

    return redirect()->action([get_class($this), 'index']);
  }
}
