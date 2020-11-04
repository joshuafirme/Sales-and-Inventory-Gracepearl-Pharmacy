
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

        <input type="hidden" id="product_code_hidden" required>

        <div class="col-md-8 mb-2">
          <label class="col-form-label">Product Code</label>
          <input type="text" class="form-control" name="product_code" id="product_code" readonly>
        </div>
        
        <div class="col-md-8 mb-2">
          <label class="col-form-label">Description</label>
          <input type="text" class="form-control" name="description" id="description" readonly>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Stock on hand</label>
          <input type="text" class="form-control" name="qty" id="qty" readonly>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Qty to adjust</label>
          <input type="number" class="form-control" name="qty_to_adjust" id="qty_to_adjust">
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Remarks</label>
          <input type="text" class="form-control" name="remarks" id="remarks">
        </div>

        <div class="col-md-4 mt-4">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="rdo-addless" id="add" value="add" checked required>
          <label class="form-check-label" for="add">
            Add
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="rdo-addless" id="less" value="less" required>
          <label class="form-check-label" for="less">
            Less
          </label>
        </div>
      </div>

      </div>
    </div>

      </div>
      <div class="modal-footer">
        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">Product ajusted successfully</label>    
        </div> 
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
        <button style="color: #fff" type="submit" class="btn btn-sm btn-warning mr-3" id="btn-adjust">Adjust</button>
      </div>
    </div>
  </div>
</div>

