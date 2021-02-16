<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Condição</td>
            <td>Dica</td>
            <td>Peso</td>
            <td>Ações</td>
        </tr>
    </thead>
    <tbody>
    @foreach($testes as $key => $value)
        <tr>
            <td>{{ $value->condicao }}</td>
            <td>{{ $value->dica }}</td>
            <td>{{ $value->peso}}</td>

            <!-- we will also add show, edit, and delete buttons -->
            <td>

                <!-- edit  -->
                <a class="btn btn-small btn-edit" href="{{ URL::to('teste/' . $value->id . '/edit') }}">Editar</a>

                <!-- delete -->
                <a class="btn btn-small btn-delete" href="{{ URL::to('teste/' . $value->id . '/delete') }}">Remover</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

