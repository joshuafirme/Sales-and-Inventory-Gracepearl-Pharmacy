@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Archive</h3>
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
                              <a class="nav-link  active" id="archive-product-tab" data-toggle="tab" href="#archive-product_tab" role="tab" aria-controls="contact" aria-selected="true">Product</a>
                            </li>
            
                            <li class="nav-item">
                                <a class="nav-link" id="archive-sales-tab" data-toggle="tab" href="#archive-sales_tab" role="tab" aria-controls="contact" aria-selected="true">Sales
                                </a>
                            </li>
            
                            <li class="nav-item">
                              <a class="nav-link" id="packed-tab" data-toggle="tab" href="#packed_tab" role="tab" aria-controls="contact" aria-selected="true">Purchase Order
                              </a>
                            </li>
            
                            <li class="nav-item">
                              <a class="nav-link" id="dispatch-tab" data-toggle="tab" href="#dispatch_tab" role="tab" aria-controls="contact" aria-selected="true">Supplier Delivery
                              </a>
                            </li>
            
                            <li class="nav-item">
                              <a class="nav-link" id="delivered-tab" data-toggle="tab" href="#delivered_tab" role="tab" aria-controls="contact" aria-selected="true">Product Return
                              </a>
                            </li>
             
                          </ul>   
            
                          <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="archive-product_tab" role="tabpanel" aria-labelledby="archive-product-tab">
            
                              <div class="row">

                                <div class="mt-2 ml-3">
                                   Date Archived
                                  </div>              
                                
                                <div class="col-sm-2 mb-3">
                                  <input data-column="9" type="date" class="form-control" id="date_from" value="{{ date('Y-m-d') }}">
                                  </div>
                
                                  <div class="mt-2">
                                    -
                                    </div>
                      
                                  <div class="col-sm-2 mb-3">
                                    <input data-column="9" type="date" class="form-control" id="date_to" value="{{ date('Y-m-d') }}">
                                    </div>
                
                
                               </div>

                                    <table class="table responsive table-hover" id="archive-product-table" width="100%">                               
                                      <thead>
                                        <tr>

                                            <th><input type="checkbox" name="select_all" value="1" id="select-all-archive-product"></th>
                                            <th>Product Code</th>
                                            <th>Description</th> 
                                            <th>Category</th>   
                                            <th>Unit</th> 
                                            <th>Supplier</th>          
                                            <th>Quantity</th>
                                            <th>Reorder</th>
                                            <th>Original Price</th>
                                            <th>Selling Price</th>
                                            <th>Expiration</th>
                                            <th>Date Archived</th>
                                            <th>Action</th>
                                        
                                        </tr>
                                      </thead>
                                    </table>

                                    <img class="ml-2" src="{{asset('assets/arrow_ltr.png')}}" alt="">

                                    <button class="btn btn-sm btn-success mt-2" id="btn-bulk-retrieve">Retrieve</button>
            
                            </div>
            
                              <div class="tab-pane fade" id="archive-sales_tab" role="tabpanel" aria-labelledby="archive-sales-tab">
            
                                <table class="table responsive table-hover" id="archive-sales-table" width="100%">                               
                                  <thead>
                                    <tr>
            
                                      <th>Sales Invoice #</th>
                                      <th>Product Code</th>
                                      <th>Description</th> 
                                      <th>Category</th>   
                                      <th>Unit</th>         
                                      <th>Quantity</th>
                                      <th>Amount</th>
                                      <th>Payment Method</th>   
                                      <th>Date</th>
                                      <th>From</th>
                                      <th>Date Archived</th>
                                      <th>Action</th>
                                    
                                    </tr>
                                  </thead>
                                </table>
            
                              </div>
            
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
        
     
    </section>
    <!-- /.content -->
    @include('utilities.modal')

@endsection



