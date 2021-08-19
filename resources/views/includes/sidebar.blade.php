<!-- sidebar nav -->
<nav id="sidebar-nav">
    @can ('list', App\Models\Turma::class)
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('turma') }}">Turmas</a>
        </div>
        <ul class="nav navbar-nav">
            @can ('create', App\Models\Turma::class)
            <li><a href="{{ URL::to('turma/create') }}">Cadastrar turma</a></li>
            @endcan
        </ul>
    @endcan
    @can ('list', App\Models\User::class)
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('user') }}">Usuários</a>
        </div>
        <ul class="nav navbar-nav">
            @can ('create', App\Models\User::class)
            <li><a href="{{ URL::to('user/create') }}">Cadastrar usuário</a></li>
            @endcan
        </ul>
    @endcan
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('exercicio') }}">Exercícios</a>
    </div>
    <ul class="nav navbar-nav">
        @can ('create', App\Models\Exercicio::class)
        <li><a href="{{ URL::to('exercicio/create') }}">Cadastrar exercicio</a></li>
        @endcan
    </ul>
    @can ('list', App\Models\Arquivo::class)
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('arquivo') }}">Arquivos</a>
        </div>
        <ul class="nav navbar-nav">
            @can ('create', App\Models\Arquivo::class)
            <li><a href="{{ URL::to('arquivo/create') }}">Upload de arquivo</a></li>
            @endcan
        </ul>
    @endcan
    @can ('view', App\Models\Relatorio::class)
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('relatorio') }}">Relatórios</a>
    </div>
    @endcan
    @can ('view', App\Models\Impedimento::class)
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('impedimento') }}">Impedimentos</a>
    </div>
    <ul class="nav navbar-nav">
        @can ('create', App\Models\Impedimento::class)
        <li><a href="{{ URL::to('impedimento/create') }}">Cadastrar impedimento</a></li>
        @endcan
    </ul>
    @endcan
</nav>
