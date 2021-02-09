@extends('layouts.anonymous')
@section('content')
    <h1>nota<span class="R">R</span> <img src="{{ asset('img/logo.png') }}" title="Logo" class="logo"></h1>
	<div class="card" style="width: 18rem">
	<div class="card-body">
        @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @else
            <div class="mb-4 text-sm text-gray-600">
                Você receberá por e-mail um link para cadastrar uma nova senha
            </div>
        @endif
	    <form action="{{ route('password.email') }}" method="POST">
		@csrf
		<div class="form-group">
		    <label for="email">Email</label>
		    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="user@example.com" value="{{ old('email') }}">
		    @error('email')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

        <div class="form-group" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
            <button type="submit" class="btn btn-primary">Recuperar senha</button>
            <a class="small" href="{{ route('login') }}">
                Voltar
            </a>
        </div>

	    </form>
	</div>
    </div>
@endsection
