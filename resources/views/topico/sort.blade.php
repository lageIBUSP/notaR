@extends('layouts.base')
@section('content')

<div class="container">
    <form action="{{URL::to('/topico/sort')}}" method="POST">
        @csrf
        @method ('put')

        <div class="alert alert-info">
            Arraste para reordenar!
        </div>
        <table class="table table-striped table-bordered sortable">
            <thead>
                <tr>
                    <td>Tópico</td>
                </tr>
            </thead>
            <tbody>
                @foreach (old('topico_id', $topicos) as $value)
                <tr>
                    <td>
                        <input type='hidden'
                            id="topico_id[]"
                            name="topico_id[]"
                            value="{{$value->id}}">
                        {{ $value->name }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
