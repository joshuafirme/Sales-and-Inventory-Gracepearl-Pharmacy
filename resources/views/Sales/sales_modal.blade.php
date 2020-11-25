@yield('voidModal')
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

        <form action="" method="POST">
        <div class="container-fluid">
          <div class="row">
            {{ csrf_field() }}

              <label class="col-form-label">Username</label>
              <input type="text" class="form-control mb-2" n required>
            
              <label class="col-form-label">Password</label>
              <input type="text" class="form-control"  required>
            
          </div>
        </div>  

      </div>
      <div class="modal-footer">

              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-sm btn-danger" id="btn-void">Void</button>
      </div>
    </form>
    </div>
  </div>
</div>