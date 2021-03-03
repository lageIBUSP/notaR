@extends('layouts.base')
@section('content')

<div class="container">
    <div class="row">
        <h1>Editando prazos para {{ $turma->name }}</h1>
    </div>
    <div class="row">
        <form action={{'/turma/'.$turma->id.'/prazos'}} method="POST">
		@csrf
        @method('PUT')
            @include ('includes.error_alert')
            @foreach($exercicios as $key => $ex)
                <div class="form-group">
                    {{$ex->titulo}}
                    <input type='text' 
                        class="form-control @error('prazos[]') is-invalid @enderror datetimepicker-input"
                        data-toggle="datetimepicker"
                        id="prazos[{{$ex->id}}]"
                        data-target="#prazos[{{$ex->id}}]"
                        name="prazos[{{$ex->id}}]"
                        value="{{$ex->prazoEm($turma)}}">
                    @error('{{"prazos[]"}}')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
    </div>
</div>
@endsection
