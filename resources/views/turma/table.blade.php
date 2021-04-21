<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Nome</td>
            <td>Descrição</td>
            <td>Ações</td>
        </tr>
    </thead>
    <tbody>
    @foreach($turmas as $key => $value)
        <tr>
            <td>
                <a href={{URL::to("/turma/".$value->id)}}>
                <div style="height:100%;width:100%">
                    {{ $value->name }}
                </div>
                </a>
            </td>
            <td>
                <a href={{URL::to("/turma/".$value->id)}}>
                <div style="height:100%;width:100%">
                    {{ $value->description }}
                </div>
                </a>
            </td>

            <td>

                <!-- edit -->
                @can ('edit', $value)
                <a class="btn btn-small btn-edit" href="{{ URL::to('turma/' . $value->id . '/edit') }}">Editar</a>
                @endcan

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

