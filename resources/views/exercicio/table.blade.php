<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Título</td>
            <td>Ações</td>
        </tr>
    </thead>
    <tbody>
    @foreach($exercicios as $key => $value)
        <tr>
            <td>
                <a href={{URL::to("/exercicio/".$value->id)}}>
                <div style="height:100%;width:100%">
                    {!! $value->name !!} {{$value->draft ? '!!RASCUNHO!!' :''}}
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
