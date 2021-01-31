@yield('po_modal')


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
          @if($PORequest) 
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
                
                          @foreach($PORequest as $data)
                          <td>{{ $data->product_code }}</td>
                          <td>{{ $data->description }}</td>
                          <td>{{ $data->supplierName }}</td>
                          <td>{{ $data->unit }}</td>
                          <td>{{ $data->category_name }}</td>
                          <td>₱{{ number_format($data->selling_price, 2, '.', '') }}</td>
                          <td>{{ $data->qty }}</td>    
                          <td>₱{{ number_format($data->amount, 2, '.', '') }}</td>      
                          <td>
                            <a class="btn" name="id" id="btn-remove-order" delete-id="{{ $data->product_code }}"><span style="color: #FF0000">&times;</span></a>
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
                            <b>₱<span id="txt_po_total"></span></b>
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