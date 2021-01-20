@extends('layouts.base')

@section('content')

<h1>Showing {{ $turma->name }}</h1>
    <div class="jumbotron text-center">
        <h2>{{ $turma->name }}</h2>
        <p>
            {{ $turma->description }}<br>
        </p>
    </div>

@endsection
