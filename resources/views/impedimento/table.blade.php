<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Palavra</td>
            @if (Auth::user() && Auth::user()->isAdmin())
            <td>Ações</td>
            @endif
        </tr>
    </thead>
    <tbody>
    @foreach($impedimentos as $key => $value)
        <tr>
            <td>
                <div style="height:100%;width:100%">
                    {{ $value->palavra }}
                </div>
            </td>

            @if (Auth::user() && Auth::user()->isAdmin())
            <td>

                <!-- edit -->
                @can ('edit', $value)
                <a class="btn btn-small btn-edit" href="{{ URL::to('impedimento/' . $value->id . '/edit') }}">Editar</a>
                @endcan

                <!-- delete -->
                @can ('delete', $value)
                    <form method="POST" action="{{URL::to("/impedimento/".$value->id)}}" style="display: inline">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <input type="submit" class="btn btn-danger delete" value="Deletar">
                    </form>
                @endcan
            </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

