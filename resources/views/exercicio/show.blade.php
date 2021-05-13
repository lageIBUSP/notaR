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

    <!-- form pra enviar exercicio -->
    <form action="{{ route('exercicio.upload', $exercicio) }}" method='POST' enctype="multipart/form-data">
        @csrf
        <label for="codigo"><h3>Enviar arquivo</h3></label><br>
        <input type="file" id="file" name="file" class="@error('filename') is-invalid @enderror" >
        @error('file')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

    <form action="{{ route('exercicio.submit',$exercicio) }}" method="POST">
    @csrf

        <div class="row">
            <label for="codigo"><h3>Resposta</h3></label>
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
                <p><b>Sua nota: {{$respostaR['nota']}}%</b></p>
                <p><b>Seu código: </b> <br></p>
                {!! nl2br(e($codigo)) !!}
            </div>
        </div>
    @endif


</div>
@endsection
