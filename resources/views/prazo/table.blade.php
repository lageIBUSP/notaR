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
        </tr>
    </thead>
    <tbody>
    @foreach($prazos as $key => $value)
        <tr>
            @unless ($exercicio ?? "")
                <td>
                    <a href={{URL::to("/exercicio/".$value->exercicio_id)}}>
                    <div style="height:100%;width:100%">
                        {{ $value->exercicio_name }}
                    </div>
                    </a>
                </td>
            @endif

            @unless ($turma ?? "")
                <td>
                <a href={{URL::to("/turma/".$value->turma_id)}}>
                <div style="height:100%;width:100%">
                    {{ $value->turma_name }}
                </div>
                </a>
                </td>
            @endif

                <td>
                    {{ $value->prazo }}
                </td>

            @if ($user ?? "")
                <td>
                    {{ $user->notaFinal($value) }}
                </td>
            @endif

        </tr>
    @endforeach
    </tbody>
</table>
