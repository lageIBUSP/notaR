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

            <td>

                <!-- show -->
                <a class="btn btn-small btn-success" href="{{ URL::to('turma/' . $value->id) }}">Ver</a>

                <!-- edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('turma/' . $value->id . '/edit') }}">Editar</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

