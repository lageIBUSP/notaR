@extends('layouts.base')
@section('content')

<div class="container">
    <h1>Relatório de Realização</h1>

    @include('relatorio.select', ['turmas' => $turmas])

    @if ($turma ?? "")
        @include('relatorio.table', ['tabela' => $tabela])

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
