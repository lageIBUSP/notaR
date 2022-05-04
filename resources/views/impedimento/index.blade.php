@extends('layouts.base')
@section('content')
<h1>
    Impedimentos
    @can ('create', App\Models\Impedimento::class)
        <a class="btn btn-small btn-edit inline"
            href="{{ URL::to('impedimento/create') }}">Novo impedimento
        </a>
    @endcan
</h1>
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
