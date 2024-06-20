@extends('layouts.base')
@section('content')
<h1>
    Usuários
    @can ('create', App\Models\User::class)
        <a class="btn btn-small btn-edit inline"
            href="{{ URL::to('user/create') }}">Novo usuário
        </a>
    @endcan
</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@include('user.table')
</div>
@endsection
