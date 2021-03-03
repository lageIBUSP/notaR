@extends('layouts.base')
@section('content')
    <div class="container">
	<div class="row">
	    <h1>Criar nova turma</h1>
	</div>
	<div class="row">
	    <form action="/turma" method="{{ isset($turma) ? 'put' : 'post'}}">
		@csrf
		@include ('includes.error_alert')
		<div class="form-group">
		    <label for="name">Nome</label>
		    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nome da turma" value="{{ old('nome', isset($turma) ? $turma->name : '') }}">
		    @error('name')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="description">Descrição</label>
		    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Classe da disciplina XYZ do ano ABCD">{{ old('description') }}</textarea>
		    @error('description')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<button type="submit" class="btn btn-primary">Criar</button>
	    </form>
	</div>
    </div>
    @endsection
