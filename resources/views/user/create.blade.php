@extends('layouts.base')
@section('content')
    <div class="container">
	<div class="row">
	    <h1>Criar novo usuário</h1>
	</div>
	<div class="row">
	    <form action="/user" method="POST">
		@csrf
		@if ($errors->any())
		    <div class="alert alert-danger" role="alert">
			    Please fix the following errors
		    </div>
		@endif
		<div class="form-group">
		    <label for="name">Nome</label>
		    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nome">
		    @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="email">E-mail</label>
		    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="exemplo@exemplo.usp.br" >
		    @error('email')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="password">Senha</label>
		    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="" >
		    @error('name')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<button type="submit" class="btn btn-primary">Criar</button>
	    </form>
	</div>
    </div>
    @endsection
