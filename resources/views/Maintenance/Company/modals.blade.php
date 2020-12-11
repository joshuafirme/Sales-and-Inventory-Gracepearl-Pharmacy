
@yield('modals')

<!--add category Modal-->
<div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Company</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <form action="{{ action('Maintenance\CompanyMaintenanceCtr@store') }}" method="POST">
        {{ csrf_field() }}
          <div class="form-group">
            <label class="col-form-label">Company Name</label>
            <input type="text" class="form-control" name="company_name" id="company_name" required>
          </div>

          <div class="form-group">
            <label class="col-form-label">Markup</label>
            <input type="number" step="0.01" min="0.01" max="1" class="form-control" name="markup" id="markup" required>
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
<!--edit markup Modal-->
<div class="modal fade" id="editCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <label class="col-form-label">Company Name</label>
              <input type="text" class="form-control" name="edit_company_name" id="edit_company_name" required>
            </div>

            <div class="form-group">
                <label class="col-form-label">Markup</label>
                <input type="number" step="0.01" min="0.01" max="1.0" class="form-control" name="edit_markup" id="edit_markup" required>
              </div>
    
        </div>
        <div class="modal-footer">
                <div class="update-success-validation mr-auto ml-3" style="display: none">
                    <label class="label text-success">Updated successfully</label>    
                </div> 
                <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-success" id="btn-update-company">Update</button>
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
        <p class="delete-company-message"></p>
      </div>
      <div class="modal-footer">
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button class="btn btn-sm btn-outline-dark" type="button" name="ok_button" id="ok_button">Yes</button>
        <button class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>