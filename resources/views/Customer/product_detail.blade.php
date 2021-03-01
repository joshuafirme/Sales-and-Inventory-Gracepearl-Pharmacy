@extends('customer.layouts.main')

@section('content')

<style>
  
        
</style>

<div class="container-fluid">

    <!--Section: Block Content-->
<main>

    <!--Grid row-->
    <div class="row">

        <div class="col-lg-8 mt-3 m-auto"><h4>Product Details</h4></div>
  
      <!--Grid column-->
      <div class="col-lg-8 mt-3 m-auto">

        <!-- Card -->
        <div class="card wish-list mb-3 product-detail">
          <div class="card-body card-cart">
  
        <!--Section: Block Content-->
            <section class="mb-5">
                @foreach($product as $data)
                <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
            
                    <div class="mdb-lightbox mt-3">
            
                        <div class="row product-gallery mx-1">
                            
                            <div class="col-12 mb-0">
                            <figure class="view overlay rounded z-depth-1 main-img">
                               @if($data->image)
                                <img src="../../storage/{{ $data->image }}"
                                    class="img-fluid z-depth-1">
                              @else
                              <img src="{{ asset('assets/noimage.png') }}"
                              class="img-fluid z-depth-1">
                              @endif
                            </figure>       
                            </div>
                        
                        </div>
            
                    </div>
            
                </div>
                <div class="col-md-6">
                    
                    <h5 class="mt-3" id="details-description">{{ $data->description }}</h5>
               
                    <p><h4 class="mr-1 text-success">₱<span id="price-buynow">{{ number_format($data->selling_price) }}</span></h4></p>
                  <!--  <button type="button" class="btn btn-sm card__btn-buy mr-1 mb-2" id="btn-buynow" product-code=// $data->product_code }}>Buy now</button> -->
                    @if($data->with_prescription == 'yes')
                      <p class="label small" style="margin-left: 14px; margin-top: 17px; font-style: italic;">Prescription needed</p>
                    @else
                      <button type="button" class="btn btn-sm btn-success mr-1 mb-2" style="border-radius: 50px;" id="btn-add-to-cart" product-code={{ $data->product_code }}>
                      <i class="fas fa-cart-plus"></i> Add to cart</button>
                    @endif
                      
                        <!-- QTY -->
                        <div class="def-number-input number-input safari_only mt-2 w-100">
                            <button class="btn btn-sm"
                              onclick="this.parentNode.querySelector('input[type=number]').stepDown()"
                              class="minus"><i class="fas fa-minus"></i></button>

                            <input class="quantity" min="1" id="qty-buynow" value="1" type="number"
                             style="width: 40px;">

                            <button class="btn btn-sm"
                              onclick="this.parentNode.querySelector('input[type=number]').stepUp()"
                              class="plus"><i class="fas fa-plus"></i></button>
                          </div>
                        <!-- END QTY -->
                        <hr>
                        
                        <div class="table-responsive pt-1">
                            <table class="table table-sm table-borderless mb-0">
                                <tbody>
                                <tr>
                                    <th scope="row">Category</th>
                                    <td>{{ $data->category_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Unit type</th>
                                    <td>{{ $data->unit }}</td>
                                </tr> 
                                <tr>
                                    <th scope="row">Stock</th>
                                    <td>{{ $qty }}</td>
                                </tr>           
                                </tbody>
                            </table>
                            </div>
                            <hr>

                    <p class="pt-1"><b>Highlights</b></p>
                
                    <p id="highlights">{!!  $data->highlights  !!}</p>
    
                </div>
                </div>
            @endforeach
            </section>
  <!--Section: Block Content-->
  
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