<table class="table table-striped table-bordered">
    <thead>
        <tr>
            @unless ($user ?? '')
                <td>Aluno</td>
            @endif
            @unless ($exercicio ?? '')
                <td>Exercício</td>
            @endif
            <td>Nota</td>
            <td>Data</td>
        </tr>
    </thead>
    <tbody>
    @foreach($notas as $key => $value)
        <tr>
            @unless ($user ?? '')
                <td>
                <a href={{ URL::to("/user/".$value->user->id) }}>
                <div style="height:100%;width:100%">
                    {{ $value->user->name }}
                </div>
                </a>
                </td>
            @endif
            @unless ($exercicio ?? '')
                <td>
                <a href={{ URL::to("/exercicio/".$value->exercicio->id) }}>
                <div style="height:100%;width:100%">
                    {{ $value->exercicio->name }}
                </div>
                </a>
                </td>
            @endif
            <td>
                {{ $value->nota }}
            </td>
            <td>
                {{ $value->created_at }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

