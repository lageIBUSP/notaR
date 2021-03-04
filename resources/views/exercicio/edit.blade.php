@extends('layouts.base')
@section('content')

<div class="container">
	<div class="row">
	    <h1>Criar novo exercício</h1>
	</div>
	<div class="row">
	    <form action="{{'/exercicio/'.$exercicio->id}}" method="POST">
		@csrf
        @method ('put')
		@include ('includes.error_alert')

		<div class="form-group">
		    <label for="name">Título</label>
		    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Título do exercício" value="{{ old('name', $exercicio->name) }}">
		    @error('name')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

		<div class="form-group">
		    <label for="description">Enunciado</label>
		    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Salve o resultado da estatística xyz na variável abc">{{ old('description', $exercicio->description) }}</textarea>
		    @error('description')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

        <div class="form-group">
		    <label for="precondicoes">Pré-condições</label>
		    <textarea class="form-control @error('precondicoes') is-invalid @enderror" id="precondicoes" name="precondicoes" placeholder="Código rodado antes da correção">{{ old('precondicoes', $exercicio->precondicoes) }}</textarea>
		    @error('precondicoes')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
        <div class="row">
            <h2>Testes</h2>
            <div class="alert alert-info">
                Arraste os testes para reodenar!
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
                    <?php
                    $condicoes = old('condicoes',$exercicio->testes->pluck('condicao'));
                    $dicas = old('dicas',$exercicio->testes->pluck('dica'));
                    $pesos = old('pesos',$exercicio->testes->pluck('peso'));
                    ?>
                    @foreach ($dicas as $i => $dica)
                    <tr>
                        <td>
                            <input type='text' 
                                class="form-control form-inline @error('condicoes.'.$i) is-invalid @enderror"
                                id="condicoes[]"
                                name="condicoes[]"
                                value="{{$condicoes[$i]}}">
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
                                value="{{$pesos[$i]}}">
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
        </div>

		<button type="submit" class="btn btn-primary">Salvar</button>
	    </form>
	</div>
    </div>
    @endsection
