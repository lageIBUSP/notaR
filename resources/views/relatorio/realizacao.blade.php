@extends('layouts.base')
@section('content')

<div class="container">
    <h1>Relatório de Realização</h1>

    @include('relatorio.select', ['turmas' => $turmas])

    @if ($turma ?? "")
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <td>
                </td>
                <!-- thead: categorias -->
                    <td>
                        Tentaram
                    </td>
                    <td>
                        100%
                    </td>
                    <td>
                        Tentativas
                    </td>
                    <td>
                        Média
                    </td>
                    <td>
                        Primeiro erro
                    </td>
            </tr>
        </thead>
        <tbody>
        <!-- rownames: exercicio names -->
        @foreach($turma->prazos as $key => $prazo)
            <tr>
                <td>
                    {{$prazo->exercicio->name}}
                </td>
                <!-- table body: estatísticas -->
                    <td>
                        <!--Tentaram-->
                        {{$prazo->resumo['tentaram']}}
                    </td>
                    <td>
                        <!--100%-->
                    </td>
                    <td>
                        <!--Tentativas-->
                    </td>
                    <td>
                        <!--Média-->
                    </td>
                    <td>
                        <!--Primeiro erro-->
                    </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @endif


</div>
@endsection
