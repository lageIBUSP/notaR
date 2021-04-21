
    <form action="{{URL::to('/relatorio')}}" method='GET'>
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
        <input type="submit">
    </form>