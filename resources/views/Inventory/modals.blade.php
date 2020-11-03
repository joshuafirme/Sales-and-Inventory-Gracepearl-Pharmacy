
@yield('modals')
<div class="modal fade" id="stockAdjustmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Stock Adjustment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
        {{ csrf_field() }}
        
        <div class="col-md-8">
          <label class="col-form-label">Description</label>
          <input type="text" class="form-control" name="description" id="description" required>
        </div>

      </div>
    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
        <button style="color: #fff" type="submit" class="btn btn-sm btn-warning">Adjust</button>
      </div>
    </div>
  </div>
</div>

