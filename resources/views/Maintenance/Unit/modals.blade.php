<!--add unit Modal-->
@yield('modals')
<div class="modal fade" id="addUnitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <form action="{{ action('Maintenance\UnitMaintenanceCtr@store') }}" method="POST">
        {{ csrf_field() }}
          <div class="form-group">
            <label class="col-form-label">Unit Name</label>
            <input type="text" class="form-control" name="unit" id="unit" required>
          </div>
  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sm btn-primary">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!--edit unit Modal-->
<div class="modal fade" id="editUnitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Unit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
    
          {{ csrf_field() }}

          <input type="hidden" id="edit_id">
          
            <div class="form-group">
              <label class="col-form-label">Unit Name</label>
              <input type="text" class="form-control" name="edit_unit" id="edit_unit" required>
            </div>
    
        </div>
        <div class="modal-footer">
                <div class="update-success-validation mr-auto ml-3" style="display: none">
                    <label class="label text-success">Unit was successfully updated</label>    
                </div> 
                <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-success" id="btn-update-unit">Update</button>
        </div>
     
      </div>
    </div>
  </div>

<!--Confirm Modal-->
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
        <p class="delete-unit-message"></p>
      </div>
      <div class="modal-footer">
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button class="btn btn-sm btn-outline-dark" type="button" name="ok_button" id="ok_button">Yes</button>
        <button class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>