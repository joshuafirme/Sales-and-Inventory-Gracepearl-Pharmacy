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

    <div class="col-lg-8 m-auto"><h4 class="mt-2 mb-2">Contact us</h4></div>
  
      <!--Grid column-->
      <div class="col-lg-8 m-auto">
  
        <!-- Card -->
        <div class="card wish-list mb-3">
          <div class="card-body card-cart">

                <div class="row">
                    
                        <div class="col-md-12 mb-4">
                            <p class="mb-0">Get in touch with us by filling the details below</p>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="label-small">Fullname</label>
                            <input type="text" class="form-control" id="fullname" value="{{ $fullname }}" placeholder="First Last">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="label-small">Email</label>
                            <input type="text" class="form-control" id="email" value="{{ $email }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="label-small">Phone</label>
                            <input type="text" class="form-control" id="phone_no" value="{{ $phone_no }}">
                        </div>

                        <div class="col-md-12">
                            <label class="label-small">Message</label>
                            <textarea type="password" class="form-control" id="message"></textarea>
                        </div>

                        <div class="col-md-3 mt-3">
                            <button id="btn-send-message" class="btn btn-sm btn-success">Send Message</button>
                        </div>

                </div>

            <div class="alert alert-success alert-dismissible mt-3" style="display: none;" id="message-success">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-check"></i> </h5>
              <p>Message sent successfully!</p>
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