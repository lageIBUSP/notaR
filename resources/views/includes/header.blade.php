<header class="topbar">
    <h1>
        nota<span class="R">R</span>
        <img src="{{ asset('img/logo.png') }}" title="Logo" class="logo">
    </h1>
  @if (Auth::check())
  <div class="dropdown">
    <a class="dropdown-toggle" type="button" data-toggle="dropdown" href="">{{ Auth::user()->email }}</a>
    <ul class="dropdown-menu">
        <li><a href="{{ URL::to('user/' . Auth::user()->id ) }}">Meu perfil</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ URL::to('logout') }}"
                onclick="event.preventDefault(); this.closest('form').submit();">
                Sair
            </a></li>
            </form>
    </ul>
  </div>
  @else
    <a class="" href="{{ URL::to('login') }}">Entrar</a>
  @endif
</div> 
</header>