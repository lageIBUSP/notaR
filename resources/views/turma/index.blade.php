@extends('layouts.base')
@section('content')
<h1>Todas as Turmas</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@include('turma.table')
</div>
@endsection
