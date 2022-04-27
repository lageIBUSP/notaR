@extends('layouts.anonymous')
@section('content')
    <h1>nota<span class="R">R</span> <img src="{{ asset('img/logo.png') }}" title="Logo" class="logo"></h1>
	<div class="card" style="width: 18rem">
	<div class="card-body">
	    <form action="{{ route('login') }}" method="POST">
		@csrf
		<div class="form-group">
		    <label for="email">Email</label>
		    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="user@example.com" value="{{ old('email') }}">
		    @error('email')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="password">Senha</label>
		    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="">
		    @error('password')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
        <div class="form-group">
            <label for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">
                <span class="small">Continuar conectado
            </label>
        </div>
        <div class="form-group" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
            <a class="small" href="{{ route('password.request') }}">
                Esqueceu sua senha? Contate um admin!
            </a>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </div>
	    </form>
	</div>
    </div>
@endsection
