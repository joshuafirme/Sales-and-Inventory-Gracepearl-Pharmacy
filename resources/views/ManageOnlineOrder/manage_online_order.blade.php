@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Manage Online Order</h3>
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
                  <a class="nav-link  active" id="pending-tab" data-toggle="tab" href="#pending_tab" role="tab" aria-controls="contact" aria-selected="true">Pending</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="processing-tab" data-toggle="tab" href="#processing_tab" role="tab" aria-controls="contact" aria-selected="true">Processing
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="ready-tab" data-toggle="tab" href="#ready_tab" role="tab" aria-controls="contact" aria-selected="true">Ready to ship
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="dispatch-tab" data-toggle="tab" href="#dispatch_tab" role="tab" aria-controls="contact" aria-selected="true">Dispatch
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed_tab" role="tab" aria-controls="contact" aria-selected="true">Completed
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="cancelled-order-tab" data-toggle="tab" href="#cancelled_order_tab" role="tab" aria-controls="contact" aria-selected="true">Cancelled order
                  </a>
                </li>
 
              </ul>   

              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="pendingtab" role="tabpanel" aria-labelledby="pending-tab">

                        <table class="table responsive table-hover" id="pening-table" width="100%">                               
                          <thead>
                            <tr>

                              <th>Order #</th>
                              <th>Customer Name</th>                                                           
                              <th>Phone No</th>        
                              <th>Email</th>
                              <th>Total Products</th>
                              <th>Total amount</th>
                              <th>Payment method</th>
                              <th>Date placed</th>
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
                                <th>Invoice #</th>
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
                        <img src="../../assets/arrow_ltr.png" class="ml-2">
                        
                        <button class="btn btn-success btn-sm mr-2" id="btn-mark-as-completed"> Mark as Completed</button> 
                        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none"> 
                      </div>

                </div>
                    
                  </div>
                </div>
                
            </div>
        </div>

        <!-- /.row (main row) -->
        
     
    </section>
    <!-- /.content -->

    @extends('manageonlineorder.modals')
    @section('modals')
    @endsection

@endsection



