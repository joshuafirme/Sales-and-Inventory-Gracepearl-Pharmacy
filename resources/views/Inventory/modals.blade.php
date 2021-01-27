
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

        <input type="hidden" id="po_product_code_hidden" required>

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
  <div class="modal-dialog modal-lg order-modal" role="document">
    <div class="modal-content lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Orders</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
  
          <div class="ml-auto mr-3">
            <button class="btn btn-outline-danger btn-sm mt-2 mb-2" id="btn-download-order" ><span class='fas fa-download'></span> Download PDF</button> 
            <button class="btn btn-outline-dark btn-sm mt-2 mb-2" id="btn-print-order"><span class='fas fa-print'></span> Print</button>  
          </div>

        </div>
       
        <?php $subtotal = 0; $total = 0; ?>
        @if(session('purchase-orders')) 
        <table class="table responsive table-hover" id="order-table">                               
          <thead>
            <tr>
                <th>Product Code</th>
                <th>Description</th>
                <th>Supplier</th>      
                <th>Category</th>           
                <th>Unit</th>     
                <th>Price</th>                                          
                <th>Qty</th>   
                <th>Amount</th>  
                <th>Action</th>  
             
            </tr>
          </thead>
            <tbody>
              <tr>
              
                        @foreach(session('purchase-orders') as $product_code => $details)
                        <td>{{ $product_code }}</td>
                        <td>{{ $details['description'] }}</td>
                        <td>{{ $details['supplier'] }}</td>
                        <td>{{ $details['category'] }}</td>
                        <td>{{ $details['unit'] }}</td>
                        <td>{{ number_format($details['price']) }}</td>
                        <td>{{ $details['qty_order'] }}</td>   
                        <?php $subtotal = $details['price'] * $details['qty_order'];
                              $total += $subtotal;
                        ?>
                        <td>{{ number_format($subtotal) }}</td>
                        
                        <td>
                          <a class="btn" name="id" id="remove-order" delete-id="{{ $product_code }}"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      
                      
                      
                      @endforeach
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>                 
                        <td></td>
                        <td>Total:</td>
                        <td>
                          <b>{{ number_format($total) }} PhP</b>
                        </td>     <td></td>
                     </tr> 
            </tbody>
            
        </thead>
        
        </table>
        @else
        <div class="alert alert-danger alert-dismissible request-order-isEmpty" style="display: block">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         <h5><i class="icon fas fa-exclamation-triangle"></i> </h5>No data found
       </div>  
         @endif 
        <div class="line"></div>


      <div class="row">
     
        <div class="col-sm-3 ml-auto">
          <label class="col-form-label">Supplier's Email</label>
          <input type="email" class="form-control" name="email" id="supplier_email" >
          <small style="display: none" class="form-text text-danger">Supplier's email is required</small>
        </div>
    

      </div>
    </div>

      <div class="modal-footer">
        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">Order sent successfully</label>    
        </div> 
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
        <button style="color: #fff" class="btn btn-sm btn-success" id="btn-send-order"> <i class="fas fa-paper-plane"></i> Send Order</button>
     
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

