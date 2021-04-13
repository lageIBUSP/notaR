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
            <td>
                <a href={{URL::to("/user/".$value->id)}}>
                <div style="height:100%;width:100%">
                    {{ $value->name }}
                </div>
                </a>
            </td>
            <td>
                <a href={{URL::to("/user/".$value->id)}}>
                <div style="height:100%;width:100%">
                    {{ $value->email }}
                </div>
                </a>
            </td>
            <td>
                <a href={{URL::to("/user/".$value->id)}}>
                <div style="height:100%;width:100%">
                    {{ $value->is_admin ? "SIM" : ""}}
                </div>
                </a>
            </td>

            <td>

                <!-- edit  -->
                @if ($editButton ?? '')
                @can ('edit', $value)
                <a class="btn btn-small btn-edit" href="{{ URL::to('user/' . $value->id . '/edit') }}">Editar</a>
                @endcan
                @endif

                <!-- remove -->
                @if ($removeButton ?? '')
                @can ('edit', $turma)
                <a class="btn btn-small btn-remove" href="{{ URL::to('turma/' . $turma->id . '/remove/'.$value->id) }}">Remover</a>
                @endcan
                @endif

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

