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
	<div id="root" class="container p-0 m-0 mx-auto">
        <div class="bg-warning p-3">

            <div class="p-3 bg-info">
                @if (Auth::check())
                    HELLÓ {{ Auth::user()->name }} !!!
                @endif
            </div>

            <p>Ez lesz a START OLDAL.</p>
            <a href="{{route('test')}}" class="btn btn-primary">TEST OLDAL</a>


            <a href="{{route('admin_login')}}" class="btn btn-primary">admin_login</a>
            <a href="{{route('admin_index')}}" class="btn btn-primary">admin_INDEX</a>
        </div>
	</div>
    <script src="/modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="/modules/jquery/dist/jquery.min.js"></script>
    <script src="/js/admin.js"></script>
    <script>
	    window.jQuery.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    </script>
</body>
</html>