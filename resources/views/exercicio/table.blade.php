<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Id</td>
            <td>Título</td>
            <td>Ações</td>
        </tr>
    </thead>
    <tbody>
    @foreach($exercicios as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->titulo }}</td>

            <td>

                <!-- show -->
                <a class="btn btn-small btn-success" href="{{ URL::to('exericio/' . $value->id) }}">Fazer</a>

                <!-- edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('exercicio/' . $value->id . '/edit') }}">Editar</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

