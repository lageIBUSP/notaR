@extends('layouts.base')
@section('content')
    <div class="container">
	<div class="row">
	    <h1>Criar novo usuário</h1>
	</div>
	<div class="row">
	    <form action="/user" method="POST">
		@csrf
		@include ('includes.error_alert')
		<div class="form-group">
		    <label for="name">Nome</label>
		    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nome" value="{{old('name')}}">
		    @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="email">E-mail</label>
		    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="exemplo@exemplo.usp.br"  value="{{old('email')}}">
		    @error('email')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="password">Senha</label>
		    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="" >
		    @error('password')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <select id="is_admin" name="is_admin">
				<option value="1" >Professor</option>
				<option value="0" selected>Aluno</option>
			</select>
		    @error('is_admin')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<button type="submit" class="btn btn-primary">Criar</button>
	    </form>
	</div>
    </div>
    @endsection
