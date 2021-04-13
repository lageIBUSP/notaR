<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Id</td>
            <td>Título</td>
            <td>Ações</td>
        </tr>
    </thead>
    <tbody>
    @foreach($exercicios->sortBy('name') as $key => $value)
        <tr>
            <td>
                <a href={{"/exercicio/".$value->id}}>
                <div style="height:100%;width:100%">
                    {{ $value->id }}
                </div>
                </a>
            </td>
            <td>
                <a href={{"/exercicio/".$value->id}}>
                <div style="height:100%;width:100%">
                    {{ $value->name }}
                </div>
                </a>
            </td>

            <td>

                <!-- edit -->
                @can ('edit', $value)
                <a class="btn btn-small btn-edit" href="{{ URL::to('exercicio/' . $value->id . '/edit') }}">Editar</a>
                @endcan

            </td>
        </tr>
    @endforeach
    </tbody>
</table>
