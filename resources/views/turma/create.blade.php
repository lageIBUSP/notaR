@extends('layouts.base')
@section('content')
<div class="container">
	<div class="row">
	    <h1>Criar nova turma</h1>
	</div>
	<div class="row">
	    <form action="{{URL::to("/turma")}}" method="POST">
			@csrf
			@include ('includes.error_alert')

			<div class="form-group">
				<label for="name">Nome</label>
				<input type="text"
					class="form-control @error('name') is-invalid @enderror"
					id="name" name="name" placeholder="Nome da turma"
					value="{{ old('name') }}">
				@error('name')
					<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>

			<div class="form-group">
				<label for="curso">Curso</label>
				@php($old_curso = old('curso_id', null))
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
				<textarea
					class="form-control @error('description') is-invalid @enderror"
					id="description" name="description"
					placeholder="Classe da disciplina XYZ do ano ABCD">
						{{ old('description') }}
				</textarea>
				@error('description')
					<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>

			<div class="form-group">
				<label for="copyfrom">
					Importar prazos e exercícios da turma
				</label>
				@php($original_turma = old('copyfrom'))
					<select id="copyfrom" name="copyfrom" >
						<option value="" {{$original_turma == null ? 'selected' : ''}}></option>
						@foreach ($turmas as $value)
							<option value="{{$value->id}}" {{$original_turma == $value->id ? 'selected' : ''}}>{{$value->name}}</option>
						@endforeach
					</select>
				@error('copyfrom')
					<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>

			<button type="submit" class="btn btn-primary">Criar</button>
	    </form>
	</div>
</div>
@endsection
