@extends('layouts.base')
@section('content')
<h1>
    Arquivos
    @can ('create', App\Models\Arquivo::class)
        <a class="btn btn-small btn-edit inline"
            href="{{ URL::to('arquivo/create') }}">Novo arquivo
        </a>
    @endcan
</h1>
<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
		{{ $errors->first() }}
    </div>
@endif

@include('arquivo.table',['removeButton'=>true])
</div>
@endsection
