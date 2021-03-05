@extends('layouts.base')
@section('content')

<div class="container">
    <h1>{{ $user->name }}</h1>

    <p>{{ $user->email }}</p>
    <p>{{ $user->isAdmin() ? "Admin" : "Dicente" }}</p>
    <a class="btn btn-edit" href="{{ URL::to('user/' . $user->id . '/edit') }}">Editar</a>
</div>
    
<div class="container">
    <a class="collapse-button" data-toggle="collapse" href="#collapsePrazosFuturos" role="button" aria-expanded="true" aria-controls="collapsePrazosFuturos">
        <h2>Prazos Futuros</h2>
    </a>
    <div class="collapse {{$collapsed ?? "" ? "" : "show" }}" id="collapsePrazosFuturos">
        @include('prazo.table',['prazos' => $user->prazos->where('futuro')])
    </div>

    <a class="collapse-button" data-toggle="collapse" href="#collapsePrazosPassados" role="button" aria-expanded="true" aria-controls="collapsePrazosPassados">
        <h2>Notas Passadas</h2>
    </a>
    <div class="collapse show" id="collapsePrazosPassados">
        @include('prazo.table',['prazos' => $user->prazos->where('passado')])
    </div>


    <a class="collapse-button" data-toggle="collapse" href="#collapseTurmas" role="button" aria-expanded="true" aria-controls="collapseTurmas">
        <h2>Turmas</h2>
    </a>
    <div class="collapse show" id="collapseTurmas">
        @include('turma.table',['turmas' => $user->turmas, 'editButton' => false, 'removeButton' => true])
    </div>

    <a class="collapse-button" data-toggle="collapse" href="#collapseNotas" role="button" aria-expanded="true" aria-controls="collapseNotas">
        <h4>Todas as Notas</h4>
    </a>
    <div class="collapse" id="collapseNotas">
        <div class="alert alert-info">
            Esta tabela contém todas as notas já registradas para esse usuário. Note que para uma nota ser válida ela precisa ter data anterior ao prazo correspondente. Apenas a máxima nota válida é usada.
        </div>
        @include('nota.table',['notas' => $user->notas])
    </div>
</div>
@endsection
