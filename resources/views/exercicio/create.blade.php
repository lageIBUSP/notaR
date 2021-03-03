@extends('layouts.base')
@section('content')
<div class="container">
	<div class="row">
	    <h1>Criar novo exercício</h1>
	</div>
	<div class="row">
	    <form action="/exercicio" method="POST">
		@csrf
        @method (isset($exercicio) ? 'put' : 'post')
		@include ('includes.error_alert')

		<div class="form-group">
		    <label for="name">Título</label>
		    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Título do exercício" value="{{ old('name') }}">
		    @error('name')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

		<div class="form-group">
		    <label for="description">Enunciado</label>
		    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Salve o resultado da estatística xyz na variável abc">{{ old('description') }}</textarea>
		    @error('description')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

        <div class="form-group">
		    <label for="precondicoes">Pré-condições</label>
		    <textarea class="form-control @error('precondicoes') is-invalid @enderror" id="precondicoes" name="precondicoes" placeholder="Código rodado antes da correção">{{ old('precondicoes') }}</textarea>
		    @error('precondicoes')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<button type="submit" class="btn btn-primary">Criar</button>
	    </form>
	</div>
    </div>
    @endsection
