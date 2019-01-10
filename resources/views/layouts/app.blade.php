<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ Request::root() }}/vendor/main/img/favicon.png"/>
    <title>
      @yield('title')
    </title>
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Andika" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/main/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/main/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/main/css/mdb.min.css">
    <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/main/css/style.min.css">
    <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/main/css/ms.css">
    @yield('css')
  </head>
  <body>
    @include('includes.header')
    <div class="">
      @yield('content')
    </div>
    @include('includes.footer')
    <!-- JS -->
    <script type="text/javascript" src="{{ Request::root() }}/vendor/main/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="{{ Request::root() }}/vendor/main/js/popper.min.js"></script>
    <script type="text/javascript" src="{{ Request::root() }}/vendor/main/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ Request::root() }}/vendor/main/js/mdb.min.js"></script>
    <script type="text/javascript" src="{{ Request::root() }}/vendor/main/js/ms.js"></script>
    @yield('js')
  </body>
</html>
