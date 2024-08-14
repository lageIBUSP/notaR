@extends('layouts.base')
@section('content')

<div class="container">
    <h1>{{ $user->name }}</h1>

    <p>{{ $user->email }}</p>
    <p>{{ $user->isAdmin() ? "Professor" : "Aluno" }}</p>
    <a class="btn btn-edit" href="{{ URL::to('user/' . $user->id . '/edit') }}">Editar</a>
</div>

<div class="container">

    @if($prazosPassados ?? '')
        <a class="collapse-button collapsed" data-toggle="collapse"
			href="#collapsePrazosPassados"
			role="button" aria-expanded="false"
			aria-controls="collapsePrazosPassados">
            <h2>
                Notas Passadas
				<i class="fa fa-chevron-right rotate"></i>
			</h2>
        </a>
        <div class="collapse" id="collapsePrazosPassados">
            @include('prazo.table',['prazos' => $prazosPassados])
        </div>
    @endif

    @if($prazosFuturos ?? '')
        <a class="collapse-button collapsed" data-toggle="collapse"
			href="#collapsePrazosFuturos"
			role="button" aria-expanded="false"
			aria-controls="collapsePrazosFuturos">
            <h2>
				Prazos Futuros
				<i class="fa fa-chevron-right rotate"></i>
			</h2>
        </a>
        <div class="collapse" id="collapsePrazosFuturos">
            @include('prazo.table',['prazos' => $prazosFuturos])
        </div>

    @endif

    <a class="collapse-button" data-toggle="collapse"
        href="#collapseTurmas"
        role="button" aria-expanded="true"
        aria-controls="collapseTurmas">
        <h2>
            Turmas
            <i class="fa fa-chevron-right rotate"></i>
        </h2>
    </a>
    <div class="collapse show" id="collapseTurmas">
        @include('turma.table',['turmas' => $user->turmas, 'editButton' => false, 'removeButton' => true])
    </div>
</div>
@endsection
