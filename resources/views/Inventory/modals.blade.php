
@yield('modals')
<!-- Stock Adjustment -->
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
          <div class="row">
        {{ csrf_field() }}

        <input type="hidden" id="id_hidden" required>
        <input type="hidden" id="product_code_hidden" required>

        <div class="col-md-4 mb-2">
          <label class="col-form-label">Product Code</label>
          <a class="form-control" name="product_code" id="product_code"></a>
        </div>
        
        <div class="col-md-4 mb-2">
          <label class="col-form-label">Description</label>
          <a class="form-control" name="description" id="description"></a>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Unit</label>
          <a class="form-control" id="unit"></a>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Category</label>
          <a class="form-control" id="category"></a>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Supplier</label>
          <a class="form-control" id="supplier"></a>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Stock on hand</label>
          <a class="form-control" id="qty"></a>
        </div>

        <div class="col-md-12 line mt-4 mb-2">
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Qty to adjust</label>
          <input type="number" min="0" class="form-control" name="qty_to_adjust" id="qty_to_adjust" autofocus>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Reason</label>
          <select class="form-control" name="remarks" id="remarks">
            <option value="Expired">Expired</option>
            <option value="Damaged">Damaged</option>
            <option value="Owner used">Owner used</option>
            <option value="Physical count descrepancy">Physical count descrepancy</option>
          </select>
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
      <div class="modal-footer">
        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">Product ajusted successfully</label>    
        </div> 
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
        <button class="btn btn-sm btn-success" id="btn-adjust">Adjust</button>
      </div>
    </div>
  </div>
</div>




<!-- qty deliver -->
<div class="modal fade" id="qtyDeliverModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Delivery</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="row">

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Purchase Order #</label><br>
              <a class="form-control" id="del_po_num"></a>
            </div>

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Product Code</label><br>
              <a class="form-control" id="del_product_code"></a>
            </div>

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Description</label><br>
              <a class="form-control" id="del_description"></a>
            </div>

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Supplier</label><br>
              <a class="form-control" id="del_supplier"></a>
            </div>

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Unit</label><br>
              <a class="form-control" id="del_unit"></a>
            </div>
            
            <div class="col-md-4 mb-2">
              <label class="col-form-label">Category</label><br>
              <a class="form-control" id="del_category"></a>
            </div>

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Quantity Ordered</label>
              <a class="form-control" id="del_qty_ordered"></a>
            </div>

            <div class="col-md-4">
              <label class="col-form-label">Quantity Delivered</label>
              <input type="number" min="1" max="1000" class="form-control" name="del_qty_delivered" id="del_qty_delivered">
            </div>

            <div class="col-md-4">
              <label class="col-form-label">Expiration Date</label>
              <input type="date" class="form-control" id="del_exp_date" value="{{ $getCurrentDate }}">
            </div>

            <div class="col-md-4">
              <label class="col-form-label">Date Delivered</label>
            <input type="date" class="form-control" id="del_date_recieved" value="{{ $getCurrentDate }}">
            </div>
       
            
        </div>  

      </div>
      <div class="modal-footer">

        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">Product is successfully added to delivery</label>    
        </div> 
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
          <button type="submit" class="btn btn-sm btn-primary" id="btn-add"><i class="fas fa-plus"></i> Add</button>

      </div>
    </form>
    </div>
  </div>
</div>

<!-- Return Change Modal -->
<div class="modal fade" id="returnchangeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Return Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="row">

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Sales Invoice #</label><br>
              <input type="search" class="form-control" id="rc_sales_inv_no">
            </div>

            <div class="col-md-4">
              <label class="col-form-label">List of Product Code</label>
              <select class="form-control" id="rc_product_code" name="rc_product_code" >
              </select>
            </div>

            <div class="col-md-12 mt-2 mb-2"><hr></div>

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Description</label><br>
              <a class="form-control" id="rc_description"></a>
            </div>

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Unit</label><br>
              <a class="form-control" id="rc_unit"></a>
            </div>

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Category</label><br>
              <a class="form-control" id="rc_category"></a>
            </div>
            
            <div class="col-md-4 mb-2">
              <label class="col-form-label">Selling Price</label><br>
              <a class="form-control" id="rc_selling_price"></a>
            </div>
            
            <div class="col-md-4 mb-2">
              <label class="col-form-label">Quantity Purchased</label><br>
              <a class="form-control" id="rc_qty_purchased"></a>
            </div>

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Amount Purchased</label><br>
              <a class="form-control" id="rc_amount_purchased"></a>
            </div>

            <div class="col-md-12 mt-2 mb-2"><hr></div>

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Expiration Date</label><br>
            <input type="date" class="form-control" id="rc_exp_date">
            </div>

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Qty to Return</label><br>
              <input type="number" class="form-control" id="rc_qty_return">
            </div>

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Amount</label><br>
              <input type="number" class="form-control" id="rc_amount" readonly>
            </div>

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Date</label><br>
            <input type="date" class="form-control" id="rc_date" value="{{ $getCurrentDate }}">
            </div>
       
            <div class="col-md-4">
              <label class="col-form-label">Reason</label>
              <select class="form-control" name="rc_reason" id="rc_reason">
              <option>Damaged</option>
              <option>Wrong Item</option>
              <option>Expired</option>

              </select>
            </div>
            
        </div>  

      </div>
      <div class="modal-footer">

        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">Product is successfully added to delivery</label>    
        </div> 
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
          <button type="submit" class="btn btn-sm btn-primary" id="btn-add-return"><i class="fas fa-plus"></i> Return</button>

      </div>
    </form>
    </div>
  </div>
</div>


<!--Dispose Modal-->
<div class="modal fade" id="disposeModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="dispose-message"></p>
      </div>
      <div class="modal-footer">
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button class="btn btn-sm btn-outline-dark" type="button" name="ok_button" id="ok-button">Yes</button>
        <button class="btn btn-sm btn-danger" data-dismiss="modal" id="cancel-delete">Cancel</button>
      </div>
    </div>
  </div>
</div>

