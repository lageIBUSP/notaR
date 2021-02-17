<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Exercicio</td>
            @unless ($turma ?? "")
                <td>Turma</td>
            @endif
            <td>Prazo</td>
            @if ($turma ?? "")
            @can ('edit', $turma)
                <td>Ações</td>
            @endcan
            @endif
        </tr>
    </thead>
    <tbody>
    @foreach($prazos as $key => $value)
        <tr>
            <td>
                <a href={{"/exercicio/".$value->exercicio->id}}>
                <div style="height:100%;width:100%">
                    {{ $value->exercicio->titulo }}
                </div>
                </a>
            </td>

            @unless ($turma ?? "")
                <td>
                <a href={{"/turma/".$value->turma->id}}>
                <div style="height:100%;width:100%">
                    {{ $value->turma->name }}
                </div>
                </a>
                </td>
            @endif
            <td>{{ $value->prazo }}</td>

            @if ($turma ?? "")
            @can ('edit', $turma)
                <td>

                    <!-- edit  -->
                    @if ($editButton ?? '')
                        <a class="btn btn-small btn-edit" href="{{ URL::to('prazo/' . $value->id . '/edit') }}">Editar</a>
                    @endif

                    <!-- remove -->
                    @if ($removeButton ?? '')
                        <a class="btn btn-small btn-remove" href="{{ URL::to('turma/' . $turma->id . '/removePrazo/'.$value->id) }}">Remover</a>
                    @endif

                </td>
            @endcan
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

