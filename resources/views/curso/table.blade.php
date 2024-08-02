@foreach ($cursos as $value)

    <a class="collapse-button collapsed" data-toggle="collapse"
        href="#curso{{$value->id}}"
        role="button" aria-expanded="false"
        aria-controls="curso{{$value->id}}">
        <h2>
            {{$value->name}}
            <i class="fa fa-chevron-right rotate"></i>

            <!-- edit -->
            @can ('edit', $value)
            <a class="btn btn-small btn-edit pull-right" href="{{ URL::to('curso/' . $value->id . '/edit') }}">Editar</a>
            @endcan
        </h2>
    </a>
    <div class="collapse" id="curso{{$value->id}}">
        @include('turma.table', ['editButton' => true, 'turmas' => $value->turmas])
    </div>

@endforeach

{{-- turmas sem curso --}}
<a class="collapse-button collapsed" data-toggle="collapse"
    href="#semcurso"
    role="button" aria-expanded="false"
    aria-controls="semcurso">
    <h2>Outras turmas
    <i class="fa fa-chevron-right rotate"></i>
    </h2>
</a>
<div class="collapse" id="semcurso">
    @include('turma.table', ['editButton' => true, 'turmas' => $semCurso])
</div>