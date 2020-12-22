@extends('customer.layouts.main')

@section('content')

<div class="container-fluid center-items">

<div class="container-fluid">

    <div class="topnav">
        <div class="row m-2">
            <div class="product-category">All Products</div>

            <div class="ml-auto">

                <div class="input-group">
                    <input class="form-control border-secondary py-2" type="search" id="search-product" placeholder="Search...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            
        </div>  
    </div>
</div>  

    <main>

        <div class="card-filter-container">
         
            <div class="card-body">

                <div class="card__filter mt-4">
             
                    <h5>Categories</h5>

                    <div class="text-muted small text-uppercase mb-3">
                      <p class="mb-2"><a href="#!" class="card-link-secondary">Milk</a></p>
                      <p class="mb-2"><a href="#!" class="card-link-secondary">Branded</a></p>
                      <p class="mb-2"><a href="#!" class="card-link-secondary">Generic</a></p>
                      <p class="mb-2"><a href="#!" class="card-link-secondary">Vitamins</a></p>
                      <p class="mb-2"><a href="#!" class="card-link-secondary">Galenical</a></p>
                      <p class="mb-2"><a href="#!" class="card-link-secondary">Cosmetic</a></p>
                    </div>
                </div>

                <div class="line"></div>

                
                <label class="mt-3">Price range</label>
                 <input type="range" class="custom-range" max={{ $maxPrice }} step="0.01" id="price_range_from">
                 <input type="range" class="custom-range" max={{ $maxPrice }} step="0.01" id="price_range_to">
                 <p> ₱ <span id="price_from"></span> - ₱ <span id="price_to"></span></p>

             </div>

          </div>

          <section class="cards">
            @foreach ($products as $data)  
            <div class="card-product">
                <a class="card__image-container div-product-details" href="{{ url('productdetails/'. $data->product_code) }}">
                    @if(!$data->image)
                    <img class="img-fluid w-100" src="../assets/noimage.png">
                    @else
                    <img  src="../../storage/{{$data->image}}" class="img-fluid w-100" alt="...">
                    @endif
                </a>
                <div class="line ml-2 mr-2 mt-2"></div>
                <div class="card__content">
                    <p class="card__description">
                        @if(strlen($data->description) > 27)
                        {{ substr_replace($data->description,"...",27) }}
                        @else
                          {{ $data->description }}
                        @endif
                    </p>
                    <p class="card__unit text-secondary">
                       Unit type: {{ $data->unit }}
                    </p>
                    <div class="card__info">
                        <p class="mt-3 text-success">₱{{ number_format($data->selling_price) }}</p>
                        <button class="btn btn-sm card__btn-add ml-auto" product-code={{ $data->product_code }} id="btn-add-to-cart">Add to cart</button><br>
                        
                    </div>
                  
                </div>	
            </div>
    
            @endforeach  
               
        </section>
  </main>
 

    </div>
 

</div>
<div class="row">
    <div class="mt-5 ml-auto" style="margin-right: 292px;">
        {{ $products->links() }}
    </div>
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

  

<script>

    var slider1 = document.getElementById("price_range_from");
    var output1 = document.getElementById("price_from");
    output1.innerHTML = slider1.value; 

    slider1.oninput = function() {
    output1.innerHTML = this.value;
    }

    var slider2 = document.getElementById("price_range_to");
    var output2 = document.getElementById("price_to");
    output2.innerHTML = slider2.value; 

    slider2.oninput = function() {
    output2.innerHTML = this.value;
    }
    
</script>

    @extends('customer.layouts.loading_modal')
    @section('modals')
    @endsection
@endsection