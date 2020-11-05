
@yield('modals')

<!--edit markup Modal-->
<div class="modal fade" id="editMarkupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Markup</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
    
          {{ csrf_field() }}

          <input type="hidden" id="id">

            <div class="form-group">
              <label class="col-form-label">Supplier Name</label>
              <input type="text" class="form-control" name="edit_supplier_name" id="edit_supplier_name" readonly>
            </div>

            <div class="form-group">
                <label class="col-form-label">Markup</label>
                <input type="number" step="0.1" class="form-control" name="edit_markup" id="edit_markup" required>
              </div>
    
        </div>
        <div class="modal-footer">
                <div class="update-success-validation mr-auto ml-3" style="display: none">
                    <label class="label text-success">Markup was successfully updated</label>    
                </div> 
                <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-success" id="btn-update-markup">Update</button>
        </div>
     
      </div>
    </div>
  </div>