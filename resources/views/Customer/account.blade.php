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

    <div class="col-lg-8 m-auto"><h4 class="mt-2 mb-2">My Account</h4></div>
  
      <!--Grid column-->
      <div class="col-lg-8 m-auto">
  
        <!-- Card -->
        <div class="card wish-list mb-3">
          <div class="card-body card-cart">

            <div class="row">
            
            <div class="col-md-12 mb-2">
                <h5 class="mb-0">Basic Information</h5>
                <span class="badge badge-secondary" id="verification-badge">Not verified</span>
                <a href="" class="text-primary label-small ml-2" style="display: none"
                data-toggle="modal" data-target="#uploadIDModal" id="verify-link">Verify</a>
            </div>

            @foreach($account as $data)

            <div class="col-md-4">
                <label class="label-small text-muted" >Full Name</label>
                <p>{{ $data->fullname }}</p>
            </div>

            <div class="col-md-4">
                <label class="label-small text-muted">Email Address</label>
                <p>{{ $data->email }}</p>
            </div>

            <div class="col-md-4">
                <label class="label-small text-muted">Phone Number</label>
                @if($data->phone_no)
                <p>{{ $data->phone_no }}</p>
                @else
                <p>-</p>
                @endif
            </div> 

            <div class="col-md-12 mb-2">
                <hr>
            </div>

            @endforeach

            <div class="col-md-12 mb-2">
                <h5>Shipping Address</h5>
            </div>

            @foreach($shipping as $data)

            <div class="col-md-6">
                <label class="label-small text-muted">House/Unit/Flr #, Bldg Name, Blk or Lot #</label>
                <p>{{ $data->flr_bldg_blk }}</p>
            </div> 

            <div class="col-md-6">
                <label class="label-small text-muted">Municipality</label>
                <p>{{ $data->municipality }}</p>
            </div> 

            <div class="col-md-6">
                <label class="label-small text-muted">Barangay</label>
                <p>{{ $data->brgy }}</p>
            </div> 

            <div class="col-md-6">
                <label class="label-small text-muted">Notes</label>
                <p>{{ $data->note }}</p>
            </div> 

            @endforeach

            <div class="col-md-6 mt-2">
                <button id="btn-edit-account" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editAccountModal"><i class="fas fa-edit"></i> Edit Account</button>
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

       <!--loading Modal-->
       @extends('customer.layouts.modals')
       @section('editAccountModal')
       @endsection

      
@endsection