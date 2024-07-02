<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	@include('includes.head')
</head>
<body>

@include('includes.header')

<div class="container container-main">
	<div class="row">
    <div id="sidebar" class="col-md-2">
        <!-- sem sidebar, mas mantemos o espaçamento -->
    </div>
      <div id="content" class="col-md-10">
        <h1>Ops!</h1>
        <h3>Algo deu errado!</h3>
        <p>Se você está vendo essa página, é porque algo inesperado deu errado. Mas não se preocupe:
            <ol>
                <li>Avise um administrador para que possamos corrigir o problema.</li>
                <li>Tente novamente mais tarde.</li>
                <li>De qualquer forma, você sempre pode voltar para a nossa <a href="/">página inicial!</a></li>
            </ol>
        </p>
      </div>
    </div>
</div>
</body>
</html>