<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Nome</td>
            <td>Email</td>
            @unless ($turma ?? '')
                <td>Turmas</td>
            @endunless
            <td>Admin</td>
            @if ($editButton ?? '' or $removeButton ?? '')
                <td>Ações</td>
            @endif
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
            @unless ($turma ?? '')
                <td>
                    @foreach ($value->turmas as $t)
                        <a href={{URL::to("/turma/".$t->id)}}>
                            {{ $t->name }}
                        </a>
                    @endforeach
                </td>
            @endunless
            <td>
                <a href={{URL::to("/user/".$value->id)}}>
                <div style="height:100%;width:100%">
                    {{ $value->is_admin ? "SIM" : ""}}
                </div>
                </a>
            </td>

            @if ($editButton ?? '' or $removeButton ?? '')
            <td>

                <!-- edit  -->
                @if ($editButton ?? '')
                @can ('edit', $value)
                <a class="btn btn-small btn-edit" href="{{ URL::to('user/' . $value->id . '/edit') }}">Editar</a>
                @endcan
                @endif

                <!-- remove -->
                @if ($removeButton ?? '')
                <a class="btn btn-small btn-remove" href="{{ URL::to('turma/' . $turma->id . '/remove/'.$value->id) }}">Remover</a>
                @endif

            </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
