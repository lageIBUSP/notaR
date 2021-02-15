<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	@include('includes.head')
</head>
<body>

<div class="container container-flex-center">
	@yield('content')
</div>

</body>
</html>
