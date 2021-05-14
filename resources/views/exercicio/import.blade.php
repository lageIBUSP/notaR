@extends('layouts.base')
@section('content')
    <div class="container">
		<div class="row">
			<h1>Carregar exercício em formato JSON</h1>
		</div>
		<div class="row">
			<form action="{{ route('exercicio.import') }}" method="POST" enctype="multipart/form-data">
			@csrf
			@include ('includes.error_alert')
			<input type="file" id="file" name="file" class="@error('file') is-invalid @enderror" >
		    @error('file')
				<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
			<button type="submit" class="btn btn-primary">Enviar</button>
			</form>
		</div>
    </div>
@endsection
