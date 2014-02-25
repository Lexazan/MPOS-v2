<!DOCTYPE html>
<html>
	<head>
		<title>Phalcon PHP Framework</title>
    {{ stylesheet_link('bootstrap/css/bootstrap.css') }}
    {{ stylesheet_link('bootstrap/css/bootstrap-responsive.css') }}
	</head>
	<body>
		{{ content() }}
    {{ javascript_include('js/jquery-1.11.0.min.js') }}
    {{ javascript_include('bootstrap/js/bootstrap.js') }}
	</body>
</html>
