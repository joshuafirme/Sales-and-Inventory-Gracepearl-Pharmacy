@extends('customer.layouts.main')

@section('content')

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
                <h5>Basic Information</h5>
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

            <div class="col-md-6">
                <label class="label-small text-muted">House/Unit/Flr #, Bldg Name, Blk or Lot #</label>
                <p>Blk 4 lot 9 palm estate subd.</p>
            </div> 

            <div class="col-md-6">
                <label class="label-small text-muted">Municipality</label>
                <p>Nasugbu</p>
            </div> 

            <div class="col-md-6">
                <label class="label-small text-muted">Barangay</label>
                <p>brgy Cogunan</p>
            </div> 

            <div class="col-md-6">
                <label class="label-small text-muted">Notes</label>
                <p>unang bahay sa kaliwa</p>
            </div> 


            <div class="col-md-12 mt-2">
                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#editAccountModal"><i class="fas fa-edit"></i> Edit Profile</button>
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