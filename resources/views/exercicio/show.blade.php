@extends('layouts.base')
@section('content')

<div class="container">
    <h1>{!! nl2br($exercicio->name) !!}</h1>
    @include ('includes.error_alert')
    @if ($exercicio->draft)
        <div class="alert alert-warning">
            ATENÇÃO: este exercício é um rascunho, e não pode ser visto por alunos.
        </div>
    @endif
    <div class="jumbotron">
        <p>{!! nl2br($exercicio->description) !!}</p>
    </div>

    @if (!Auth::user())
    <div class="alert alert-warning">
        ATENÇÃO: você não está logado. Sua nota não será gravada.
    </div>
    @endif

    @can ('edit', $exercicio)
    <div class="row">
        <a class="btn btn-edit inline" href="{{ URL::to('exercicio/' . $exercicio->id . '/edit') }}">Editar este exercício</a>
        <a class="btn btn-edit inline" href="{{ URL::to('exercicio/' . $exercicio->id . '/export') }}">Exportar este exercício</a>
    </div>
    @endcan

    <!-- form pra enviar exercicio -->
    <a name="enviar">
        <h3>Resposta</h3>
    </a>
    <form action="{{ route('exercicio.upload', $exercicio) }}#enviar" method='POST' enctype="multipart/form-data">
        @csrf
        <input type="file" id="file" hidden name="file" class="@error('filename') is-invalid @enderror" >
        <label class= "btn btn-primary" for="file">Envie um arquivo</label>
        @error('file')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </form>

    <form action="{{ route('exercicio.submit',$exercicio)}}#enviar" method="POST">
    @csrf

        <div class="row">
            <label for="codigo">... ou cole seu código aqui:</label>
            <textarea type="text" class="form-control @error('codigo') is-invalid @enderror"
                    id="codigo" name="codigo" placeholder="Escreva seu código aqui"
                    >{{ old('codigo',$codigo ?? '') }}</textarea>
            @error('codigo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        <input type="submit" class="btn btn-primary" value="Enviar">
        </div>
    </form>
    @if ($respostaR ?? "")
        <div class="row">
            <div class="alert alert-{{$respostaR['status']}} retorno">
                <p>{!!$respostaR['mensagem']!!}</p>
                <p><b>Sua nota: {{ number_format($respostaR['nota'],1) }}%</b></p>
            </div>
        </div>
    @endif


</div>

@endsection
