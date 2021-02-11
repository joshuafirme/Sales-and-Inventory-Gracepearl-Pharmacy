
@yield('modals')


<!-- show order items -->
<div class="modal fade" id="showItemsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title-order-no"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

                
                <div class="row">

                  <div class="col-md-12">

                        <table class="table responsive table-striped table-hover mt-2" id="cust-order-table">                               
                            <thead>
                              <tr>
                                  <th>Product Code</th>
                                  <th>Description</th>  
                                  <th>Category</th>           
                                  <th>Unit</th>     
                                  <th>Qty</th>      
                                  <th>Price</th>    
                                  <th>Amount</th>  
                               
                              </tr>
                            </thead>
              
                              <tbody>
                                  @if(session('order'))
                                  @foreach(session('order') as $product_code => $data)
                                  <tr>
                              
                                      <td>{{ $product_code }}</td>
                                      <td>{{ $data['description'] }}</td>
                                      <td>{{ $data['category'] }}</td>
                                      <td>{{ $data['unit'] }}</td>
                                      <td>{{ $data['qty'] }}</td>
                                      <td>₱ {{ number_format($data['unit_price'], 2, '.', ',') }}</td>
                                      <td>₱ {{ number_format($data['amount'], 2, '.', ',') }}</td>
                                      
                                  </tr>  
                                  @endforeach
                                  <tr>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td>Subtotal:</td>
                                      <td>
                                        ₱ {{ number_format(session('order-total-amount'), 2, '.', ',') }}
                                      </td>   
                                   </tr> 
                                   <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>SC/PWD Discount:</td>
                                    <td>
                                      ₱ <span id="txt_sc_pwd_discount">-</span>
                                    </td>   
                                 </tr> 
                                   <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Shipping Fee:</td>
                                    <td>
                                      ₱ <span id="txt_shipping_fee"></span>
                                    </td>   
                                 </tr> 
                                 <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td>Total Amount:</td>
                                  <td>
                                    <b>₱ <span id="txt_total_amount"></span></b>
                                  </td>   
                               </tr> 
                                  @endif
                              </tbody>
                              
                          </thead>
                          
                          </table>

                  </div>

                    
                    <div class="col-md-12 mb-2"><hr></div>

                    <div class="col-md-12 mb-2">
                        <h5>Customer Information</h5>
                        <span class="badge badge-success" id="verification-info"></span>
                    </div>
                    
                    <input type="hidden" id="order-no">
                    <input type="hidden" id="user-id">
    
                    <div class="col-md-4">
                        <label class="label-small" >Full Name</label>
                        <p id="fullname"></p>
                    </div>
        
                    <div class="col-md-4">
                        <label class="label-small">Email Address</label>
                        <p  id="email"></p>
                    </div>
        
                    <div class="col-md-4">
                        <label class="label-small">Phone Number</label>
                        <p  id="phone-no"></p>
                    </div> 
        
                    <div class="col-md-12 mb-2"><hr></div>
    
    
        
                    <div class="col-md-12 mb-2">
                        <h5>Shipping Address</h5>
                    </div>
    
                    <div class="col-md-4 mb-3">
                        <label class="label-small">House/Unit/Flr #, Bldg Name, Blk or Lot #</label>
                        <p id="flr-bldg-blk"></p>
                    </div> 
        
                    <div class="col-md-4">
                        <label class="label-small">Barangay</label>
                        <p id="brgy"></p>
                    </div> 
        
                    <div class="col-md-4">
                        <label class="label-small">Notes</label>
                        <p id="note"></p>
                    </div> 
          
                  </div>

      
        </div>
  
        <div class="modal-footer">
          <div class="update-success-validation mr-auto ml-3" style="display: none">
            <label class="label text-success">Items packed successfully</label>    
          </div> 
          <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
          <button class="btn btn-outline-dark btn-sm" id="btn-gen-sales-inv"><span class='fas fa-print'></span> Generate Sales Invoice</button> 
          <button style="color: #fff" class="btn btn-sm btn-success" id="btn-pack">Pack items</button>
       
        </div>
  
      </div>
    </div>
  </div>