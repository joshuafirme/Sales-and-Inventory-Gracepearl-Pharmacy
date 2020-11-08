
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

<div class="modal fade" id="purchaseOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add to Orders</h5>
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
          <label class="col-form-label">Stock</label>
          <input type="text" class="form-control" name="qty" id="qty" readonly>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Supplier</label>
          <input type="text" class="form-control" name="qty" id="qty" readonly>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Unit</label>
          <input type="text" class="form-control" name="qty" id="qty" readonly>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Qty Order</label>
          <input type="number" class="form-control" name="qty_to_adjust" id="qty_to_adjust">
        </div>

      </div>
    </div>

      </div>
      <div class="modal-footer">
        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">Product added</label>    
        </div> 
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
        <button style="color: #fff" type="submit" class="btn btn-sm btn-success mr-3" id="btn-add-order">Add to Orders</button>
      </div>
    </div>
  </div>
</div>


<!-- Send Order -->
<div class="modal fade" id="ordersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Orders</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
        {{ csrf_field() }}

        <table class="table responsive table-hover mb-2" id="order-table">                               
          <thead>
            <tr>
                <th>Product Code</th>
                <th>Description</th> 
                <th>Category</th>           
                <th>Unit</th>                                       
                <th>Qty Order</th>   
                <th>Amount</th>             
                <th>Action</th>
             
            </tr>
            <tbody>
              <tr>
                <td>P-100001</td>
                <td>Bio Flu</td>
                <td>Generic</td>
                <td>Box</td>
                <td>4</td>
                <td>1200</td>
              </tr>
            </tbody>
        </thead>
        
        </table>

        <div class="col-sm-6  col-lg-12 mt-2">
          <button class="btn btn-danger btn-sm mt-2"><span class='fas fa-download'></span> Download PDF</button> 
          <hr>
          </div>

        

        <div class="col-md-4 mb-2">
          <label class="col-form-label">Supplier Email</label>
          <input type="email" class="form-control" name="email" id="email" required>
        </div>
        
    

        <div class="col-md-4">
          <label class="col-form-label">Upload Order</label>
          <input type="file" name="printed_order" id="printed_order" required>
        </div>

      </div>
    </div>

      </div>
      <div class="modal-footer">
        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">Product added</label>    
        </div> 
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
        <button style="color: #fff" type="submit" class="btn btn-sm btn-success mr-4" id="btn-add-order">Send Order <i class="fas fa-paper-plane"></i></button>
      </div>
    </div>
  </div>
</div>

