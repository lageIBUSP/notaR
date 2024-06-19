<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Título</td>
            @if ($editButton ?? '')
                <td>Ações</td>
            @endif
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

            @if ($editButton ?? '')
            <td>

                <!-- edit -->
                @if ($editButton ?? '')
                @can ('edit', $value)
                <a class="btn btn-small btn-edit" href="{{ URL::to('exercicio/' . $value->id . '/edit') }}">Editar</a>
                @endcan
                @endif

            </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
