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
        <h3>Sua sessão expirou!</h3>
        <p>Se você está vendo essa página, é porque o seu navegador ficou muito tempo inativo antes de enviar um formulário.
            <ol>
                <li>Usando os botões do navegador, volte para a página anterior, copie o que você fez em um bloco de notas e recarregue a página.</li>
                <li>Evite deixar a página do notaR aberta por mais de uma hora.</li>
                <li>De qualquer forma, você sempre pode voltar para a nossa <a href="/">página inicial!</a></li>
            </ol>
        </p>
      </div>
    </div>
</div>
</body>
</html>