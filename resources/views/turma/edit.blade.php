<!DOCTYPE html>
<html>
<head>
    <title>Shark App</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('turma') }}">turma Alert</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('turma') }}">View All turmas</a></li>
        <li><a href="{{ URL::to('turma/create') }}">Create a turma</a>
    </ul>
</nav>

<h1>Edit {{ $turma->name }}</h1>

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

</div>
</body>
</html>
