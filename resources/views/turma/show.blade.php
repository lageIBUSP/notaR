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

<h1>Showing {{ $turma->name }}</h1>

    <div class="jumbotron text-center">
        <h2>{{ $turma->name }}</h2>
        <p>
            {{ $turma->description }}<br>
        </p>
    </div>

</div>
</body>
</html>
