<!DOCTYPE html>
<html>
<head>
	<title>Gracepearl Pharmacy</title>
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link href="{{asset('components/vendor/bootstrap4/css/bootstrap.min.css')}}" rel="stylesheet"> 
     <link href="{{asset('components/css/signup.css')}}" rel="stylesheet">
     <link rel="preconnect" href="https://fonts.gstatic.com">
     <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700;900&display=swap" rel="stylesheet">
    
	 <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	<img class="bg" src="{{asset('assets/gp-bg.jpg')}}">
	<div class="container-fluid">

        <div class="row mt-3 p-5">

            <div class="card col-md-5 m-auto">
                
                <div class="card-body">

                    <div class="alert alert-success" role="alert" id="alert-acc-success" style="display: none;">
                    </div> 
                    
                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <h4 style="color: #555555">Create your account</h4>
                        </div> 
    
                        <div class="col-md-6 mb-3">
                            <label class="label-small">Fullname</label>
                            <input type="text" class="form-control" id="fullname" placeholder="First Last">
                        </div> 
            
                        <div class="col-md-6">
                            <label class="label-small">Phone Number</label>
                            <input type="text" maxlength="11" class="form-control" id="phone_no">
                            <a id="send-OTP" style="cursor: pointer; color:#32638D;" class="label-small"><u>Send OTP</u></a>
                            <span class="countdown label-small"></span>
                        </div> 

                        <div class="col-md-6">
                            <label class="label-small">Enter your OTP</label>
                            <input type="text" class="form-control" id="otp" placeholder="Enter your 4 digit OTP">
                        </div> 
    
                        <div class="col-md-6 mb-3">
                            <label class="label-small">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Minimun of 6 characters">
                        </div> 

                        <div class="col-md-6">
                            <label class="label-small">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password">
                        </div> 
                       
                        <div class="col-md-6">
                            <input type="button" class="btn" id="btn-signup" value="SIGN UP">
                            <span class="label-small m-0">By clicking "SIGN UP"; I agree to Gracepearl Pharmacy's 
                                <a href="/terms_and_condition" target="_blank">Terms of Use</a> and <a href="/privacy-policy" target="_blank">Privacy Policy</a>
                            </span>	
                        </div>

                        <div class="col-md-12"><hr></div>

                        <div class="col-md-12">
                            <p class="label-small">Or, sign up with</p>
                        </div>
    
                        <div class="col-md-6">
                            <button onclick="location.href = 'customer-login/google';" type="button" class="btn-google">Sign up with Google</button>
                        </div>

                        <div class="col-md-6">
                            <button onclick="location.href = 'customer-login/google';" type="button" class="btn-fb">Sign up with Facebook</button>
                        </div>

                        <div class="col-md-6">
                            <span class="label-small m-0"> Already have an account?
                                <a href="/customer-login"> Login </a>  here.
                            </span>	
                        </div>

                       
    
                </div>	
            </div>
    
        </div>

        </div>
        @extends('customer.layouts.loading_modal')
        @section('modals')
        @endsection
    </div>

    <script src="{{asset('components/vendor/jquery3/jquery.min.js')}}"></script>
    <script src="{{asset('components/vendor/bootstrap4/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('components/js/script.js')}}"></script>
	<script src="{{asset('components/js/fontawesome.js')}}"></script>
	<script src="{{asset('components/js/login.js')}}"></script>
	<script src="{{asset('js/admin-login.js')}}"></script>
    <script src="{{asset('js/customer/signup.js')}}"></script>

</body>
</html>