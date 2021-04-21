@extends('layouts.base')
@section('content')
    <div class="container">
		<div class="row">
			<h1>Carregar arquivo</h1>
		</div>
		<div class="row">
			<form action="{{URL::to("/arquivo")}}" method="POST" enctype="multipart/form-data">
			@csrf
			@include ('includes.error_alert')
			<input type="file" id="file" name="file" class="@error('filename') is-invalid @enderror" >
		    @error('file')
				<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
			<input type="text" name="filename" value="" id="filename" class="@error('filename') is-invalid @enderror" >
		    @error('filename')
				<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
			<button type="submit" class="btn btn-primary">Enviar</button>
			</form>
		</div>
    </div>
@endsection
