@extends('layouts.auth')

@section('title')
  Register
@stop

@section('content')
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">

				<form class="login100-form validate-form" action="{{ route('register') }}" method="POST" style="background-color:white; padding-top:80px; margin: 0px auto;">
          {{ csrf_field() }}


					<span class="login100-form-title" style="font-family: Segoe UI; font-size:40px; font-weight:100;margin-top: -40px;">
						EASS - REGISTER
            @if(count($errors) > 0)
              <span style="color:#c0392b; font-weight:700;">Fail <i class="fa fa-meh-o"></i> </span>
            @endif
					</span>

          <div class="wrap-input100 validate-input" data-validate = "Fullname is required" style="border-radius: 0px;">
						<input class="input100" type="text" name="name" autocomplete="off">
						<span class="focus-input100"></span>
						<span class="label-input100">What is your name</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz" style="border-radius: 0px;">
						<input class="input100" type="email" name="email" autocomplete="off">
						<span class="focus-input100"></span>
						<span class="label-input100">Your Email</span>
					</div>


					<div class="wrap-input100 validate-input" data-validate="Password is required - At least 6 letters or numbers" style="border-radius: 0px;">
						<input class="input100" type="password" name="password" autocomplete="new-password">
						<span class="focus-input100"></span>
						<span class="label-input100">Create New Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32 parent-check-box">
						<div class="contact100-form-checkbox">

						</div>

						<div>
							<a href="#" class="txt1">
								By clicking on the registration you are deemed to agree to the Terms of Privacy and Use!
							</a>
						</div>
					</div>


					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							 register now
						</button>
					</div>

					<div class="text-center p-t-46 p-b-20">
						<span class="txt2" style="display:block;">
							or <a href="{{ route('login') }}">LOGIN</a>
						</span>
            <span class="txt2">
              Made by <i class="fa fa-heart"></i> Barq Moath <i class="fa fa-copyright"></i> 2019
            </span>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop
