@extends('customer.layouts.main')

@section('content')

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
               
                    <p><h4 class="mr-1 text-success">₱{{ number_format($data->selling_price) }}</h4></p>
                    <button type="button" class="btn btn-sm card__btn-buy mr-1 mb-2">Buy now</button>
                    <button type="button" class="btn btn-sm card__btn-buy-now mr-1 mb-2" id="btn-add-to-cart" product-code={{ $data->product_code }}>
                        <i class="fas fa-cart-plus"></i> Add to cart</button>
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
                                    <td>{{ $data->qty }}</td>
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