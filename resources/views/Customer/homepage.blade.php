@extends('customer.layouts.main')

@section('content')

<div class="container-fluid center-items">

<div class="container-fluid">

    <div class="topnav">
        <div class="row m-2">
            <div class="product-category">All Products</div>

            <div class="ml-auto">

                <div class="input-group">
                    <input class="form-control border-secondary py-2" type="search" placeholder="Search...">
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
                <div class="card__image-container">
                    @if(!$data->image)
                    <img src="../assets/noimage.png">
                    @else
                    <img style="height:150px" src="../../storage/{{$data->image}}" class="card-img-top" alt="...">
                    @endif
                </div>
                <div class="line ml-2 mr-2 mt-2"></div>
                <div class="card__content">
                    <p class="card__description">
                        {{ $data->description }}
                    </p>
                    <p class="card__unit text-secondary">
                       Unit type: {{ $data->unit }}
                    </p>
                    <div class="card__info">
                        <p class="mt-3 text-success">₱{{ $data->selling_price }}</p>
                        <button class="btn btn-sm card__btn-add">Add to cart</button>
                    </div>
                </div>	
            </div>
    
            @endforeach  
        </section>

  

       
  
  </main>
    




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

@endsection