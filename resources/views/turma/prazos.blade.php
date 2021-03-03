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
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>Exercicio</td>
                            <td>Prazo</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exercicios as $key => $ex)
                        <tr>
                            <td>
                                {{$ex->titulo}}
                            </td>
                            <td>
                            <span class="form-group">
                                <input type='text' 
                                    class="form-control @error('prazos[]') is-invalid @enderror datetimepicker-input"
                                    data-toggle="datetimepicker"
                                    id="prazos[{{$ex->id}}]"
                                    data-target="#prazos[{{$ex->id}}]"
                                    name="prazos[{{$ex->id}}]"
                                    value="{{$ex->prazoEm($turma)}}">

                                <i class="fas fa-steam"></i>
                                @error('{{"prazos[]"}}')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            </span>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
    </div>
</div>
@endsection
