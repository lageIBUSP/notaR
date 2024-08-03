@extends('layouts.base')
@section('content')
    <div class="container">
	<div class="row">
	    <h1>Criar novo curso</h1>
	</div>
	<div class="row">
	    <form action="{{URL::to("/curso")}}" method="POST">
		@csrf
		@include ('includes.error_alert')
		<div class="form-group">
		    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nome do curso" value="{{ old('name') }}">
		    @error('name')
				<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<button type="submit" class="btn btn-primary">Criar</button>
	    </form>
	</div>
    </div>
    @endsection
