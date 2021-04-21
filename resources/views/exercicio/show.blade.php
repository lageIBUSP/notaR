@extends('layouts.base')
@section('content')

<div class="container">
    <h1>{{ $exercicio->name }}</h1>
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
    <form action="{{route('exercicio.submit',$exercicio)}}" method="POST">
    @csrf
    @include ('includes.error_alert')

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
