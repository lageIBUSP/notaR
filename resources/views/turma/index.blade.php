@extends('layouts.base')
@section('content')
<h1>
    Turmas
    @can ('create', App\Models\Turma::class)
        <a class="btn btn-small btn-edit inline"
            href="{{ URL::to('turma/create') }}">Nova turma
        </a>
    @endcan
</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@include('turma.table')
</div>
@endsection
