@foreach ($topicos as $value)

    <a class="collapse-button collapsed" data-toggle="collapse"
        href="#topico{{$value->order}}"
        role="button" aria-expanded="true"
        aria-controls="topico{{$value->order}}">
        <h2>{{$value->name}}

                <!-- edit -->
                @can ('edit', $value)
                <a class="btn btn-small btn-edit" href="{{ URL::to('topico/' . $value->id . '/edit') }}">Editar</a>
                @endcan
        </h2>
    </a>
    <div class="collapse show" id="topico{{$value->order}}">
        @include('exercicio.table', ['editButton' => true, 'exercicios' => $value->exercicios])
    </div>

@endforeach

{{-- exercicios sem topico --}}
<a class="collapse-button collapsed" data-toggle="collapse"
    href="#semTopico"
    role="button" aria-expanded="true"
    aria-controls="semTopico">
    <h2>Outros exercícios</h2>
</a>
<div class="collapse show" id="semTopico">
    @include('exercicio.table', ['editButton' => true, 'exercicios' => $semTopico])
</div>