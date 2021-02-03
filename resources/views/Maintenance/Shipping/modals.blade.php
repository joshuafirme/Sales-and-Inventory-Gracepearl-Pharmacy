
@yield('modals')

<!--add category Modal-->
<div class="modal fade" id="addShipModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Shipping Address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ action('Maintenance\ShippingAddressCtr@store') }}" method="POST">

            <div class="row">
              {{ csrf_field() }}

            <div class="col-md-12 mb-3">
                <label class="col-form-label">Municipality</label>
                <select class="form-control" name="municipality" id="municipality">
                
                    @foreach($municipality as $key => $data)
                     <option value="{{ $key }}">{{ $key }}</option>
                    @endforeach

                </select>
              </div>
    
              <div class="col-md-12">
                <label class="col-form-label">Barangay</label>
                <select class="form-control" name="brgy" id="brgy">

                </select>
              </div>
    
              <div class="col-md-12">
                <label class="col-form-label">Shipping Fee</label>
                <input type="number" step="1" min="0" class="form-control" value="0" name="shipping-fee" id="shipping-fee" required>
              </div>

        </div>
  
      </div>
      <div class="modal-footer">
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sm btn-primary">Save</button>
      </form>
      </div>
    </div>
  </div>
</div>


<!--edit Modal-->
<div class="modal fade" id="editShippingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Shipping Address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ action('Maintenance\ShippingAddressCtr@update') }}" method="POST">

          {{ csrf_field() }}
            <div class="row">

            <input type="hidden" name="id_hidden" id="id_hidden">

            <div class="col-md-12 mb-3">
                <label class="col-form-label">Municipality</label>
                <select class="form-control" name="municipality" id="edit_municipality" required>
                
                    @foreach($municipality as $key => $data)
                     <option value="{{ $key }}">{{ $key }}</option>
                    @endforeach

                </select>
              </div>
    
              <div class="col-md-12">
                <label class="col-form-label">Barangay</label>
                <select class="form-control" name="brgy" id="edit_brgy" required>

                </select>
              </div>
    
              <div class="col-md-12">
                <label class="col-form-label">Shipping Fee</label>
                <input type="number" step="1" min="0" class="form-control" value="0" name="shipping-fee" id="edit_fee" required>
              </div>

        </div>
  
      </div>
      <div class="modal-footer">
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sm btn-primary">Update</button>
      </form>
      </div>
    </div>
  </div>
</div>

  <!--Confirm Delete Modal-->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="delete-message"></p>
        <div class="delete-success" style="display: none;">
          <span style="margin-left:180px;" class="text-success">Deleted Successfully!</span>
          </div>
        <div class="modal-footer">
          <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button class="btn btn-sm btn-outline-dark" id="confirm-del-ship">Yes</button>
        <button class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
</div>