@extends('layouts.base')
@section('content')

<h1>{{ $exercicio->name }}</h1>
    <div class="jumbotron">
        <p>{{ $exercicio->decription }}</p>
    </div>

    <!-- todo: form pra enviar exercicio -->

    <a class="collapse-button" data-toggle="collapse" href="#collapsePrazos" role="button" aria-expanded="true" aria-controls="collapsePrazos">
        <h2>Prazos</h2>
    </a>
    <div class="collapse show" id="collapsePrazos">
        @include('prazo.table',['prazos' => $exercicio->prazos, ])
    </div>

@endsection
