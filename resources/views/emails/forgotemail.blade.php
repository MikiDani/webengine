<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<h4>Hello {{ $username }} !</h4>
	<br/>
	You have indicated that you have forgotten your password. If you want to set a new one, click on the link:<br/>
	<a href="{{ $activate_url }}" target="_blank" style="text-decoration:none;">{{ $activate_url }}</a><br/>
	<br/>
	<hr/>
	<h4 style="text-align:center;"><strong>WebEngine - The best engine!<strong></h4>
	<hr/>
</body>
</html>