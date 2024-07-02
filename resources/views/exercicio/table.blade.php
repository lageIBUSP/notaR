<table class="table table-striped table-bordered">
    <tbody>
    @foreach($exercicios as $key => $value)
        <tr>
            <td>
                <a href={{URL::to("/exercicio/".$value->id)}}>
                    {!! $value->name !!} {{$value->draft ? '!!RASCUNHO!!' :''}}
                </a>

                @if ($editButton ?? '')
                    @can ('edit', $value)
                        <a class="btn btn-small btn-edit pull-right" href="{{ URL::to('exercicio/' . $value->id . '/edit') }}">Editar</a>
                    @endcan
                @endif

            </td>
        </tr>
    @endforeach
    </tbody>
</table>
