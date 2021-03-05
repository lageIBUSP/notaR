@extends('layouts.base')
@section('content')

<div class="container">
    <h1>{{ $exercicio->name }}</h1>
    <div class="jumbotron">
        <p>{{ $exercicio->description }}</p>
    </div>

    <!-- form pra enviar exercicio -->
    <form action="{{route('exercicio.submit',$exercicio)}}" method="POST">
    @csrf
    @include ('includes.error_alert')

        <div class="row">
            <label for="código"><h3>Resposta</h3></label>
            <textarea type="text" class="form-control @error('codigo') is-invalid @enderror"
                    id="codigo" name="codigo" placeholder="Escreva seu código aqui"
                    >{{ old('codigo') }}</textarea>
            @error('codigo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        <input type="submit" class="btn btn-primary" value="Enviar">
        </div>
    </form>
    @if ($respostaR ?? "")
        <div class="row">
            <div class="alert {{$respostaR['status'] == 'sucesso' ? 'alert-success' : ''}} retorno">
                {!!$respostaR['mensagem']!!}
            </div>
        </div>
    @endif


</div>
@endsection
