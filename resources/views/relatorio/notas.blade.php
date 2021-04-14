@extends('layouts.base')
@section('content')

<div class="container">
    <h1>Relatório de notas</h1>

    <p>Turma: {{ $turma->name }}</p>

    @if ($turma ?? "")
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <td>
                </td>
                <!-- thead: nomes dos exercícios -->
                @foreach($turma->prazos as $key => $prazo)
                    <td>
                        {{$prazo->exercicio->name}}
                    </td>
                @endforeach 
            </tr>
        </thead>
        <tbody>
        @foreach($turma->users as $key => $user)
            <tr>
                <!-- rownames: user names -->
                <td>
                    {{$user->name ? $user->name : $user->email}}
                </td>
                <!-- table body: notas válidas -->
                @foreach($turma->prazos as $key => $prazo)
                    <td>
                        <!-- TODO: evitar olhar o banco de dados para cada nota!!! -->
                        {{$user->notaFinal($prazo)}}
                    </td>
                @endforeach 
            </tr>
        @endforeach
        </tbody>
    </table>

    @endif


</div>
@endsection
