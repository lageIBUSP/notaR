@extends('layouts.anonymous')
@section('content')
    <h1>nota<span class="R">R</span> <img src="{{ asset('img/logo.png') }}" title="Logo" class="logo"></h1>
	<div class="card" style="width: 18rem">
	<div class="card-body">
	    <form action="{{ route('password.update') }}" method="POST">
		@csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

		<div class="form-group">
		    <label for="email">Email</label>
		    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $request->email) }}">
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
		    <label for="password_confirmation">Confirmar senha</label>
		    <input type="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="">
		    @error('password_confirmation')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
        <div class="form-group" style="display: flex; flex-direction: row; justify-content: center; align-items: center;">
            <button type="submit" class="btn btn-primary">Redefinir senha</button>
        </div>
	    </form>
	</div>
    </div>
@endsection
