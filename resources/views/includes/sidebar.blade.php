<!-- sidebar nav -->
<nav id="sidebar-nav">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('curso') }}">Cursos</a>
    </div>
    @can ('list', App\Models\User::class)
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('user') }}">Usuários</a>
        </div>
    @endcan
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('exercicio') }}">Exercícios</a>
    </div>
    @can ('list', App\Models\Arquivo::class)
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('arquivo') }}">Arquivos</a>
        </div>
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
    @endcan
</nav>
