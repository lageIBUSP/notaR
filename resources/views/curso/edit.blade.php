@extends('layouts.base')
@section('content')

	<div class="container">
		<div class="row">
			<h1>Editando {{ $curso->name }}</h1>
		</div>
		<div class="row">
			<form action={{URL::to('/curso/'.$curso->id)}} method="POST" >
				@csrf
				@method('PUT')
				@include ('includes.error_alert')

				<div class="form-group">
						<label for="name">Nome novo</label>
						<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $curso->name) }}">
						@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
				</div>

				<button type="submit" class="btn btn-primary">Salvar</button>
			</form>
		</div>

		@can ('delete', $curso)
			<form method="POST" action="{{URL::to("/curso/".$curso->id)}}">
				{{ csrf_field() }}
				{{ method_field('DELETE') }}

				<div class="form-group">
					<input type="submit" class="btn btn-delete delete" value="Deletar">
				</div>
			</form>
		@endcan

	</div>
@endsection
