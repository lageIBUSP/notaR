@extends('layouts.base')
@section('content')

<h1>{{ $user->name }}</h1>
        <p>{{ $user->email }}</p>
    <a class="btn btn-edit" href="{{ URL::to('user/' . $user->id . '/edit') }}">Editar</a>

    <a class="collapse-button" data-toggle="collapse" href="#collapseTurmas" role="button" aria-expanded="true" aria-controls="collapseTurmas">
        <h2>Turmas</h2>
    </a>
    <div class="collapse show" id="collapseTurmas">
        @include('turma.table',['turmas' => $user->turmas, 'editButton' => false, 'removeButton' => true])
    </div>

    <a class="collapse-button" data-toggle="collapse" href="#collapsePrazos" role="button" aria-expanded="true" aria-controls="collapsePrazos">
        <h2>Prazos</h2>
    </a>
    <div class="collapse show" id="collapsePrazos">
        @include('prazo.table',['prazos' => $user->prazos])
    </div>

    <a class="collapse-button" data-toggle="collapse" href="#collapseNotas" role="button" aria-expanded="true" aria-controls="collapseNotas">
        <h2>Todas as Notas</h2>
    </a>
    <div class="collapse show" id="collapseNotas">
        @include('nota.table',['notas' => $user->notas])
    </div>
    
    <a class="btn btn-delete" href="{{ URL::to('user/' . $user->id . '/delete') }}">Deletar</a>

@endsection
