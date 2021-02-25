<!--go to cart Modal-->
<div class="modal fade" id="cartOrHomepageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
  
          <div class="container">
            <div class="row justify-content-center">
             
                <div class="col-8">
                  <i class="fas fa-check-circle fa-3x" style="color:#5CB85C;"></i>          
                  <p>Your product has been added to cart. <br> Go to cart to proceed with your order!</p>
                </div> 
    
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <a class="btn btn-sm btn-success" href="{{ url('/cart') }}">Go to Cart<a>
          <button class="btn btn-sm btn-outline-success" data-dismiss="modal">Continue Shopping</button>
        </div>
      </div>
    </div>
  </div>