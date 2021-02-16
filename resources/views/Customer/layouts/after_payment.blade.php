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

        <div class="row">
        
          <div class="col-md-4 col-lg-4 mt-4 m-auto">
  
            <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <p class="text-center m-0">Order Recieved</p>
                                <p class="text-center m-0">Please have this amount ready on delivery</p>
                                <h4 class="text-success text-center">₱{{ session()->get('checkout-total') + session()->get('after-payment-shipping-fee') }}</h4>
                            </div>
                     
                                <a class="m-auto btn btn-sm btn-blue-primary" style="text-align: center" href="{{ url('/homepage') }}">Continue Shopping</a>
                       

                     
                        </div>
                    </div>
            </div>
                        

            </div>
        </div>
                


        </div>
    </div>

        <!-- /.row (main row) -->
        
</div><!-- /.container-fluid -->
  
    <!-- /.content -->

    @extends('customer.layouts.loading_modal')
    @section('modals')
    @endsection

@endsection



