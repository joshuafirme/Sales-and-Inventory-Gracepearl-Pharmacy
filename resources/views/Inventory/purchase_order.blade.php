@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Purchase Order</h3>
          <hr>
      </div>

        @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
    
                <li>{{$error}}</li>
                    
                @endforeach
            </ul>
        </div>
        @endif
    
      
        <div class="row">
        
          <div class="col-sm-6  col-lg-12 mb-2">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ordersModal" id="btn-show-orders"><span class='fas fa-cart-arrow-down' ></span> Request Orders</button>
           
            </div>
          <!--  <form method="POST" action="//action('PurchaseOrderCtr@pay')">
               #CSRF
              <button type="submit" class="btn btn-primary btn-sm" id="btn-pay-"><span class='fas fa-money-bill' ></span> GCash</button>
               </form>-->

          <div class="col-md-12 col-lg-12 mt-2">
  
          <div class="card">
            <div class="card-body">
              
              <ul class="nav nav-tabs" id="myTab" role="tablist">

                <li class="nav-item">
                  <a class="nav-link  active" id="reorder-tab" data-toggle="tab" href="#reordertab" role="tab" aria-controls="contact" aria-selected="true">Reorder Products   

                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orderstab" role="tab" aria-controls="contact" aria-selected="true">Purchase Orders   

                  </a>
                </li>
 
              </ul>

              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="reordertab" role="tabpanel" aria-labelledby="reorder-tab">

                <div class="form-group row">
            
                    <label class="m-2 ml-3">Supplier</label>
                    <select data-column="4" class=" form-control col-sm-2 ml-2" name="ro_supplier" id="ro_supplier">
                      
                      @foreach($suplr as $data)
                    <option value={{ $data->supplierName }}>{{ $data->supplierName }}</option>
                      @endforeach
                    </select>
                  </div>

                  @if(count($product) > 0)     
                    <table class="table responsive  table-hover" id="reorder-table" width="100%">                                     
                      <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Description</th> 
                            <th>Unit</th>      
                            <th>Category</th>      
                            <th>Supplier</th>          
                            <th>Stock</th>                                
                            <th>Reorder Point</th>        
                            <th>Action</th>
                         
                        </tr>
                    </thead>
                    <tbody>
                      @else
                      <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> </h5>No data found
                      </div>  
                @endif                      
                  </tbody>
                    
                    </table>
                  </div>

                  <div class="tab-pane fade" id="orderstab" role="tabpanel" aria-labelledby="orders-tab">

                    <div class="form-group row">
                
                        <label class="m-2 ml-3">Supplier</label>
                        <select data-column="5" class=" form-control col-sm-2 ml-2" name="ord_supplier" id="ord_supplier">
                          @foreach($suplr as $data)
                        <option value={{ $data->supplierName }}>{{ $data->supplierName }}</option>
                          @endforeach
                        </select>
                      </div>

                      @if(count($getAllOrders) > 0) 
                        <table class="table responsive  table-hover" id="ord-table" width="100%">       
                          <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Product Code</th>     
                                <th>Description</th>   
                                <th>Supplier</th> 
                                <th>Category</th> 
                                <th>Unit</th>                                 
                                <th>Qty Order</th>        
                                <th>Amount</th>
                                <th>Date Order</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                          @else
                          <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> </h5>No orders found
                          </div>  
                           @endif                     
                      </tbody>
                        
                        </table> 
                      </div>

                </div>

                  </div>
                </div>
                
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @extends('inventory.modals')
    @section('modals')
    @endsection

@endsection



