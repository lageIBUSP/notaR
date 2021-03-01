@extends('layouts.base')
@section('content')

<h1>{{ $turma->name }}</h1>
    <div class="jumbotron">
        <p>{{ $turma->description }}</p>
    </div>
    <a class="collapse-button" data-toggle="collapse" href="#collapseMembros" role="button" aria-expanded="true" aria-controls="collapseMembros">
        <h2>Membros</h2>
    </a>
    <div class="collapse show" id="collapseMembros">
        @include('user.table',['users' => $turma->users, 'editButton' => true, 'removeButton' => true])
    </div>

    <a class="collapse-button" data-toggle="collapse" href="#collapsePrazosFuturos" role="button" aria-expanded="true" aria-controls="collapsePrazosFuturos">
        <h2>Prazos Futuros</h2>
    </a>
    <div class="collapse {{$collapsed ?? "" ? "" : "show" }}" id="collapsePrazosFuturos">
        @include('prazo.table',['prazos' => $turma->prazos->where('futuro')])
    </div>

    <a class="collapse-button" data-toggle="collapse" href="#collapsePrazosPassados" role="button" aria-expanded="true" aria-controls="collapsePrazosPassados">
        <h2>Prazos Passados</h2>
    </a>
    <div class="collapse" id="collapsePrazosPassados">
        @include('prazo.table',['prazos' => $turma->prazos->where('passado')])
    </div>

    
    @can ('edit', $turma)
        <a class="btn btn-edit" href="{{ URL::to('turma/' . $turma->id . '/edit') }}">Editar</a>
    @endcan
    @can ('delete', $turma)
     <form method="POST" action="/turma/{{$turma->id}}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <div class="form-group">
            <input type="submit" class="btn btn-danger delete" value="Deletar">
        </div>
    </form>
    @endcan

@endsection
