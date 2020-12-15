@extends('customer.layouts.main')

@section('content')

<div class="container-fluid">

    <!--Section: Block Content-->
<main class="m-auto">

    <!--Grid row-->
    <div class="row">
  
      <!--Grid column-->
      <div class="col-lg-8">

       

  
  
        <!-- Card -->
        <div class="card wish-list mb-3">
          <div class="card-body card-cart">
  
            <h5 class="mb-4">Cart (<span class="count-cart"></span> items)</h5>
  
            @foreach($cart as $data)
            <div class="row mb-4">
              <div class="col-md-5 col-lg-3 col-xl-3">
                <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
                    @if(!$data->image)
                    <img style="height:200px" src="../assets/noimage.png" class="img-fluid w-100">
                    @else
                    <img  src="../../storage/{{$data->image}}" class="card-img-top" alt="...">
                    @endif
              
                </div>
              </div>
              
           
              <div class="col-md-7 col-lg-9 col-xl-9">
                <div>
                  
                  <div class="d-flex justify-content-between">
                    <div>
                      <h5>{{ $data->description }}</h5>
                      <p class="mb-3 text-muted text-uppercase small">Category - {{ $data->category_name }}</p>
                      <p class="mb-3 text-muted text-uppercase small">Unit type - {{ $data->unit }}</p>
                    </div>
                    <div>
                        <div class="def-number-input number-input safari_only mb-0 w-100">
                            <button class="btn btn-sm" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"
                              class="minus"><i class="fas fa-minus"></i></button>

                            <input class="quantity" min="0" id="item-qty" name="quantity"  value={{ $data->qty }} product-code={{ $data->product_code }} type="number" style="width: 40px">

                            <button class="btn btn-sm" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"
                              class="plus"><i class="fas fa-plus"></i></button>
                          </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <a href='#' id="btn-remove-from-cart" product-code={{ $data->product_code }}  type="button"
                        data-toggle="modal" data-target="#loading-Modal" class="card-link-secondary small text-uppercase mr-3">
                        <i class="fas fa-trash-alt mr-1"></i> Remove item </a>
                    </div>
                    <p class="mb-0 mr-5"><span class="text-success">₱{{ $data->amount }}</span></p>
                  </div>
                </div>
              </div>
            </div>      
            <hr class="mb-4">
            @endforeach

            <p class="text-primary mb-0"><i class="fas fa-info-circle mr-1"></i> Do not delay the purchase, adding
              items to your cart does not mean booking them.</p>
  
          </div>
        </div>
        <!-- Card -->
  
        <!-- Card -->
        <div class="card mb-3">
          <div class="card-body">
  
            <h5 class="mb-4">Expected shipping delivery</h5>
  
            <p class="mb-0"> Thu., 12.03. - Mon., 16.03.</p>
          </div>
        </div>
        <!-- Card -->
  
        <!-- Card -->
        <div class="card mb-3">
          <div class="card-body">
  
            <h5 class="mb-4">We accept</h5>
  
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
  
      <!--Grid column-->
      <div class="col-lg-4">
  
        <!-- Card -->
        <div class="card mb-3">
          <div class="card-body">
  

  
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                Total amount
                <span class="cart-total-amount"></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                Shipping Fee
                <span class="text-success">Free</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                <div>
                  <strong>The total amount of</strong>
                  <strong>
                    <p class="mb-0">(including VAT)</p>
                  </strong>
                </div>
                <span><strong>₱53.98</strong></span>
              </li>
            </ul>
  
            <button type="button" class="btn btn-success btn-block waves-effect waves-light">Proceed to Checkout</button>
  
          </div>
        </div>
        <!-- Card -->
  
        <!-- Card -->
        <div class="card mb-3">
          <div class="card-body">
  
            <a class="dark-grey-text d-flex justify-content-between" data-toggle="collapse" href="#collapseExample1"
              aria-expanded="false" aria-controls="collapseExample1">
              Add a discount code (optional)
              <span><i class="fas fa-chevron-down pt-1"></i></span>
            </a>
  
            <div class="collapse" id="collapseExample1">
              <div class="mt-3">
                <div class="md-form md-outline mb-0">
                  <input type="text" id="discount-code1" class="form-control font-weight-light"
                    placeholder="Enter discount code">
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
       <div class="modal fade" id="loading-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content  bg-transparent border-0">
      
      
              <div class="d-flex justify-content-center">
                <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
              </div>
  
          </div>
        </div>
      </div>

@endsection