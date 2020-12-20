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

                <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
            
                    <div class="mdb-lightbox">
            
                        <div class="row product-gallery mx-1">
                
                            <div class="col-12 mb-0">
                            <figure class="view overlay rounded z-depth-1 main-img">
                                <a href="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Vertical/15a.jpg"
                                data-size="710x823">
                                <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Vertical/15a.jpg"
                                    class="img-fluid z-depth-1">
                                </a>
                            </figure>       
                            </div>
                        
                        </div>
            
                    </div>
            
                </div>
                <div class="col-md-6">
            
                    <h5>Fantasy T-shirt</h5>
                    <p class="mb-2 text-muted text-uppercase small">Shirts</p>
               
                    <p><span class="mr-1"><strong>$12.99</strong></span></p>
                    <p class="pt-1">Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam, sapiente illo. Sit
                    error voluptas repellat rerum quidem, soluta enim perferendis voluptates laboriosam. Distinctio,
                    officia quis dolore quos sapiente tempore alias.</p>
                    <div class="table-responsive">
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                        <tr>
                            <th class="pl-0 w-25" scope="row"><strong>Unit</strong></th>
                            <td>Shirt 5407X</td>
                        </tr>
                        <tr>
                            <th class="pl-0 w-25" scope="row"><strong>Category</strong></th>
                            <td>Black</td>
                        </tr>
                    
                        </tbody>
                    </table>
                    </div>
                    <hr>
                
                    <button type="button" class="btn btn-sm btn-primary btn-md mr-1 mb-2">Buy now</button>
                    <button type="button" class="btn btn-sm btn-success btn-md mr-1 mb-2"><i
                        class="fas fa-shopping-cart"></i> Add to cart</button>
                </div>
                </div>
            
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