@foreach ($topicos as $value)

    <a class="collapse-button collapsed" data-toggle="collapse"
        href="#topico{{$value->id}}"
        role="button" aria-expanded="false"
        aria-controls="topico{{$value->id}}">
        <h2>
            {{$value->name}}
            <i class="fa fa-chevron-right rotate"></i>

            <!-- edit -->
            @can ('edit', $value)
            <a class="btn btn-small btn-edit pull-right" href="{{ URL::to('topico/' . $value->id . '/edit') }}">Editar</a>
            @endcan
        </h2>
    </a>
    <div class="collapse" id="topico{{$value->id}}">
        @include('exercicio.table', ['editButton' => true, 'exercicios' => $value->exercicios])
    </div>

@endforeach

{{-- exercicios sem topico --}}
<a class="collapse-button collapsed" data-toggle="collapse"
    href="#semTopico"
    role="button" aria-expanded="false"
    aria-controls="semTopico">
    <h2>Outros exercícios
    <i class="fa fa-chevron-right rotate"></i>
    </h2>
</a>
<div class="collapse" id="semTopico">
    @include('exercicio.table', ['editButton' => true, 'exercicios' => $semTopico])
</div>