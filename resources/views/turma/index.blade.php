<!DOCTYPE html>
<html>
<head>
    <title>Turmas</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('turmas') }}">Turmas</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('turmas') }}">Todas as turmas</a></li>
        <li><a href="{{ URL::to('turmas/create') }}">Criar uma turma</a>
    </ul>
</nav>

<h1>Todas as Turmas</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Id</td>
            <td>Nome</td>
	    <td>Descrição</td>
            <td>Ações</td>
        </tr>
    </thead>
    <tbody>
    @foreach($turmas as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->description }}</td>

            <!-- we will also add show, edit, and delete buttons -->
            <td>

                <!-- delete the Turma (uses the destroy method DESTROY /Turmas/{id} -->
                <!-- we will add this later since its a little more complicated than the other two buttons -->

                <!-- show the Turma (uses the show method found at GET /Turmas/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('turmas/' . $value->id) }}">Ver</a>

                <!-- edit this Turma (uses the edit method found at GET /Turmas/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('Turmas/' . $value->id . '/edit') }}">Editar</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</div>
</body>
</html>
