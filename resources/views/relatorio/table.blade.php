
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
               @foreach ($tabela[0] as $key => $value)
                   <td>{{$value}}</td>
               @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($tabela as $key => $row)
            @if ($loop->first) @continue @endif
            <tr>
               @foreach ($row as $key => $value)
                   <td>{{$value}}</td>
               @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
