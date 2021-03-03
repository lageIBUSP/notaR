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
			@include('includes.sidebar')
		</div>

		<div id="content" class="col-md-8">
			@yield('content')
		</div>
	</div>
</div>

@include('includes.footer')

</body>
</html>
