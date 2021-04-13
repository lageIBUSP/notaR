@extends('layouts.base')
@section('content')

<div class="container">
	<div class="row">
	    <h1>Criar novo exercício</h1>
	</div>
	<div class="row">
	    <form action="{{URL::to("/exercicio")}}" method="POST">
		@csrf
        @method (isset($exercicio) ? 'put' : 'post')
		@include ('includes.error_alert')

		<div class="form-group">
		    <label for="name">Título</label>
		    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Título do exercício" value="{{ old('name') }}">
		    @error('name')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

		<div class="form-group">
		    <label for="description">Enunciado</label>
		    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Salve o resultado da estatística xyz na variável abc">{{ old('description') }}</textarea>
		    @error('description')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

        <div class="form-group">
		    <label for="precondicoes">Pré-condições</label>
		    <textarea class="form-control @error('precondicoes') is-invalid @enderror" id="precondicoes" name="precondicoes" placeholder="Código rodado antes da correção">{{ old('precondicoes') }}</textarea>
		    @error('precondicoes')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

        <h2>Testes</h2>
        <div class="alert alert-info">
            Arraste os testes para reordenar!
        </div>
        <table class="table table-striped table-bordered sortable">
            <thead>
                <tr>
                    <td>Condição</td>
                    <td>Dica</td>
                    <td>Peso</td>
                    <td>Botões</td>
                </tr>
            </thead>
            <tbody>
                @foreach (old('dicas',[0=>""]) as $i => $dica)
                <tr>
                    <td>
                        <input type='text' 
                            class="form-control form-inline @error('condicoes.'.$i) is-invalid @enderror"
                            id="condicoes[]"
                            name="condicoes[]"
                            value="{{old('condicoes',[0=>""])[$i]}}">
                            @error('condicoes.'.$i)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </td>
                    

                    <td>
                        <input type='text' 
                            class="form-control form-inline @error('dicas.'.$i) is-invalid @enderror"
                            id="dicas[]"
                            name="dicas[]"
                            value="{{$dica}}">
                            @error('dicas.'.$i)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </td>
                    
                    <td>
                        <input type='text' 
                            class="form-control form-inline small @error('pesos.'.$i) is-invalid @enderror"
                            id="pesos[]"
                            name="pesos[]"
                            value="{{old('pesos',[0=>""])[$i]}}">
                            @error('pesos.'.$i)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </td>
                    
                    <td>
                        <i type="button" class='btn fa fa-minus-circle remove-row' ></i>
                        <i type="button" class='btn fa fa-plus-circle add-row' ></i>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

		<button type="submit" class="btn btn-primary">Criar</button>
	    </form>
	</div>
</div>
@endsection
