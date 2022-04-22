@extends('layouts.base')
@section('content')

<div class="container">
    <h1>Relatório de notas</h1>

    @include('relatorio.select', ['turmas' => $turmas])

    @if ($turma ?? "")
        @include('relatorio.table', ['tabela' => $tabela])
    @endif


</div>
@endsection
