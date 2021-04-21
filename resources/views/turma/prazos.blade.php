@extends('layouts.base')
@section('content')

<div class="container">
    <div class="row">

        <form action={{URL::to('/turma/'.$turma->id.'/prazos')}} method="POST">
            @csrf
            @method('PUT')
            @include ('includes.error_alert')

            <h1>Editando prazos para {{ $turma->name }}</h1>

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
                                {{$ex->name}}
                            </td>
                            <td>
                                <input type='text' 
                                    class="form-control form-inline @error('prazos[]') is-invalid @enderror datetimepicker-input"
                                    data-toggle="datetimepicker"
                                    id="prazos[{{$ex->id}}]"
                                    data-target="#prazos[{{$ex->id}}]"
                                    name="prazos[{{$ex->id}}]"
                                    value="{{$ex->prazoEm($turma)}}">

                                <i class="fa fa-times-circle clear-input btn"></i>
                                @error('{{"prazos[]"}}')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
    </div>
</div>
@endsection
