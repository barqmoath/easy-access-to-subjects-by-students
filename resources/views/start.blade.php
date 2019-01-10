<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EASS</title>
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Andika" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/main/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/main/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/main/css/mdb.min.css">
    <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/main/css/style.min.css">
    <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/vendor/main/css/start-style.css">
  </head>
  <body>
    <div class="container">

			<div class="st-container">

				<input type="radio" name="radio-set" checked="checked" id="st-control-1"/>
				<a href="#st-panel-1">EASS INTRO</a>
				<input type="radio" name="radio-set" id="st-control-2"/>
				<a href="#st-panel-2">HAPPINESS</a>
				<input type="radio" name="radio-set" id="st-control-3"/>
				<a href="#st-panel-3">TRANQUILLITY</a>
				<input type="radio" name="radio-set" id="st-control-4"/>
				<a href="#st-panel-4">SIMPLE</a>
				<input type="radio" name="radio-set" id="st-control-5"/>
				<a href="#st-panel-5">ABOUT</a>

				<div class="st-scroll">

					<section class="st-panel" id="st-panel-1">
            <div class="st-deco" data-icon="&#xf069;"></div>
						<h2>Welcome in EASS</h2>
						<p>
              Use Or Create Your Personal Account Now And Achieve The Greatest Benefit From EASS
              <br>
              <br>
              <a href="{{ route('login') }}" class="btn btn-primary btn-login"> <i class="fa fa-sign-in"></i> Login</a>
              <a href="{{ route('register') }}" class="btn btn-primary btn-register"> <i class="fa fa-slack"></i> Register</a>
              <br>
              <br>
              Made by <i class="fa fa-heart"></i> Barq Moath <i class="fa fa-copyright"></i> 2019
            </p>
					</section>

					<section class="st-panel st-color" id="st-panel-2">
						<div class="st-deco" data-icon="&#xf118;"></div>
						<h2>Happiness</h2>
						<p>It is a happy network between students at the college ...</p>
					</section>

					<section class="st-panel" id="st-panel-3">
						<div class="st-deco" data-icon="&#xf0f4;"></div>
						<h2>Tranquillity</h2>
						<p>Everything Will Be Delivered To You On Time, Anytime, Anywhere ... And For Anything Related To Your Current Stage.</p>
					</section>

					<section class="st-panel st-color" id="st-panel-4">
						<div class="st-deco" data-icon="&#xf06c;"></div>
						<h2>Simple</h2>
						<p>Everything Is Simple And Easy To Use .. Everything Is Beautiful And You Enjoy Using It <i class="fa fa-smile-o"></i> .</p>
					</section>

					<section class="st-panel" id="st-panel-5">
						<div class="st-deco" data-icon="&#xf004;"></div>
						<h2>About</h2>
						<p>Fixie ad odd future polaroid dreamcatcher, nesciunt carles bicycle rights accusamus mcsweeney's mumblecore nulla irony.</p>
					</section>

				</div><!-- // st-scroll -->

			</div><!-- // st-container -->

    </div>
    <!-- JS -->
    <script type="text/javascript" src="{{ Request::root() }}/vendor/main/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="{{ Request::root() }}/vendor/main/js/popper.min.js"></script>
    <script type="text/javascript" src="{{ Request::root() }}/vendor/main/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ Request::root() }}/vendor/main/js/mdb.min.js"></script>
    <script type="text/javascript">

    </script>
  </body>
</html>
