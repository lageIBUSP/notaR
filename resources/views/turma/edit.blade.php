@extends('layouts.base')

@section('content')

<h1>Edit {{ $turma->name }}</h1>
:
<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::model($turma, array('route' => array('turma.update', $turma->id), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('description', 'Email') }}
        {{ Form::description('description', null, array('class' => 'form-control')) }}
    </div>


    {{ Form::submit('Edit the turma!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@endsection
