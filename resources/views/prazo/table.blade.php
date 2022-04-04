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
                    <a href={{URL::to("/exercicio/".$value->exercicio->id)}}>
                    <div style="height:100%;width:100%">
                        {{ $value->exercicio->name }}
                    </div>
                    </a>
                </td>
            @endif

            @unless ($turma ?? "")
                <td>
                <a href={{URL::to("/turma/".$value->turma->id)}}>
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

                    <!-- remove -->
                    @if ($removeButton ?? '')
                     <form method="POST" action="{{URL::to("/prazo/".$value->id)}}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group">
                            <input type="submit" class="btn btn-remove" value="Remover">
                        </div>
                    </form>
                    @endif

                </td>
            @endcan
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

