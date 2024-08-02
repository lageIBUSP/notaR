@extends('layouts.base')
@section('content')

<h1>{{ $turma->name }}</h1>
    <div class="jumbotron">
        <p>{!! nl2br($turma->description) !!}</p>
    </div>

    @can('seeMembers', $turma)
        <a class="collapse-button" data-toggle="collapse" href="#collapseMembros" role="button" aria-expanded="true" aria-controls="collapseMembros">
            <h2>Membros</h2>
        </a>
        <div class="collapse show" id="collapseMembros">
            @can ('edit', $turma)
                @include('user.table',['users' => $turma->users,
                    'removeButton' => true])
            @else
                @include('user.table',['users' => $turma->users])
            @endcan
        </div>
    @endcan

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
            <h2>Prazos Passados</h2>
        </a>
        <div class="collapse" id="collapsePrazosPassados">
            @include('prazo.table',['prazos' => $prazosPassados])
        </div>
    @endif

    <div class="row gridline">
        @can ('edit', $turma)
            <a class="btn btn-edit" href="{{ URL::to('turma/' . $turma->id . '/edit') }}">Editar</a>
            <a class="btn btn-edit" href="{{ URL::to('turma/' . $turma->id . '/prazos') }}">Alterar prazos</a>
        @endcan
        @can ('delete', $turma)
        <form method="POST" action="{{URL::to("/turma/".$turma->id)}}">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <input type="submit" class="btn btn-danger delete" value="Deletar">
        </form>
        @endcan
    </div>

@endsection
