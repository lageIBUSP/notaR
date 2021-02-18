@extends('layouts.base')
@section('content')
<h1>Pessoas que tem conta no NotaR</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@include('user.table',['editButton'=>true])
</div>
@endsection
