@extends('layouts.base')
@section('content')

<div class="container">
	<div class="row">
	    <h1>Alterar exercício</h1>
	</div>
	<div class="row">
        @include ('includes.error_alert')
        <form action="{{ URL::to('exercicio/'.$exercicio->id.'/import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method ('put')
        <input type="file" id="file" hidden name="file" class="@error('filename') is-invalid @enderror" >
        <label class= "btn btn-primary" for="file">Importar dados de arquivo</label>
        @error('file')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        </form>
	</div>
    @if (old('from_import',false))
        <div class="alert alert-info">Arquivo carregado. Verifique os campos antes de salvar!</div>
    @endif
	<div class="row">
	    <form action="{{URL::to('/exercicio/'.$exercicio->id)}}" method="POST">
		@csrf
        @method ('put')

		<div class="form-group">
		    <label for="name"><h2>Título</h2></label>
		    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Título do exercício" value="{{ old('name', $exercicio->name) }}">
		    @error('name')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

		<div class="form-group">
		    <label for="topico"><h2>Tópico</h2></label>
            @php($old_topico = old('topico_id', $exercicio->topico_id))
				<select id="topico_id" name="topico_id" >
					<option value="" {{$old_topico == null ? 'selected' : ''}}></option>
					@foreach ($topicos as $value)
						<option value="{{$value->id}}" {{$old_topico == $value->id ? 'selected' : ''}}>{{$value->name}}</option>
					@endforeach
				</select>
		    @error('topico_id')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>


		<div class="form-group">
		    <label for="description"><h2>Enunciado</h2></label>
		    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Salve o resultado da estatística xyz na variável abc">{{ old('description', $exercicio->description) }}</textarea>
		    @error('description')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

        <div class="form-group">
		    <label for="precondicoes"><h2>Precondições</h2></label>
            @if ($pacotesR ?? '')
            <div>
                <label for="pacotes">Veja a lista de pacotes disponíveis:</label>
                <select name="pacotes" id="pacotes">
                    @foreach ($pacotesR as $i => $pacote)
                        <option value="{{$pacote}}">{{$pacote}}</option>
                    @endforeach
                </select>
            </div>
            @endif

		    <textarea class="form-control @error('precondicoes') is-invalid @enderror" id="precondicoes" name="precondicoes" placeholder="Código rodado antes da correção">{{ old('precondicoes', $exercicio->precondicoes) }}</textarea>
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

        <select name="draft" id="draft">
            {{ $is_draft = old('draft',$exercicio->draft)  }}
            <option value="0" {{ $is_draft ? '' : 'selected' }}>Publicar</option>
            <option value="1" {{ $is_draft ? 'selected' : '' }}>Salvar como rascunho</option>
        </select>

		<button type="submit" class="btn btn-primary">Salvar</button>
	    </form>
    </div>

	<div class="row">
		@can ('delete', $exercicio)
		<form method="POST" action="{{URL::to("/exercicio/".$exercicio->id)}}">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}

			<div class="form-group">
				<input type="submit" class="btn btn-delete delete" value="Deletar">
			</div>
		</form>
		@endcan
    </div>
</div>
@endsection
