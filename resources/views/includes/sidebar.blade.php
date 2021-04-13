<!-- sidebar nav -->
<nav id="sidebar-nav">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('turma') }}">Turmas</a>
    </div>
    <ul class="nav navbar-nav">
        @can ('create', App\Model\Turma::class)
        <li><a href="{{ URL::to('turma/create') }}">Cadastrar turma</a></li>
        @endcan
    </ul>
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('user') }}">Usuários</a>
    </div>
    <ul class="nav navbar-nav">
        @can ('create', App\Model\User::class)
        <li><a href="{{ URL::to('user/create') }}">Cadastrar usuário</a></li>
        @endcan
    </ul>
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('exercicio') }}">Exercícios</a>
    </div>
    <ul class="nav navbar-nav">
        @can ('create', App\Model\Exercicio::class)
        <li><a href="{{ URL::to('exercicio/create') }}">Cadastrar exercicio</a></li>
        @endcan
    </ul>
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('arquivo') }}">Arquivos</a>
    </div>
    <ul class="nav navbar-nav">
        @can ('create', App\Model\Arquivo::class)
        <li><a href="{{ URL::to('arquivo/create') }}">Upload de arquivo</a></li>
        @endcan
    </ul>
</nav>
