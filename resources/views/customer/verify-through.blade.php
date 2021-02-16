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

    <div class="col-lg-8 m-auto"><h4 class="mt-2 mb-2">Verify Through</h4></div>
  
      <!--Grid column-->
      <div class="col-lg-8 m-auto">
  
        <!-- Card -->
        <div class="card wish-list mb-3">
          <div class="card-body card-cart">

                <div class="row">
                    
                        <div class="col-md-12 mb-4">
                            <p class="mb-0">To protect your account security, we need to verify your identity</p>
                        </div>

                        <div class="col-md-12">
                            <a class="btn btn-outline-success"><i class="fas fa-mail-bulk"></i> Verify through email</a> 
                            <a class="btn btn-outline-success"><i class="fas fa-sms"></i> Verify through SMS</a>
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