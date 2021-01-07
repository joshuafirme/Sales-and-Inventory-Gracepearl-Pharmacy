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
  

  
            <ul class="list-group list-group-flush">
                <Label>Shipping Address</Label>
                <select class="form-control mb-3">      
                  <option value="Nasugbu">Nasugbu</option> 
                  <option value="Tuy">Tuy</option> 
                </select>
                <input type="text" class="form-control mb-3" placeholder="Street/Subd/Brgy.">
                <textarea class="form-control mb-3" placeholder="note"></textarea>
                <Label>Contact No.</Label>
                <input type="text" class="form-control mb-3" id="contact-no" maxlength="11" placeholder="09xxxxxxxxx">
                <Label>Email</Label>
                <input type="text" class="form-control" value={{ session()->get('email') }}><br>

              <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                Subtotal
                <span id="checkout-subtotal"></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                Shipping Fee
                <span class="text-success">Free</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                <div>
                  <strong>The total amount of</strong>
                  <strong>
                    <p class="mb-0">(VAT Included)</p>
                  </strong>
                </div>
                <span><strong>₱53.98</strong></span>
              </li>
            </ul>
  
            <a href="{{ url('/payment') }}"
            id="btn-place-order" class="btn btn-block waves-effect waves-light btn-blue-primary" style="color: #fff">Place Order</a>
  
          </div>
        </div>
        <!-- Card -->
        
        <!-- Card -->
        <div class="card mb-3">
            <div class="card-body">

            <h5 class="mb-4">We accept</h5>
            <img class="mr-2" width="33px"
                src="{{asset('assets/gcash-logo.png')}}"
                alt="Gcash">
            <img class="mr-2" width="45px"
                src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg"
                alt="Visa">
            <img class="mr-2" width="45px"
                src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg"
                alt="American Express">
            <img class="mr-2" width="45px"
                src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg"
                alt="Mastercard">
        
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