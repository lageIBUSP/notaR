<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Exercicio</td>
            <td>Prazo</td>
            <td>Ações</td>
        </tr>
    </thead>
    <tbody>
    @foreach($prazos as $key => $value)
        <tr>
            <td>{{ $value->exercicio->titulo }}</td>
            <td>{{ $value->prazo }}</td>

            <td>

                <!-- show  -->
                <a class="btn btn-small btn-show" href="{{ URL::to('prazo/' . $value->id) }}">Ver</a>

                <!-- edit  -->
                @if ($editButton)
                <a class="btn btn-small btn-edit" href="{{ URL::to('prazo/' . $value->id . '/edit') }}">Editar</a>
                @endif

                <!-- remove -->
                @if ($removeButton)
                <a class="btn btn-small btn-remove" href="{{ URL::to('turma/' . $turma->id . '/removePrazo/'.$value->id) }}">Remover</a>
                @endif

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

