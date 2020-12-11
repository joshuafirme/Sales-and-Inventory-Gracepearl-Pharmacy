<!--add unit Modal-->
@yield('modals')
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Add User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="POST" action="{{action('Maintenance\UserMaintenanceCtr@store')}}">
         <div class="row">
          {{ csrf_field() }}
            <div class="col-md-4">
                <label class="col-form-label">Employee Name</label>
                <input type="text" class="form-control" name="employee_name"  id="employee_name" required>
              </div>

              <div class="col-md-4 mb-2">    
                <label class="col-form-label">Position</label>
                <select class="form-control" name="position" id="position">
                    <option value="Cashier">Cashier</option>
                    <option value="Cashier">Purchaser</option>
                    <option value="Pharmacy Assistant">Pharmacy Assistant</option>
                    <option value="Certified Pharmacy Assistant">Certified Pharmacy Assistant</option>
                    <option value="Administrator">Administrator</option>
                </select>
              </div>

              <div class="col-md-12 mb-2 mt-3 line"></div>

              <div class="col-md-4">
                <label class="col-form-label">User Name</label>
                <input type="text" class="form-control" name="username" id="username" required>
              </div>

              <div class="col-md-4">
                <label class="col-form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
              </div>

              <div class="col-md-4">
                <label class="col-form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password">
              </div>

              <div class="col-md-12 mb-3 mt-3 line"></div>

              <div class="col-md-12">
                <h5>Authorize Modules</h5>
              </div>

              <div class="container-fluid">

                <div class="form-check col-md-4">
                    <input type="checkbox" class="form-check-input" id="chk-position" name="chk-module[]" value="Product">
                    <label class="form-check-label">Product</label>
                 </div>

                 <div class="form-check col-md-4">
                    <input type="checkbox" class="form-check-input" id="chk-sales" name="chk-module[]" value="Sales">
                    <label class="form-check-label">Sales</label>
                 </div>

                 <div class="form-check col-md-4">
                    <input type="checkbox" class="form-check-input" id="chk-inventory" name="chk-module[]" value="Inventory">
                    <label class="form-check-label">Inventory</label>
                 </div>

                 <div class="form-check col-md-4">
                    <input type="checkbox" class="form-check-input" id="chk-reports" name="chk-module[]" value="Reports">
                    <label class="form-check-label">Reports</label>
                 </div>

                 <div class="form-check col-md-4">
                    <input type="checkbox" class="form-check-input" id="chk-maintenance" name="chk-module[]" value="Maintenance">
                    <label class="form-check-label">Maintenance</label>
                 </div>

                 <div class="form-check col-md-4">
                    <input type="checkbox" class="form-check-input" id="chk-user" name="chk-module[]" value="User">
                    <label class="form-check-label">User</label>
                 </div>

              </div>
              

         </div>
         
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sm btn-primary" id="btn-add-user">Save</button>
      </form>
      </div>
    </form>
    </div>
  </div>
</div>


<!--edit Modal-->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Update User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="row">
          {{ csrf_field() }}

          <input type="hidden" name="empID_hidden" id="edit_empID_hidden">
             
          <div class="col-md-4">
            <label class="col-form-label">Employee ID</label>
            <input type="text" class="form-control" name="empID" id="edit_empID" readonly>
          </div>

            <div class="col-md-4">
                <label class="col-form-label">Employee Name</label>
                <input type="text" class="form-control" name="employee_name"  id="edit_employee_name" required>
              </div>

              <div class="col-md-4 mb-2">    
                <label class="col-form-label">Position</label>
                <select class="form-control edit_position" name="edit_position">
                  <option id="edit_position" selected></option>
                  <option value="Cashier">Cashier</option>
                  <option value="Purchaser">Purchaser</option>
                  <option value="Certified Pharmacy Assistant">Certified Pharmacy Assistant</option>
                  <option value="Pharmacy Assistant">Pharmacy Assistant</option>
                  
                </select>
              </div>

              <div class="col-md-12 mb-2 mt-3 line"></div>

              <div class="col-md-4">
                <label class="col-form-label">User Name</label>
                <input type="text" class="form-control" name="username" id="edit_username" required>
              </div>

              <div class="col-md-4">
                <label class="col-form-label">Password</label>
                <input type="password" class="form-control" name="password" id="edit_password" required>
              </div>

              <div class="col-md-4">
                <label class="col-form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="edit_confirm_password">
              </div>

              <div class="col-md-12 mb-3 mt-3 line"></div>

              <div class="col-md-12">
                <h5>Authorize Modules</h5>
              </div>

              <div class="container-fluid">

                <div class="form-check col-md-4">
                    <input type="checkbox" class="form-check-input" id="edit_chk-Product" name="chk-module[]" value="Product">
                    <label class="form-check-label">Product</label>
                 </div>

                 <div class="form-check col-md-4">
                    <input type="checkbox" class="form-check-input" id="edit_chk-Sales" name="chk-module[]" value="Sales">
                    <label class="form-check-label">Sales</label>
                 </div>

                 <div class="form-check col-md-4">
                    <input type="checkbox" class="form-check-input" id="edit_chk-Inventory" name="chk-module[]" value="Inventory">
                    <label class="form-check-label">Inventory</label>
                 </div>

                 <div class="form-check col-md-4">
                    <input type="checkbox" class="form-check-input" id="edit_chk-Reports" name="chk-module[]" value="Reports">
                    <label class="form-check-label">Reports</label>
                 </div>

                 <div class="form-check col-md-4">
                    <input type="checkbox" class="form-check-input" id="edit_chk-Maintenance" name="chk-module[]" value="Maintenance">
                    <label class="form-check-label">Maintenance</label>
                 </div>

                 <div class="form-check col-md-4">
                    <input type="checkbox" class="form-check-input" id="edit_chk-User" name="chk-module[]" value="User">
                    <label class="form-check-label">User</label>
                 </div>

              </div>
              

         </div>
         
      </div>
      <div class="modal-footer">

        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">User information is updated successfully</label>    
        </div> 
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">

        <button class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
        <button class="btn btn-sm btn-success" id="btn-update-user">Update</button>

      </div>
    </form>
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
        <p class="delete-user-message"></p>
      </div>
      <div class="modal-footer">
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button class="btn btn-sm btn-outline-dark" type="button" name="ok_button" id="btn-delete-user">Yes</button>
        <button class="btn btn-sm btn-danger btn-cancel" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>