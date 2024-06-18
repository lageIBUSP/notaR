<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Título</td>
        </tr>
    </thead>
    <tbody>
    @foreach($exercicios as $key => $value)
        <tr>
            <td>
                <a href={{URL::to("/exercicio/".$value->id)}}>
                <div style="height:100%;width:100%">
                    {!! $value->name !!} {{$value->draft ? '!!RASCUNHO!!' :''}}
                </div>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
