<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<h4>Hello {{ $username }}!</h4>
	<br/>
	To confirm your email address, please press the confirm link:<br/>
	<a href="{{ $activate_url }}" target="_blank" style="text-decoration:none;">{{ $activate_url }}</a><br/>
	<br/>
	<hr/>
	<h4 style="text-align:center;"><strong>WebEngine - The best engine!<strong></h4>
	<hr/>
</body>
</html>
