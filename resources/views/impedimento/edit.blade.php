@extends('layouts.base')
@section('content')

    <div class="container">
	<div class="row">
        <h1>Editando impedimento</h1>
	</div>
	<div class="row">
	    <form action={{URL::to('/impedimento/'.$impedimento->id)}} method="POST">
		@csrf
        @method('PUT')
        @include ('includes.error_alert')
		<div class="form-group">
		    <label for="palavra">Palavra</label>
		    <input type="text" class="form-control @error('palavra') is-invalid @enderror" id="palavra" palavra="palavra" value="{{ old('nome', $impedimento->palavra) }}">
		    @error('palavra')
			<div class="invalid-feedback">{{ $message }}</div>
		    @enderror
		</div>
		<button type="submit" class="btn btn-primary">Salvar</button>
	    </form>
	</div>
    </form>
    @endcan

    </div>
@endsection
