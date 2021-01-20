<!-- sidebar nav -->
<nav id="sidebar-nav">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('turma') }}">Turmas</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('turma') }}">Todas as turmas</a></li>
        <li><a href="{{ URL::to('turma/create') }}">Criar uma turma</a>
    </ul>
</nav>
