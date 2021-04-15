
    <form action="{{URL::to('/relatorio')}}" method='GET'>
        <label for="turma">Turma:</label>
        <select id="turma" name="turma">
            @foreach ($turmas as $key => $value)
                <option value="{{$value->id}}" {{$value->id == (($turma ?? "") ? $turma->id : -1 ) ? "selected" : ""}}>{{$value->name}}</option>
            @endforeach
        </select>
        <div class="form-group">
            <input type="radio" id="notas" name="tipo" value="notas">
            <label for="notas">Relatório de Notas</label><br>
            <input type="radio" id="realizacao" name="tipo" value="realizacao">
            <label for="realizacao">Relatório de Realização</label><br>
        </div>
        <input type="submit">
    </form>