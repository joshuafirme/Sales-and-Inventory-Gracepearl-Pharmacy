@yield('voidModal')
<!-- void modal -->
<div class="modal fade" id="voidModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Void</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="container-fluid">
          <div class="row">

              <input type="hidden" id="product-code-hidden">

              <label class="col-form-label">Username</label>
              <input type="text" class="form-control mb-2" id="admin-username">
            
              <label class="col-form-label">Password</label>
              <input type="password" class="form-control" id="admin-password">
            
          </div>
        </div>  

      </div>
      <div class="modal-footer">
          <div class="update-success-validation mr-auto ml-3" style="display: none">
            <label class="label text-success">Product is successfully voided</label>    
          </div> 
          <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">

          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button class="btn btn-sm btn-danger" id="btn-void">Void</button>
      </div>
    </div>
  </div>
</div>


<!-- process modal -->
<div class="modal fade" id="processModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Process</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="container-fluid">
          <div class="row">
            {{ csrf_field() }}

              <label class="col-form-label">Sales Invoice #</label>
              <input type="number" class="form-control" name="sales-invoice" id="sales-invoice-no" required>

              <small style="display: none" class="form-text text-danger">Please fillup this field to continue</small>
        

              <input style="display: none"  class="form-control mb-2 mt-4" name="senior-name" id="senior-name"  placeholder="Senior citizen name">
            
          </div>
        </div>  

      </div>
      <div class="modal-footer">

        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">Proccess completed</label>    
        </div> 
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
          <button type="submit" class="btn btn-sm btn-success" id="btn-confirm-inv">Generate Reciept</button>

      </div>
    </form>
    </div>
  </div>
</div>