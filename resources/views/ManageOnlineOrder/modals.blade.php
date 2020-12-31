
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

            <div class="container-fluid">
                
                <div class="row">
               
                    <table class="table responsive table-hover mt-4" id="cust-order-table">                               
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
                                <td>₱ {{ number_format($data['unit_price'], 2, '.', '') }}</td>
                                <td>₱ {{ number_format($data['amount'], 2, '.', '') }}</td>
                                
                            </tr>  
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total:</td>
                                <td>
                                  <b>₱ {{ number_format(session('order-total-amount')) }}</b>
                                </td>   
                             </tr> 
                            @endif
                        </tbody>
                        
                    </thead>
                    
                    </table>
                 
          
                  </div>

            </div>
      
        </div>
  
        <div class="modal-footer">
          <div class="update-success-validation mr-auto ml-3" style="display: none">
            <label class="label text-success">Order sent successfully</label>    
          </div> 
          <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
          <button class="btn btn-outline-dark btn-sm" id="btn-gen-sales-inv"><span class='fas fa-print'></span> Generate Sales Invoice</button> 
          <button style="color: #fff" class="btn btn-sm btn-success" id="btn-pack">Pack items</button>
       
        </div>
  
      </div>
    </div>
  </div>