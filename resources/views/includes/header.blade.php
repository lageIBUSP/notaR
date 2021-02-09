<header class="topbar">
    <h1>
        nota<span class="R">R</span>
        <img src="{{ asset('img/logo.png') }}" title="Logo" class="logo">
    </h1>
  @if (Auth::check())
  <div class="dropdown">
    <a class="dropdown-toggle" type="button" data-toggle="dropdown" href="">{{ Auth::user()->email }}</a>
    <div class="dropdown-menu">
      <a href="{{ URL::to('user/' . Auth::user()->id ) }}"><div class="dropdown-item">Meu perfil</div></a>
      <form method="POST" action="{{ route('logout') }}">
      @csrf
      <a href="{{ URL::to('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
        <div class="dropdown-item">Sair</div>
      </a>
      </form>
</div>
  </div>
  @else
    <a class="" href="{{ URL::to('login') }}">Entrar</a>
  @endif
</div> 
</header>