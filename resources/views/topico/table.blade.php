<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Nome</td>
            <td>Ações</td>
        </tr>
    </thead>
    <tbody>
    @foreach($topicos as $key => $value)
        <tr>
            <td>
                <a href={{URL::to("/topico/".$value->id)}}>
                <div style="height:100%;width:100%">
                    {{ $value->name }}
                </div>
                </a>
            </td>

            <td>

                <!-- edit -->
                @can ('edit', $value)
                <a class="btn btn-small btn-edit" href="{{ URL::to('topico/' . $value->id . '/edit') }}">Editar</a>
                @endcan

            </td>
        </tr>
    @endforeach
    </tbody>
</table>
