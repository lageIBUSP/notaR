<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Nome</td>
            <td>Email</td>
            <td>Admin</td>
            <td>Ações</td>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $key => $value)
        <tr>
            <td>{{ $value->name }}</td>
            <td>{{ $value->email }}</td>
            <td>{{ $value->is_admin ? "SIM" : ""}}</td>

            <!-- we will also add show, edit, and delete buttons -->
            <td>

                <!-- show  -->
                <a class="btn btn-small btn-show" href="{{ URL::to('user/' . $value->id) }}">Ver</a>

                <!-- edit  -->
                @if ($editButton ?? '')
                <a class="btn btn-small btn-edit" href="{{ URL::to('user/' . $value->id . '/edit') }}">Editar</a>
                @endif

                <!-- remove -->
                @if ($removeButton ?? '')
                <a class="btn btn-small btn-remove" href="{{ URL::to('turma/' . $turma->id . '/remove/'.$value->id) }}">Remover</a>
                @endif

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

