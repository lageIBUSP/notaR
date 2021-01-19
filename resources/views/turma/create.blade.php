<!DOCTYPE html>
<html>
<head>
    <title>notaR - criar turma</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
    <div class="navbar-header">
	<a class="navbar-brand" href="{{ URL::to('turmas') }}">turma Alert</a>
    </div>
    <ul class="nav navbar-nav">
	<li><a href="{{ URL::to('turmas') }}">View All turmas</a></li>
	<li><a href="{{ URL::to('turmas/create') }}">Create a turma</a>
    </ul>
</nav>
@extends('layouts.app')
@section('content')
    <div class="container">
	<div class="row">
	    <h1>Submit a link</h1>
	</div>
	<div class="row">
	    <form action="/submit" method="post">
		@csrf
		@if ($errors->any())
		    <div class="alert alert-danger" role="alert">
			Please fix the following errors
		    </div>
		@endif
		<div class="form-group">
		    <label for="title">Title</label>
		    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{ old('title') }}">
		    @error('title')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="url">Url</label>
		    <input type="text" class="form-control @error('url') is-invalid @enderror" id="url" name="url" placeholder="URL" value="{{ old('url') }}">
		    @error('url')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="description">Description</label>
		    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="description">{{ old('description') }}</textarea>
		    @error('description')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	    </form>
	</div>
    </div>
    @endsection
</body>
    </html>
