
    <form action="{{URL::to('/relatorio')}}" method='GET' class="relatorio-select row gridline">
        <label for="turma">Turma:</label>
        <select id="turma" name="turma">
            @foreach ($turmas as $key => $value)
                <option value="{{$value->id}}" {{$value->id == (($turma ?? "") ? $turma->id : -1 ) ? "selected" : ""}}>{{$value->name}}</option>
            @endforeach
        </select>

        <label for="turma">Tipo de relatório:</label>
        <select id="tipo" name="tipo">
            <option value="notas" {{($tipo ?? '') == 'notas' ? "selected" : ""}}>Notas</option>
            <option value="realizacao" {{($tipo ?? '') == 'realizacao' ? "selected" : ""}}>Realização</option>
        </select>

        <label for="turma">Exportar como csv?</label>
        <select id="export" name="export">
            <option value="0" {{($export ?? '') == '0' ? "selected" : ""}}>Ver apenas</option>
            <option value="1" {{($export ?? '') == '1' ? "selected" : ""}}>Exportar</option>
        </select>

        <input type="submit" class="btn btn-small inline btn-edit" value="Gerar relatório">
    </form>
