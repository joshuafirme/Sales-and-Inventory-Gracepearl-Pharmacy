
@yield('verifyCustomerModal')
<div class="modal fade" id="verifyCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verify Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">

          <input type="hidden" id="cust-id-hidden">

            <div class="col-md-4">
                <label class="label-small text-muted" >ID Type</label>
                <p id="id-type"></p>
            </div>
            
            <div class="col-md-4">
                <label class="label-small text-muted" >ID Number</label>
                <p id="id-number"></p>
            </div>

            <div class="col-md-4">
              <label class="label-small text-muted" >Account Status</label>
              <p id="acc-status"></p>
          </div>

            <div class="col-md-12 m-auto">
                <img class="responsive" id="img-valid-id" 
                style="border-style: dashed; border-color: #9E9E9E; background: #fff;">
              </div>

        </div>
    
  
      </div>
      <div class="modal-footer">
        <button id="btn-decline" class="btn btn-sm btn-danger">Decline</button>
        <button id="btn-approve" class="btn btn-sm btn-success">Approve</button>
      </div>
    </form>
    </div>
  </div>
</div>

