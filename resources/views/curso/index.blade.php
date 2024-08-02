@extends('layouts.base')
@section('content')
    <div class="row">
        <h1>Exercícios</h1>
    </div>

    <div class="row gridline">
        @can ('create', App\Models\Turma::class)
            <a class="btn btn-small btn-edit inline"
                href="{{ URL::to('turma/create') }}">Cadastrar turma
            </a>
        @endcan
        @can ('create', App\Models\Curso::class)
            <a class="btn btn-small btn-edit inline"
                href="{{ URL::to('curso/create') }}">Novo curso
            </a>
        @endcan
    </div>

    <div class="row">
        <!-- will be used to show any messages -->
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
    </div>
    <!-- content -->
    @include('curso.table', ['editButton' => true])

@endsection
