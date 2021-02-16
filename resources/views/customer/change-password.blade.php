@extends('customer.layouts.main')

@section('content')

@if(\Session::has('success'))
<div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <h5><i class="icon fas fa-check"></i> </h5>
  {{ \Session::get('success') }}
</div>
@endif

<div class="container-fluid div-my-account">

    <!--Section: Block Content-->
<main class="m-auto">

    <!--Grid row-->
    <div class="row mt-2">

    <div class="col-lg-8 m-auto"><h4 class="mt-2 mb-2">Change Password</h4></div>
  
      <!--Grid column-->
      <div class="col-lg-8 m-auto">
  
        <!-- Card -->
        <div class="card wish-list mb-3">
          <div class="card-body card-cart">

            @if(\Session::has('success'))
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-check"></i> </h5>
              {{ \Session::get('success') }}
            </div>
            @endif

                <div class="row">
                    
                        <div class="col-md-12 mb-4">
                            <p class="mb-0">We will send you a one time code to your email or phone number to update your password.</p>
                        </div>

                        <div class="col-md-12 mb-4">
                            <a class="btn btn-outline-success verify-email active"><i class="fas fa-mail-bulk"></i> Verify through email</a> 
                            <a class="btn btn-outline-success verify-sms"><i class="fas fa-sms"></i> Verify through SMS</a>
                        </div>

                        <div class="col-md-6 mb-4" style="margin-top: 5px;">
                            <input type="hidden" name="send-code-to" id="send-code-to_hidden" value="{{ $email }}">
                            <a class="send-code-to">{{ $email /*substr_replace(,'****',3,9)*/ }}</a>
                        </div>

                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="4 digits code" id="vcode">
                            <a id="send-email-code" style="cursor: pointer; color:#32638D;" class="label-small"><u>Send Code</u></a>
                            <span class="countdown label-small"></span>
                
                        </div>

                        <div class="col-md-6">
                            <label class="label-small">New Password</label>
                            <input type="password" class="form-control" name="new-password" id="new-password">
                        </div>

                        <div class="col-md-3 mt-4">
                            <button id="btn-update-password" class="btn btn-md btn-primary">Update Password</button>
                        </div>

                </div>

            </div>      
          </div>
        </div>
        <!-- Card -->
  
      </div>
      <!--Grid column-->
  
   
  
    </div>
    <!--Grid row-->
  
</main>
  <!--Section: Block Content-->

</div>


      
@endsection