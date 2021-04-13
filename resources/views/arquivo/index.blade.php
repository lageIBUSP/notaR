@extends('layouts.base')
@section('content')
<h1>Arquivos</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@include('arquivo.table',['removeButton'=>true])
</div>
@endsection
