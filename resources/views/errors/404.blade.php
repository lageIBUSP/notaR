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
        <h3>Não achamos o que você está procurando!</h3>
        <p>Se você está vendo essa página, é porque o servidor não encontrou o que você está buscando.
            <ol>
                <li>Se você digitou o endereço, verifique se está tudo certo.</li>
                <li>Se você seguiu um link, avise para algum administrador que o link está quebrado.</li>
                <li>De qualquer forma, você sempre pode voltar para a nossa <a href="/">página inicial!</a></li>
            </ol>
        </p>
      </div>
    </div>
</div>
</body>
</html>