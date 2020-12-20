@extends('customer.layouts.main')

@section('content')

        @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
    
                <li>{{$error}}</li>
                    
                @endforeach
            </ul>
        </div>
        @endif

        <!-- main -->
        <main class="m-auto">

            <div class="row">

                <div class="col-lg-8 mt-3">
            <!-- card -->
                  <div class="card">
                    <div class="card-title m-4"><h4>Select Payment Method</h4></div>
                          <div class="card-body">
      
                              <form method="GET" action="{{ action('Customer\PaymentCtr@gcashPayment') }}">
                                  {{ csrf_field() }}
                              <div class="card-payment-method">
                                  <button type="submit" class="btn btn-payment">
                                      <img class="mt-2" src="{{asset('assets/gcash-logo.png')}}" alt=""><br>
                                      <p class="mt-1 mb-0">Gcash e-Wallet</p>
                                      <p class="text-secondary">GCash account required</p>
                                  </button>
                              </form>
      
                                  <a data-toggle="modal" data-target="#stripeModal" class="btn btn-payment" id="btn-stripe">
                                      <img src="{{asset('assets/card_payment_50px.png')}}" alt=""><br>
                                      <p class="mt-1 mb-0">Credit/Debit Card</p>
                                  </a>
      
                                  <a href="{{ url('/payment/afterpayment') }}" class="btn btn-payment" id="btn-cash-on-delivery">
                                      <img src="{{asset('assets/money_50px.png')}}" alt=""><br>
                                      <p class="mt-1 mb-0">Cash On Delivery</p>
                                  </a>
                                  
                                </div>
                              </div>
                          </div>
                 <!-- card -->
                   </div>

                <div class="col-lg-4 mt-3">
                  <!-- card -->
                  <div class="card">
                          <div class="card-body">
                            <h4>Order Summary</h4>
                            <p>Total Amount</p>
                            <h5 class="text-success">₱{{ number_format(session()->get('checkout-total')) }}</h5>
      
                              </div>
                          </div>
                  <!-- card -->     
                </div>
      
                  </div>
        </main>
        <!-- main -->
      

        
                
            
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
  
    <!-- /.content -->


@endsection



