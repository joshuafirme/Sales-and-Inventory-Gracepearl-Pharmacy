<!-- Edit Modal -->
@yield('editAccountmodal')
<div class="modal fade" id="editAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

            <div class="row">
            
                <div class="col-md-12">
                    <h5>Basic Information</h5>
                </div>
                @foreach($account as $data)
                <div class="col-md-4">
                    <label class="label-small" >Full Name</label>
                    <input type="text" class="form-control" value="{{ $data->fullname }}" id="fullname">
                </div>
    
                <div class="col-md-4">
                    <label class="label-small">Email Address</label>
                    <input type="email" class="form-control" value="{{ $data->email }}" id="email">
                </div>
    
                <div class="col-md-4">
                    <label class="label-small">Phone Number</label>
                    <input type="number" class="form-control" value="{{ $data->phone_no }}" id="phone_no">
                </div> 
    
                <div class="col-md-12 mb-2 mt-2">
                    <hr>
                </div>

                @endforeach
    
                <div class="col-md-12 mb-2">
                    <h5>Shipping Address</h5>
                </div>
    
                <div class="col-md-6 mb-3">
                    <label class="label-small">House/Unit/Flr #, Bldg Name, Blk or Lot #</label>
                    <input type="text" class="form-control">
                </div> 
    
                <div class="col-md-6">
                    <label class="label-small">Municipality</label>
                    <select class="form-control" name="municipality">
                      <option>Nasugbu</option>
                      <option>Tuy</option>
                    </select>
                </div> 
    
                <div class="col-md-6">
                    <label class="label-small">Barangay</label>
                    <input type="text" class="form-control">
                </div> 
    
                <div class="col-md-6">
                    <label class="label-small">Notes</label>
                    <input type="text" class="form-control">
                </div> 

            </div>

      </div>
      <div class="modal-footer">
        
        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">Your account was successfully updated</label>    
        </div> 
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
              <button class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
              <button class="btn btn-sm btn-success" id="btn-update-account">Save</button> 
      </div>

    </div>
  </div>
</div>