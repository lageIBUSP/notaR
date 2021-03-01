@extends('layouts.base')
@section('content')

<div class="container">
    <div class="row">
        <h1>Editando prazos para {{ $turma->name }}</h1>
    </div>
<div class="row">
<form action={{'/turma/'.$turma->id.'/prazos'}} method="POST">
    @include ('includes.error_alert')
    @foreach($exercicios as $key => $ex)
    <div class="form-group">
    <input type='text' id="{{"ex".$ex->id}}" name="{{"ex".$ex->id}}" value="{{$ex->prazoEm($turma)}}" class='form-control datetimepicker'>
    @error('{{"ex".$ex->id}}')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>
    @endforeach
    <button type="submit" class="btn btn-primary">Salvar</button>
    </form>

    </div>
    </div>
    @endsection
