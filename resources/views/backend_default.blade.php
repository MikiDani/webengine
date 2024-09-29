<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-url-prefix="/" data-footer="true">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{csrf_token()}}">
	<meta name="application-name" content="{{env('APP_NAME')}} BACKEND">
	<title>{{env('APP_NAME')}}</title>
	<link rel="apple-touch-icon" sizes="180x180" href="/img/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/img/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/img/favicons/favicon-16x16.png">
	<link rel="manifest" href="/img/favicons/site.webmanifest">
	<link rel="shortcut icon" href="/img/favicons/favicon.ico">
	<link rel="stylesheet" href="/modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/modules/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" href="/scss/backend_style.css">
</head>
<body class="bg-dark">
	@yield('content')
	<script src="/modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="/modules/jquery/dist/jquery.min.js"></script>
	<script src="/modules/jquery-validation/dist/jquery.validate.js"></script>
	<script src="/modules/jquery-ui/dist/jquery-ui.min.js"></script>
	@yield('page_js')
	<script>
		window.jQuery.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}})
		var lang = "{{ str_replace('_', '-', app()->getLocale()) }}"
	</script>
</body>
</html>