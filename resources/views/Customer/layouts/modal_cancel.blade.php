@yield('cancelModal')
<!--Confirm Cancel Modal-->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cancel Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
           
            <div class="col-md-12 mb-2">
                <p class="confirmation-message"></p>
            </div> 

            <div class="col-md-12 mb-2">
                <label class="label-small">Select a reason</label>
                <select class="form-control" id="remarks">
                    <option value="Change item">Change item</option>
                    <option value="Change payment method">Change payment method</option>
                    <option value="Change of delivery address">Change of delivery address</option>
                    <option value="Decided on another product">Decided on another product</option>
                    <option value="Duplicate order">Duplicate order</option>
                    <option value="Found a better price somewhere else">Found a better price somewhere else</option>
                    <option value="Incorrect contact information">Incorrect contact information</option>
                </select>
            </div> 
        </div>
        
      </div>
      <div class="modal-footer">
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button class="btn btn-sm btn-outline-dark" type="button" id="btn-confirm-cancel">Confirm</button>
        <button class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>