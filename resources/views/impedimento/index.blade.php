@extends('layouts.base')
@section('content')
<h1>Lista de palavras proibidas</h1>
<div class="alert alert-info">
    As palavras listadas aqui não podem aparecer em nenhum lugar do seu código, por motivos de segurança.
</div>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@include('impedimento.table')
</div>
@endsection
