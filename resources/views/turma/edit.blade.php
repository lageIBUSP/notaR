@extends('layouts.base')
@section('content')

    <div class="container">
	<div class="row">
        <h1>Editando {{ $turma->name }}</h1>
	</div>
	<div class="row">
	    <form action={{URL::to('/turma/'.$turma->id)}} method="POST" enctype="multipart/form-data">
		@csrf
        @method('PUT')
        @include ('includes.error_alert')
		<div class="form-group">
		    <label for="name">Nome</label>
		    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('nome', $turma->name) }}">
		    @error('name')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

		<div class="form-group">
		    <label for="curso">Curso</label>
            @php($old_curso = old('curso_id', $turma->curso_id))
				<select id="curso_id" name="curso_id" >
					<option value="" {{$old_curso == null ? 'selected' : ''}}></option>
					@foreach ($cursos as $value)
						<option value="{{$value->id}}" {{$old_curso == $value->id ? 'selected' : ''}}>{{$value->name}}</option>
					@endforeach
				</select>
		    @error('curso_id')
			    <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

		<div class="form-group">
		    <label for="description">Descrição</label>
		    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description',$turma->description) }}</textarea>
		    @error('description')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="maillist">
                Adicionar alunos por csv (deve conter colunas "name" e "email"; <b><a href="/storage/examples/bulk_add_users.csv">baixe aqui</a></b> um arquivo de exemplo)
            </label>
		    <input type="file" class="form-control @error('maillist') is-invalid @enderror" id="maillist" name="maillist">{{ old('maillist','') }}</input>
		    @error('maillist')
                <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<div class="form-group">
		    <label for="defaultpassword">Senha padrão para os novos alunos</label>
		    <input type="text" class="form-control @error('defaultpassword') is-invalid @enderror" id="defaultpassword" name="defaultpassword">
		    @error('defaultpassword')
                <div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>

		<button type="submit" class="btn btn-primary">Salvar</button>
	    </form>
	</div>

    <a class="collapse-button" data-toggle="collapse" href="#collapseMembros" role="button" aria-expanded="true" aria-controls="collapseMembros">
        <h2>Membros</h2>
    </a>
    <div class="collapse" id="collapseMembros">
        @include('user.table',['users' => $turma->users, 'editButton' => true, 'removeButton' => true])
    </div>

    @if($prazosFuturos ?? '')
        <a class="collapse-button" data-toggle="collapse" href="#collapsePrazosFuturos" role="button" aria-expanded="true" aria-controls="collapsePrazosFuturos">
            <h2>Prazos Futuros</h2>
        </a>
        <div class="collapse" id="collapsePrazosFuturos">
            @include('prazo.table',['prazos' => $prazosFuturos])
        </div>

    @endif

    @if($prazosPassados ?? '')
        <a class="collapse-button" data-toggle="collapse" href="#collapsePrazosPassados" role="button" aria-expanded="true" aria-controls="collapsePrazosPassados">
            <h2>Prazos Passados</h2>
        </a>
        <div class="collapse" id="collapsePrazosPassados">
            @include('prazo.table',['prazos' => $prazosPassados])
        </div>
    @endif


    @can ('delete', $turma)
     <form method="POST" action="{{URL::to("/turma/".$turma->id)}}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <div class="form-group">
            <input type="submit" class="btn btn-delete delete" value="Deletar">
        </div>
    </form>
    @endcan

    </div>
@endsection
