@extends('layouts.base')
@section('content')
    <div class="container">
	<div class="row">
	    <h1>Editando usuário</h1>
	</div>
	<div class="row">
	    <form action={{"/user/".$user->id}} method="POST">
		@csrf
        @method ('PUT')
		@include ('includes.error_alert')
		<div class="form-group">
		    <label for="name">Nome</label>
		    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nome" value="{{old('name',$user->name)}}">
		    @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="email">E-mail</label>
		    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email',$user->email)}}">
		    @error('email')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		@if(Auth::user()->isAdmin())
		<div class="form-group">
		    <label for="is_admin">Tipo de usuário</label>
		    <select id="is_admin" name="is_admin">
				<option value="1" {{$user->isAdmin()?"selected":""}}>Professor</option>
				<option value="0" {{$user->isAdmin()?"":"selected"}}>Aluno</option>
			</select>
		    @error('is_admin')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
        @endif
		<button type="submit" class="btn btn-primary">Salvar</button>

	    </form>

		@can ('delete', $user)
		<form method="POST" action="/user/{{$user->id}}">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}

			<div class="form-group">
				<input type="submit" class="btn btn-delete delete" value="Deletar">
			</div>
		</form>
		@endcan

	</div>
    </div>
    @endsection
