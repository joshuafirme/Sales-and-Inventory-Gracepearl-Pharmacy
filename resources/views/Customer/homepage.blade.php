@extends('customer.layouts.main')

@section('content')

<div class="container-fluid">

    <div class="topnav">
        <div class="row m-2">
            <div class="product-category">Products</div>

            <div class="ml-auto">

                <div class="input-group">
                    <input class="form-control" type="search" id="search-product" placeholder="Search Product...">
                    <div class="input-group-append">
                        <button class="btn" type="button">
                            <i class="fa fa-search" style="color:#5CB85C;"></i>
                        </button>
                    </div>
                </div>
            
        </div>  
    </div>
</div>  

    <main>

        <div class="card-filter-container">
         
            <div class="card-body">

                <div class="card__filter mt-2">
             
                    <h5>Categories</h5>

                    <div class="text-muted small text-uppercase mb-3">

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input"name="chk-category[]" value="Milk">
                            <label class="form-check-label">Milk</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" name="chk-category[]" value="Branded">
                            <label class="form-check-label">Branded</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" name="chk-category[]" value="Generic">
                            <label class="form-check-label">Generic</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" name="chk-category[]" value="Vitamins">
                            <label class="form-check-label">Vitamins</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" name="chk-category[]" value="Galenical">
                            <label class="form-check-label">Galenical</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" name="chk-category[]" value="Cosmetic">
                            <label class="form-check-label">Cosmetic</label>
                         </div>
                
                    </div>
                </div>

                <div class="line mt-4 mb-3"></div>

                <div class="card__filter mt-4">
             
                    <h5>Unit type</h5>

                    <div class="text-muted small text-uppercase mb-3">

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input"  name="chk-unit[]" value="Milk">
                            <label class="form-check-label">Pieces</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" name="chk-unit[]" value="Branded">
                            <label class="form-check-label">Sheet</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" iname="chk-unit[]" value="Generic">
                            <label class="form-check-label">Box</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" name="chk-unit[]" value="Vitamins">
                            <label class="form-check-label">Capsule</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" name="chk-unit[]" value="Galenical">
                            <label class="form-check-label">Bottle</label>
                         </div>

                         <div class="form-check col-md-12 mt-2">
                            <input type="checkbox" class="form-check-input" name="chk-unit[]" value="Cosmetic">
                            <label class="form-check-label">Syrup</label>
                         </div>
                
                    </div>
                </div>

                <div class="line mt-4 mb-3"></div>

                
                <label class="text-muted">Price Range</label>
                <div class="d-flex align-items-center mt-0 pb-1"> 
                    <input type="number" class="form-control mb-0" placeholder="min" id="input-minprice" value={{ $minPrice }} style="font-size: 13px;">          
                    <p class="px-2 mb-0 text-muted"> - </p>
                    <input type="number" class="form-control mb-0" placeholder="max" id="input-maxprice" value={{ $maxPrice }} style="font-size: 13px;"> 
                </div>

             </div>

          </div>

          <section class="cards" id="homepage-cards">
           <!-- load HTML and data here via ajax -->    
       
           

          </section>
       
  </main>
  
 

    </div>
    @include('customer.layouts.cart-continue')
    @extends('customer.layouts.loading_modal')
    @section('modals')
    @endsection
@endsection