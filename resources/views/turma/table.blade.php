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

                <!-- show the Turma (uses the show method found at GET /turma/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('turma/' . $value->id) }}">Ver</a>

                <!-- edit this Turma (uses the edit method found at GET /turma/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('turma/' . $value->id . '/edit') }}">Editar</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

