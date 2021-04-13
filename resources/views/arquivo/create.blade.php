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
			<input type="file" id="file" name="file">
			<button type="submit" class="btn btn-primary">Enviar</button>
			</form>
		</div>
    </div>
@endsection
