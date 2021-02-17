@extends('layouts.base')
@section('content')

<h1>{{ $turma->name }}</h1>
    <div class="jumbotron">
        <p>{{ $turma->description }}</p>
    </div>
    <a class="collapse-button" data-toggle="collapse" href="#collapseMembros" role="button" aria-expanded="true" aria-controls="collapseMembros">
        <h2>Membros</h2>
    </a>
    <div class="collapse" id="collapseMembros">
        @include('user.table',['users' => $turma->users, 'editButton' => true, 'removeButton' => true])
    </div>

    <a class="collapse-button" data-toggle="collapse" href="#collapsePrazos" role="button" aria-expanded="true" aria-controls="collapsePrazos">
        <h2>Prazos</h2>
    </a>
    <div class="collapse" id="collapsePrazos">
        @include('prazo.table',['prazos' => $turma->prazos, 'editButton' => true, 'removeButton' => true])
    </div>
    
    @can ('edit', $turma)
        <a class="btn btn-edit" href="{{ URL::to('turma/' . $turma->id . '/edit') }}">Editar</a>
    @endcan
    @can ('delete', $turma)
        <a class="btn btn-delete" href="{{ URL::to('turma/' . $turma->id . '/delete') }}">Deletar</a>
    @endcan

@endsection
