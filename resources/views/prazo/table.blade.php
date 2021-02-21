<table class="table table-striped table-bordered">
    <thead>
        <tr>
            @unless ($exercicio ?? "")
                <td>Exercicio</td>
            @endif
            @unless ($turma ?? "")
                <td>Turma</td>
            @endif
            <td>Prazo</td>
            @if ($user ?? "")
                <td>Nota</td>
            @endif
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
            @unless ($exercicio ?? "")
                <td>
                    <a href={{"/exercicio/".$value->exercicio->id}}>
                    <div style="height:100%;width:100%">
                        {{ $value->exercicio->titulo }}
                    </div>
                    </a>
                </td>
            @endif

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
            @if ($user ?? "")
                <td>
                    {{ $user->notaFinal($value) }}
                </td>
            @endif

            @if ($turma ?? "")
            @can ('edit', $turma)
                <td>

                    <!-- edit  -->
                    @if ($editButton ?? '')
                        <a class="btn btn-small btn-edit" href="{{ URL::to('prazo/' . $value->id . '/edit') }}">Editar</a>
                    @endif

                    <!-- remove -->
                    @if ($removeButton ?? '')
                    @can ('delete', $value)
                     <form method="POST" action="/prazo/{{$value->id}}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group">
                            <input type="submit" class="btn btn-remove" value="Remover">
                        </div>
                    </form>
                    @endcan
                    @endif

                </td>
            @endcan
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

