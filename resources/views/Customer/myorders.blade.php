@extends('customer.layouts.main')

@section('content')

<div class="container-fluid">

    <!--Section: Block Content-->
<main class="m-auto">

    <!--Grid row-->
    <div class="row mt-2">
  
    <div class="col-lg-8 m-auto"><h4>My Orders</h4></div>
      <!--Grid column-->
      <div class="col-lg-8 m-auto">

        <!-- Card -->
        @if(count($order_no) > 0)
        @foreach($order_no as $o)
        <div class="card wish-list mb-3 mt-1">
          <div class="card-body card-cart">
            <?php
            
            $orders = DB::table('tblonline_order')
            ->select('tblonline_order.*',DB::raw('CONCAT(tblonline_order._prefix, tblonline_order.order_no) AS order_no, unit, category_name, image, description'))
            ->leftJoin('tblproduct',  DB::raw('CONCAT(tblproduct._prefix, tblproduct.id)'), '=', 'tblonline_order.product_code')
            ->leftJoin('tblcategory', 'tblcategory.id', '=', 'tblproduct.categoryID')
            ->leftJoin('tblunit', 'tblunit.id', '=', 'tblproduct.unitID')
            ->where('order_no', $o->order_no)
            ->get();   
            ?>  
            <div class="row">
                <h5 class="mb-0 ml-3">Order <span>{{date('ymd') . str_pad($o->order_no, 6, '0', STR_PAD_LEFT) }}</span></h5>
                <?php 
                $order_status = DB::table('tblonline_order')
                ->where('order_no', $o->order_no)
                ->value('status');
                 ?>
                @if($order_status == 'Payment pending')
                <button class="btn btn-sm btn-success ml-auto mr-3" order-number={{ $o->order_no }}>Pay now ></button>
                @endif

                <?php 
                   $placed_on = DB::table('tblonline_order')
                    ->where('order_no', $o->order_no)
                    ->orderBy('order_no', 'desc')
                    ->first();
                  ?>
                <p class="col-12 m-0">Placed on {{$placed_on->created_at}}<span></span></p>
          
            </div>
           
            <div class="line mb-4"></div>
    
            <?php   foreach($orders as $data){ ?>

      
            
            <div class="row mb-4">
              <div class="col-md-5 col-lg-3 col-xl-3">
            
                    @if(!$data->image)
                    <img src="../assets/noimage.png" style="width: 100px">
                    @else
                    <img  src="../../storage/{{$data->image}}" alt="..." style="width: 100px">
                    @endif
                
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
    
                        <a class="mr-2">{{ $data->status }} </a><br>
                        <a class="mr-2">Qty: {{ $data->qty }} </a>
                        <p class="mt-2"><span class="text-success">₱{{ $data->amount }}</span></p>       
                          
                    </div>
                  </div>
                </div>

              </div>
              
            </div>      
           
            <?php }?>
  
          </div>
          
        </div>
        <!-- Card -->
        @endforeach
        @else
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-exclamation-triangle"></i> </h5>You have no order yet
        </div> 
        @endif 

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