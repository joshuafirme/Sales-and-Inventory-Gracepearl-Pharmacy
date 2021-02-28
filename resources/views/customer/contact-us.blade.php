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

  
  
        <!-- Card -->
<div class="card col-xs-12 col-md-8 col-lg-6 mb-3 m-auto">
    <div class="card-body card-cart">
    <!--Grid row-->
    <div class="row d-flex justify-content-center">

      <!--Grid column-->
      <div class="col-md-6 text-center">

        <h3 class="font-weight-bold">Contact Us</h3>

        <p class="text-muted">Get in touch with us by filling the details below</p>

      </div>
      <!--Grid column-->

    </div>
    <!--Grid row-->

    <!--Grid row-->
    <div class="row">

      <!--Grid column-->
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">

        <div class="row">


          <div class="col-12 mb-3">
              <label class="label-small">Fullname</label>
              <input type="text" class="form-control" id="fullname" @if($fullname) value="{{ $fullname }}" @endif placeholder="First Last">
          </div>

          <div class=" col-md-12 col-xl-12 col-sm-12 mb-3">
              <label class="label-small">Email</label>
              <input type="text" class="form-control" id="email" @if($email) value="{{ $email }}" @endif>
          </div>
          
          <div class="col-xl-12 col-sm-12 col-md-12 mb-3">
              <label class="label-small">Phone</label>
              <input type="text" class="form-control" id="contact_no" @if($phone_no) value="{{ $phone_no }}" @endif>
          </div>

          <div class="col-md-12">
              <label class="label-small">Message</label>
              <textarea type="password" class="form-control" id="message"></textarea>
          </div>

          <div class="col-12 mt-3 mb-xs-3 mb-sm-3 ">
              <button id="btn-send-message" class="btn btn-sm btn-success">Send Message<i class="fas fa-paper-plane ml-2"></i></button>
          </div>

      </div>


      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-md-12 col-xl-6 mb-0 mb-md-0">

          <!--Google map-->
          <div id="map-container-google-1" class="z-depth-1 map-container mb-4">
            <img class="mg-fluid img-thumbnail" src="{{ asset('assets/gp_loc.png') }}" style="width:100%;height:400px;">
          </div>
          <!--Google Maps-->


        </div>
        <!--Grid column-->

    </div>
                    
                <div class="alert alert-success alert-dismissible mt-3" style="display: none;" id="message-success">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i> </h5>
                  <p>Message sent successfully!</p>
                </div>

                </div>  
                
                 <!--Grid row-->
      <div class="row text-center">

        <!--Grid column-->
        <div class="col-lg-4 col-md-12 mb-4 mb-md-0">

          <i class="fas fa-map-marker-alt fa-2x blue-text"></i>

          <p class="font-weight-bold my-3">Address</p>

          <p class="text-muted">F Alix St. Brgy 11 Nasugbu, Batangas 4231</p>

        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">

            <i class="fas fa-phone fa-2x blue-text"></i>

            <p class="font-weight-bold my-3">Phone number</p>
  
            <p class="text-muted">+6397-239-2039</p>

        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">

            <i class="fas fa-envelope fa-2x blue-text"></i>

            <p class="font-weight-bold my-3">E-mail</p>
  
            <p class="text-muted">cs@gracepearlpharmacy.com</p>

        </div>
        <!--Grid column-->

      </div>
      <!--Grid row-->
              </div>
            <!-- Card -->
          <!--Grid column-->
  
   
  
    </div>
    <!--Grid row-->
  
  <!--Section: Block Content-->

  

</div>


 {{--
<script>
  function myMap() {
  var mapProp= {
    center:new google.maps.LatLng(14.071167464009417, 120.63113972488522),
    zoom:5,
  };
  var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
  }
  </script>
  
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtQjcQtV8EeoPWUJwR6tLkS_3DOuWy3GQ&callback=myMap" async defer></script>--}}
      
@endsection