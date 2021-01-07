@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Supplier Delivery</h3>
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
    
        @if(\Session::has('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> </h5>
          {{ \Session::get('success') }}
        </div>      
        @endif

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-2">
  
          <div class="card">
            <div class="card-body">
              <ul class="nav nav-tabs" id="myTab" role="tablist">

                <li class="nav-item">
                  <a class="nav-link  active" id="po-tab" data-toggle="tab" href="#potab" role="tab" aria-controls="contact" aria-selected="true">Purchase Orders   

                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="delivered-tab" data-toggle="tab" href="#deliveredtab" role="tab" aria-controls="contact" aria-selected="true">Delivered Products   

                  </a>
                </li>
 
              </ul>   

              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="potab" role="tabpanel" aria-labelledby="po-tab">

                        <table class="table responsive table-hover" id="po-table" width="100%">                               
                          <thead>
                            <tr>

                              <th>PO #</th>
                              <th>Product Code</th>     
                              <th>Description</th>   
                              <th>Supplier</th> 
                              <th>Category</th> 
                              <th>Unit</th>                                 
                              <th>Qty Order</th>        
                              <th>Amount</th>
                              <th>Date Order</th>
                              <th>Status</th>
                              <th>Action</th>
                            
                            </tr>
                          </thead>
                        </table>
                        </div>

                  <div class="tab-pane fade" id="deliveredtab" role="tabpanel" aria-labelledby="delivered-tab">


                        <table class="table responsive  table-hover" id="supplier-delivery-table" width="100%">       
                          <thead>
                            <tr>
                                <th><input type="checkbox" name="select_all" value="1" id="select-all"></th>
                                <th>Delivery #</th>
                                <th>PO #</th>
                                <th>Product Code</th>     
                                <th>Description</th>   
                                <th>Supplier</th> 
                                <th>Category</th> 
                                <th>Unit</th>      
                                <th>Qty Ordered</th>                              
                                <th>Qty Delivered</th>   
                                <th>Expiration Date</th>  
                                <th>Date Recieved</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                                              
                       </tbody>
                        
                        </table> 
                       
                      </div>

                </div>
                    
                  </div>
                </div>
                
            </div>
        </div>

        <!-- /.row (main row) -->
        
     
    </section>
    <!-- /.content -->

    @extends('inventory.modals')
    @section('modals')
    @endsection

@endsection



