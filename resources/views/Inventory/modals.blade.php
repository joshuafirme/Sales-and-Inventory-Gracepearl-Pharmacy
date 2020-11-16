
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

<!-- Add to Order Modal -->
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
          <div class="row">
        {{ csrf_field() }}

        <input type="hidden" id="product_code_hidden" required>

        <div class="col-md-4 mb-2">
          <label class="col-form-label">Product Code</label>
          <input type="text" class="form-control" name="po_product_code" id="po_product_code" readonly>
        </div>
        
        <div class="col-md-8 mb-2">
          <label class="col-form-label">Description</label>
          <input type="text" class="form-control" name="po_description" id="po_description" readonly>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Category</label>
          <input type="text" class="form-control" name="po_unit" id="po_category" readonly>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Unit</label>
          <input type="text" class="form-control" name="po_unit" id="po_unit" readonly>
        </div>
        

        <div class="col-md-4 mb-2">
          <label class="col-form-label">Stock</label>
          <input type="text" class="form-control" name="po_qty" id="po_qty" readonly>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Supplier</label>
          <input type="text" class="form-control" name="po_supplier" id="po_supplier" readonly>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Unit Price</label>
          <input type="number" class="form-control" id="po_price" readonly>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">Quantity Order</label>
          <input type="number" min="1" class="form-control" id="po_qty_order">
        </div>

        <div class="col-md-4 mt-2 ml-auto">
          <label class="col-form-label">Amount<h5 id="po_amount">₱0</h5></label>
        </div>

    </div>

      </div>
      <div class="modal-footer">
        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">Product added</label>    
        </div> 
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
        <button style="color: #fff" type="submit" class="btn btn-sm btn-success" id="btn-add-to-order"><span><i class="fas fa-plus"></i></span> Add to Order</button>
      </div>
    </div>
  </div>
</div>


<!-- Send Order -->
<div class="modal fade" id="ordersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Request Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

  
         
        <?php $subtotal = 0; $total = 0; ?>
        <table class="table responsive table-hover mb-2 mt-4" id="order-table">                               
          <thead>
            <tr>
                <th>Product Code</th>
                <th>Description</th> 
                <th>Category</th>           
                <th>Unit</th>     
                <th>Unit Price</th>                                          
                <th>Qty Order</th>   
                <th>Amount</th>  
             
            </tr>
            <tbody>
              <tr>
                @if(session('orders'))
                        @foreach(session('orders') as $product_code => $details)
                        <td>{{ $product_code }}</td>
                        <td>{{ $details['description'] }}</td>
                        <td>{{ $details['category'] }}</td>
                        <td>{{ $details['unit'] }}</td>
                        <td>{{ number_format($details['price']) }}</td>
                        <td>{{ $details['qty_order'] }}</td>   
                        <?php $subtotal = $details['price']  * $details['qty_order'];
                        $total += $subtotal;
                        ?>
                        <td>{{ number_format($subtotal) }}</td>
                      </tr>
                      @endforeach
                      @endif  
            </tbody>
        </thead>
        
        </table>

        <div class="line mb-3"></div>


      <div class="row">
     
        <label class="col-sm-3 ml-auto mr-4">Total Amount: ₱{{ number_format($total) }}</label>

        <div class="col-sm-6  col-lg-12 mt-2">
          <button class="btn btn-outline-danger btn-sm mt-2" id="btn-download-order"><span class='fas fa-download'></span> Download PDF</button> 
          <button class="btn btn-outline-dark btn-sm mt-2" id="btn-print-order"><span class='fas fa-print'></span> Print</button>  
          
          <div class="line mt-4 mb-3"></div>
          </div>

        <div class="col-md-6 mb-2">
          <label class="col-form-label">Supplier's Email</label>
          <input type="email" class="form-control" name="email" id="supplier_email" required>
        </div>
    

      </div>
      <div class="modal-footer">
        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">Order sent successfully</label>    
        </div> 
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">

        <button type="submit" style="color: #fff" class="btn btn-sm btn-success" id="btn-send-order">Send Order <i class="fas fa-paper-plane"></i></button>
     
      </div>
    </div>
  </div>
</div>

