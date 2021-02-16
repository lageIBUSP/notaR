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
                <td>{{ $value->user->name }}</td>
            @endif
            @unless ($exercicio ?? '')
                <td>{{ $value->exercicio->titulo }}</td>
            @endif
            <td>{{ $value->nota }}</td>
            <td>{{ $value->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

