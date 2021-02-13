@extends('customer.layouts.main')

@section('content')

<div class="container-fluid">

    <!--Section: Block Content-->
<main class="m-auto">

    <!--Grid row-->
    <div class="row">
  
      <!--Grid column-->
      <div class="col-lg-8 mt-3">

        <!-- Card -->
        <div class="card wish-list mb-3">
          <div class="card-body card-cart">
  
            <h5 class="mb-4">Checkout (<span class="count-cart"></span> items)</h5>
            
            <!-- check is cart is empty -->
            @if($cart !== null)
            @foreach($cart as $data)
            <div class="row mb-4">
              <div class="col-md-5 col-lg-3 col-xl-3">
                <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
                    @if(!$data->image)
                    <img src="../assets/noimage.png" class="img-fluid w-50">
                    @else
                    <img  src="../../storage/{{$data->image}}" class="img-fluid w-50" alt="...">
                    @endif
              
                </div>
              </div>
              
           
              <div class="col-md-7 col-lg-9 col-xl-9">
                <div>
                  
                  <div class="d-flex justify-content-between">
                    <div>
                      <p>{{ $data->description }}</p>
                      <p class="mb-3 text-muted text-uppercase small">Category - {{ $data->category_name }}</p>
                      <p class="mb-3 text-muted text-uppercase small">Unit type - {{ $data->unit }}</p>
                    </div>
                    <div>
                        <div class="def-number-input number-input safari_only mb-0 w-100">

                            <a class="mr-2">Qty: {{ $data->qty }} </a>
                            <p class="mt-2"><span class="text-success">₱{{ $data->amount }}</span></p>
                          </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                
                    
                  </div>
                </div>
              </div>
            </div>  
            
            <hr class="mb-4">
            @endforeach

            @else
            <!-- if cart is empty, then fetch session array -->
            @if(session('buynow-item'))
            @foreach(session('buynow-item') as $product_code => $details)
            <div class="row mb-4">
              <div class="col-md-5 col-lg-3 col-xl-3">
                <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
                    @if(!$details['image'])
                    <img src="../assets/noimage.png" class="img-fluid w-50">
                    @else
                    <img  src="../../storage/{{ $details['image'] }}" class="img-fluid w-50" alt="...">
                    @endif
              
                </div>
              </div>
              
           
              <div class="col-md-7 col-lg-9 col-xl-9">
                <div>
                  
                  <div class="d-flex justify-content-between">
                    <div>
                      <p>{{ $details['description'] }}</p>
                      <p class="mb-3 text-muted text-uppercase small">Category - {{ $details['category'] }}</p>
                      <p class="mb-3 text-muted text-uppercase small">Unit type - {{ $details['unit'] }}</p>
                    </div>
                    <div>
                        <div class="def-number-input number-input safari_only mb-0 w-100">

                            <a class="mr-2">Qty: {{ $details['qty'] }} </a>
                            <p class="mt-2"><span class="text-success">₱{{ $details['amount'] }}</span></p>
                          </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                
                    
                  </div>
                </div>
              </div>
            </div> 
            @endforeach
            @endif
            @endif
           
  
          </div>
        </div>
        <!-- Card -->

        <!-- Card -->
        <div class="card mb-3">
          <div class="card-body">

          <h5 class="mb-4">SSL SECURE PAYMENT</h5>
          <img class="mr-2" width="32px"
              src="{{asset('assets/gcash-logo.png')}}"
              alt="Gcash" style="border-radius: 3px;">
          <img class="mr-2" width="45px"
              src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg"
              alt="Visa">
          <img class="mr-2" width="45px"
              src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg"
              alt="American Express">
          <img class="mr-2" width="45px"
              src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg"
              alt="Mastercard">
          <img class="mr-2" width="45px"
              src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/discover.svg"
              alt="Mastercard">
          <img class="mr-2" width="45px"
              src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/jcb.svg"
              alt="Mastercard">
      
          </div>
      </div>
      <!-- Card -->
  

      </div>
      <!--Grid column-->
  
      <!--Grid column-->
      <div class="col-lg-4 mt-3">
  
        <!-- Card -->
        <div class="card mb-3">
          <div class="card-body">
  

  
            <ul class="list-group list-group-flush" id="ship-info-contr">

                <div class="d-flex justify-content-between align-items-center px-0">
                  <h5>Shipping Address</h5>
                  <a id="btn-edit-shipping-info" style="cursor: pointer;" class="text-primary">Edit</a>
                </div>

                <Label class="label-small">Municipality</Label>
                <input type="text" class="form-control mb-3" id="municipality" readonly>

                <Label class="label-small">Barangay</Label>
                <input type="text" class="form-control mb-3" id="brgy" readonly>

                <Label class="label-small">Subd/Blk/Bldg</Label>
                <input type="text" class="form-control mb-3" placeholder="flr/blk/bldg" id="flr-bldg-blk" readonly>

                <Label class="label-small">Note</Label>
                <textarea class="form-control mb-3" id="note" readonly></textarea>

                <Label class="label-small">Contact No.</Label>
                <input type="text" class="form-control mb-3" id="contact-no" maxlength="11" placeholder="09xxxxxxxxx" readonly>

                <Label class="label-small">Email</Label>
                <input type="text" class="form-control" id="email" readonly><br>

          
              <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-0">
                Subtotal
                <span class="text-success" id="txt-subtotal"></span>
              </li>

              <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                Shipping Fee
                <span class="text-success txt-shipping-fee"></span>
              </li>

              <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                <div>
                  <strong>The total amount of</strong>
                  <strong>
                    <p class="mb-0">(VAT Included)</p>
                  </strong>
                </div>
                <span><strong id="txt-total-due"></strong></span>
              </li>
            </ul>
  
            <a id="btn-place-order" class="btn btn-block waves-effect waves-light btn-blue-primary" style="color: #fff">Place Order</a>
  
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



      @extends('customer.layouts.loading_modal')
      @section('modals')
      @endsection
@endsection