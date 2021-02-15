@extends('layouts.base')
@section('content')

    <div class="container">
	<div class="row">
        <h1>Editando {{ $turma->name }}</h1>
	</div>
	<div class="row">
	    <form action={{'/turma/'.$turma->id}} method="POST">
		@csrf
        @method('PUT')
		@if ($errors->any())
		    <div class="alert alert-danger" role="alert">
			Please fix the following errors
		    </div>
		@endif
		<div class="form-group">
		    <label for="name">Nome</label>
		    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('nome', $turma->name) }}">
		    @error('name')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="description">Descrição</label>
		    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description',$turma->description) }}</textarea>
		    @error('description')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="defaultpassword">Senha padrão para os novos alunos</label>
		    <input type="text" class="form-control @error('defaultpassword') is-invalid @enderror" id="defaultpassword" name="defaultpassword">
		    @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="maillist">Adicionar alunos por e-mail (um e-mail por linha) </label>
		    <textarea class="form-control @error('maillist') is-invalid @enderror" id="maillist" name="maillist"></textarea>
		    @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

		<button type="submit" class="btn btn-primary">Salvar</button>
	    </form>

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
    
    <a class="btn btn-edit" href="{{ URL::to('turma/' . $turma->id . '/edit') }}">Editar</a>
    <a class="btn btn-delete" href="{{ URL::to('turma/' . $turma->id . '/delete') }}">Deletar</a>

	</div>
    </div>
@endsection
