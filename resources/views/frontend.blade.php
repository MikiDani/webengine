<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}" data-url-prefix="/" data-footer="true">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{csrf_token()}}">
	<meta name="application-name" content="{{config('add.sitename')}}">
	<title>{{config('add.sitename')}}</title>
	<link rel="apple-touch-icon" sizes="180x180" href="/img/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/img/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/img/favicons/favicon-16x16.png">
	<link rel="manifest" href="/img/favicons/site.webmanifest">
	<link rel="shortcut icon" href="/img/favicons/favicon.ico">

	<link rel="stylesheet" href="/modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/scss/style.css">
</head>
<body class="bg-light">
	@if (Auth::check()) 
		<div class="bg-dark p-3 text-center border-bottom border-info mb-3">
			<a href="{{route('admin_index')}}" class="btn btn-primary">ADMIN</a>
		</div>
	@else
		<div class="bg-dark p-3 text-center border-bottom border-info mb-3">
			<a href="{{route('admin_login')}}" class="btn btn-primary">Login</a>
		</div>
	@endif

	<div id="root" class="container-fluid p-0 m-0 mx-auto">
		<div class="row p-0 m-0">
			@if(session('message'))
				<h6 class="p-0 m-0 text-center">{!! session('message') !!}</h6>
				@php session()->forget('message'); @endphp
			@endif
		</div>
		<div id="app-container"></div>	{{-- REACT --}}
	</div>
	
	<script src="/modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="/modules/jquery/dist/jquery.min.js"></script>

	<script src="/modules/react/react.development.js"></script>
	<script src="/modules/react/react-dom.development.js"></script>
	<script src="/js/app.js"></script>

	<script src="/js/admin.js"></script>
	<script>
		window.jQuery.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
	</script>
</body>
</html>