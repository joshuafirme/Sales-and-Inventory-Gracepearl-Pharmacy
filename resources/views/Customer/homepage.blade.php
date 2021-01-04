@extends('customer.layouts.main')

@section('content')

<div class="container-fluid center-items">

<div class="container-fluid">

    <div class="topnav">
        <div class="row m-2">
            <div class="product-category">All Products</div>

            <div class="ml-auto">

                <div class="input-group">
                    <input class="form-control border-secondary py-2" type="search" id="search-product" placeholder="Search Product...">
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

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" id="chk-pcategory" name="chk-category[]" value="Milk">
                            <label class="form-check-label">Milk</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" id="chk-category" name="chk-category[]" value="Branded">
                            <label class="form-check-label">Branded</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" id="chk-category" name="chk-category[]" value="Generic">
                            <label class="form-check-label">Generic</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" id="chk-category" name="chk-category[]" value="Vitamins">
                            <label class="form-check-label">Vitamins</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" id="chk-category" name="chk-category[]" value="Galenical">
                            <label class="form-check-label">Galenical</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" id="chk-category" name="chk-category[]" value="Cosmetic">
                            <label class="form-check-label">Cosmetic</label>
                         </div>
                
                    </div>
                </div>

                <div class="line"></div>

                
                <label class="mt-3">Price range</label>
                 <input type="range" class="custom-range" max={{ $maxPrice }} step="0.01" id="price_range_from">
                 <input type="range" class="custom-range" max={{ $maxPrice }} step="0.01" id="price_range_to">
                 <p> ₱ <span id="price_from"></span> - ₱ <span id="price_to"></span></p>

             </div>

          </div>

          <section class="cards" id="homepage-cards">
           <!-- load HTML and data here via ajax -->    
           
          </section>
          <div class="card-product">

            <button class="btn btn-sm btn-success m-auto" id="btn-viewmore"
             style="border-radius: 20px; width:110px;">View more</button>
        
          </div>
  </main>
  
 

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