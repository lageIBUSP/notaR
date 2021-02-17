<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Nome</td>
            <td>Descrição</td>
            @can ('edit', App\Model\Turma::class)
            <td>Ações</td>
            @endcan
        </tr>
    </thead>
    <tbody>
    @foreach($turmas as $key => $value)
        <tr>
            <td>
                <a href={{"/turma/".$value->id}}>
                <div style="height:100%;width:100%">
                    {{ $value->name }}
                </div>
                </a>
            </td>
            <td>
                <a href={{"/turma/".$value->id}}>
                <div style="height:100%;width:100%">
                    {{ $value->description }}
                </div>
                </a>
            </td>

            @can ('edit', $value)
            <td>

                <!-- edit -->
                <a class="btn btn-small btn-edit" href="{{ URL::to('turma/' . $value->id . '/edit') }}">Editar</a>

            </td>
            @endcan
        </tr>
    @endforeach
    </tbody>
</table>

