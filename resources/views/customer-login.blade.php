<!DOCTYPE html>
<html>
<head>
	<title>Gracepearl Pharmacy</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <link href="{{asset('components/css/login-style.css')}}" rel="stylesheet">
	 <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	<img class="bg" src="{{asset('assets/gp-bg.jpg')}}">
	<div class="container">
		<div class="img">
			<img src="assets/undraw_medicine_b1ol.svg">
		</div>
		<div class="login-container">
			<div class="form">
				<img class="avatar" src="assets/avatar.svg">
			

				<div class="input-div">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div>
						<h5>Username</h5>
						<input class="input" type="text" id="admin-username">
					</div>
				</div>

				<div class="input-div">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div>
						<h5>Password</h5>
						<input class="input" type="password" id="admin-password">
					</div>
				</div>
				
				<input type="button" class="btn" id="btn-admin-login" value="Login">	
				<p>or</p>
				<button onclick="location.href = 'customer-login/google';" type="button" class="btn-google">Sign in with Google</button>

			</div>	
		</div>

	</div>

	<script src="{{asset('components/vendor/jquery3/jquery.min.js')}}"></script>
	<script src="{{asset('components/js/script.js')}}"></script>
	<script src="{{asset('components/js/fontawesome.js')}}"></script>
	<script src="{{asset('components/js/login.js')}}"></script>
	<script src="{{asset('js/admin-login.js')}}"></script>

</body>
</html>