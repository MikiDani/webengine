<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<h4>{{ __('messages.forgotemail.texthello') }} {{ $username }} !</h4>
	<br/>
	{{ __('messages.forgotemail.textcontent') }}
	<br/>
	<a href="{{ $activate_url }}" target="_blank" style="text-decoration:none;">{{ $activate_url }}</a><br/>
	<br/>
	<hr/>
	<h4 style="text-align:center;"><strong>{{ __('messages.forgotemail.textfooter') }}<strong></h4>
	<hr/>
</body>
</html>
