@extends('layouts.base')
@section('content')
<div class="container">
    <div class="row">
        <h1>Exercícios

            @if (Auth::user()->isAdmin())
                <a class="btn btn-small btn-edit inline"
                    href="{{ URL::to('exercicio/exportall') }}">Exportar todos</a>
            @endif
        </h1>
    </div>

    <div class="row">
        <!-- will be used to show any messages -->
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <!-- content -->
        @include('exercicio.table')
    </div>

</div>
@endsection
