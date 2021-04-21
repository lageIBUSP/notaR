<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Nome</td>
            <td>Ações</td>
        </tr>
    </thead>
    <tbody>
    @foreach($arquivos as $key => $value)
        <tr>
            <td>
                <a href={{URL::to("/arquivo/".$value->id)}}>
                <div style="height:100%;width:100%">
                    {{ $value->name }}
                </div>
                </a>
            </td>
            <td>

                <!-- remove -->
                @if ($removeButton ?? '')
                @can ('delete', $value)
                    <form method="POST" action="{{URL::to("/arquivo/".$value->id)}}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group">
                            <input type="submit" class="btn btn-danger delete" value="Deletar">
                        </div>
                    </form>
                @endcan
                @endif

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

