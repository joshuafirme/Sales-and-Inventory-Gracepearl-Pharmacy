<!DOCTYPE html>
<html>
<head>
	<title>Gracepearl Pharmacy</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1">
     <link href="{{asset('components/css/login-style.css')}}" rel="stylesheet">
</head>
<body>
	<img class="bg" src="{{asset('assets/gracepearl-bg.jpg')}}">
	<div class="container">
		<div class="img">
			<img src="assets/bg.svg">
		</div>
		<div class="login-container">
			<form action="{{ action('DashboardCtr@index') }}">
				<img class="avatar" src="assets/avatar.svg">
			

				<div class="input-div">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div>
						<h5>Username</h5>
						<input class="input" type="text">
					</div>
				</div>

				<div class="input-div">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div>
						<h5>Password</h5>
						<input class="input" type="password">
					</div>
				</div>
				<a href="#">Forgot Password?</a>
				<input type="submit" class="btn" value="Login">	
				<p>or</p>
				<button type="button" class="btn-google">Sign in with Google</button>

			</form>	
		</div>

	</div>


<script src="{{asset('components/js/fontawesome.js')}}"></script>
<script src="{{asset('components/js/login.js')}}"></script>

</body>
</html>