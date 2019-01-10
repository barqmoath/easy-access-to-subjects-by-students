<!DOCTYPE html>
<html lang="en">
<head>
	<title>
    EASS @yield('title')
  </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="#"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/auth/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/auth/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/auth/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/auth/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/auth/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/auth/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/auth/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/auth/css/util.css">
	<link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/auth/css/main.css">
<!--===============================================================================================-->
</head>
<body style="background-color: white;">
  @yield('content')

<!--===============================================================================================-->
	<script src="{{ Request::root() }}/vendor/auth/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="{{ Request::root() }}/vendor/auth/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="{{ Request::root() }}/vendor/auth/vendor/bootstrap/js/popper.js"></script>
	<script src="{{ Request::root() }}/vendor/auth/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="{{ Request::root() }}/vendor/auth/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="{{ Request::root() }}/vendor/auth/vendor/daterangepicker/moment.min.js"></script>
	<script src="{{ Request::root() }}/vendor/auth/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="{{ Request::root() }}/vendor/auth/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="{{ Request::root() }}/vendor/auth/js/main.js"></script>
</body>
</html>
