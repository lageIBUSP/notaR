@extends('layouts.base')
@section('content')
<div class="container">
<h1>Exercícios</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
@include('exercicio.table')
</div>
@endsection
