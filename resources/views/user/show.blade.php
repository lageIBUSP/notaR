@extends('layouts.base')
@section('content')

<div class="container">
    <h1>{{ $user->name }}</h1>

    <p>{{ $user->email }}</p>
    <p>{{ $user->isAdmin() ? "Professor" : "Aluno" }}</p>
    <a class="btn btn-edit" href="{{ URL::to('user/' . $user->id . '/edit') }}">Editar</a>
</div>

<div class="container">
    @if($prazosFuturos ?? '')
        <a class="collapse-button" data-toggle="collapse" href="#collapsePrazosFuturos" role="button" aria-expanded="true" aria-controls="collapsePrazosFuturos">
            <h2>Prazos Futuros</h2>
        </a>
        <div class="collapse {{$collapsed ?? "" ? "" : "show" }}" id="collapsePrazosFuturos">
            @include('prazo.table',['prazos' => $prazosFuturos])
        </div>
    @endif

    @if($prazosPassados ?? '')
        <a class="collapse-button" data-toggle="collapse" href="#collapsePrazosPassados" role="button" aria-expanded="true" aria-controls="collapsePrazosPassados">
            <h2>Notas Passadas</h2>
        </a>
        <div class="collapse show" id="collapsePrazosPassados">
            @include('prazo.table',['prazos' => $prazosPassados])
        </div>
    @endif

    <a class="collapse-button" data-toggle="collapse" href="#collapseTurmas" role="button" aria-expanded="true" aria-controls="collapseTurmas">
        <h2>Turmas</h2>
    </a>
    <div class="collapse show" id="collapseTurmas">
        @include('turma.table',['turmas' => $user->turmas, 'editButton' => false, 'removeButton' => true])
    </div>
</div>
@endsection
