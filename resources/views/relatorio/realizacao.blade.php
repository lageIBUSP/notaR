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
                        Nota máxima
                    </td>
                    <td>
                        Média de tentativas
                    </td>
                    <td>
                        Média de notas
                    </td>
            </tr>
        </thead>
        <tbody>
        <!-- rownames: exercicio names -->
        @foreach($turma->prazos->sortBy('exercicio.name') as $key => $prazo)
            <tr>
                <td>
                    {{$prazo->exercicio->name}}
                </td>
                <!-- table body: estatísticas -->
                    <td>
                        <!--Tentaram-->
                        {{$prazo->resumo['tentaram']}}%
                    </td>
                    <td>
                        <!--100%-->
                        {{$prazo->resumo['notamaxima']}}%
                    </td>
                    <td>
                        <!--Tentativas-->
                        {{$prazo->resumo['tentativas']}}
                    </td>
                    <td>
                        <!--Média-->
                        {{$prazo->resumo['media']}}
                    </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <canvas id="grafico"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = {!! json_encode($turma->prazos->pluck('exercicio.name')) !!};
        const data = {
            labels: labels,
            datasets: [{
                label: 'Tentaram',
                backgroundColor: '#A3D2CA',
                borderColor: '#A3D2CA',
                data: {!! json_encode($turma->prazos->pluck('resumo.tentaram')) !!}
            },{
                label: 'Nota máxima',
                backgroundColor: '#5EAAA8',
                borderColor: '#5EAAA8',
                data: {!! json_encode($turma->prazos->pluck('resumo.notamaxima')) !!}
            },
        ]
        };
        const config = {
            type: 'line',
            data,
            options: {
                scales: {
                    yAxis: {
                        min: 0,
                        max: 100
                    }
                }
            }
        };
        new Chart(document.getElementById('grafico'), config);
    </script>
    @endif


</div>
@endsection
