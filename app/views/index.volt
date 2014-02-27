<!DOCTYPE html>
<html>
	<head>
    {{ get_title() }}
    {{ stylesheet_link('bootstrap/css/bootstrap.css') }}
    {{ stylesheet_link('bootstrap/css/bootstrap-responsive.css') }}
    {{ stylesheet_link('css/style.css') }}
	</head>
	<body>
		{{ content() }}
    {{ javascript_include('js/jquery-1.11.0.min.js') }}
    {{ javascript_include('bootstrap/js/bootstrap.js') }}
    {{ javascript_include('js/utils.js') }}
	</body>
</html>
