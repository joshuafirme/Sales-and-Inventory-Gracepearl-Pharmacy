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
                  <a class="nav-link" id="packed-tab" data-toggle="tab" href="#packed_tab" role="tab" aria-controls="contact" aria-selected="true">Packed
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="dispatch-tab" data-toggle="tab" href="#dispatch_tab" role="tab" aria-controls="contact" aria-selected="true">Dispatch
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="delivered-tab" data-toggle="tab" href="#delivered_tab" role="tab" aria-controls="contact" aria-selected="true">Delivered
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="cancelled-tab" data-toggle="tab" href="#cancelled_tab" role="tab" aria-controls="contact" aria-selected="true">Cancelled order
                  </a>
                </li>
 
              </ul>   

              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="pending_tab" role="tabpanel" aria-labelledby="pending-tab">

                        <table class="table responsive table-hover" id="pending-table" width="100%">                               
                          <thead>
                            <tr>

                              <th>Order #</th>
                              <th>Customer Name</th>                                                           
                              <th>Phone No</th>        
                              <th>Email</th>
                              <th>Date placed</th>
                              <th>Status</th>
                              <th>Action</th>
                            
                            </tr>
                          </thead>
                        </table>

                </div>

                  <div class="tab-pane fade" id="processing_tab" role="tabpanel" aria-labelledby="processing-tab">

                    <table class="table responsive table-hover" id="processing-table" width="100%">                               
                      <thead>
                        <tr>

                          <th>Order #</th>
                          <th>Customer Name</th>                                                           
                          <th>Phone No</th>        
                          <th>Email</th>
                          <th>Payment method</th>
                          <th>Date placed</th>
                          <th>Status</th>
                          <th>Action</th>
                        
                        </tr>
                      </thead>
                    </table>

                  </div>

                  <div class="tab-pane fade" id="packed_tab" role="tabpanel" aria-labelledby="packed-tab">

                    <table class="table responsive table-hover" id="packed-table" width="100%">                               
                      <thead>
                        <tr>

                          <th><input type="checkbox" name="select_all" value="1" id="select-all"></th>
                          <th>Order #</th>
                          <th>Customer Name</th>                                                           
                          <th>Phone No</th>        
                          <th>Email</th>
                          <th>Payment method</th>
                          <th>Date placed</th>
                          <th>Status</th>
                          <th>Action</th>
                        
                        </tr>
                      </thead>
                    </table>

                    <img class="ml-2" src="{{asset('assets/arrow_ltr.png')}}" alt="">

                    <button class="btn btn-sm btn-success mt-2" id="btn-bulk-dispatch">Dispatch</button>

                  </div>

                  <div class="tab-pane fade" id="dispatch_tab" role="tabpanel" aria-labelledby="dispatch-tab">

                    <table class="table responsive table-hover" id="dispatch-table" width="100%">                               
                      <thead>
                        <tr>

                          <th><input type="checkbox" name="select_all" value="1" id="select-all"></th>
                          <th>Order #</th>
                          <th>Customer Name</th>                                                           
                          <th>Phone No</th>        
                          <th>Email</th>
                          <th>Payment method</th>
                          <th>Date placed</th>
                          <th>Status</th>
                          <th>Action</th>
                        
                        </tr>
                      </thead>
                    </table>

                    <img class="ml-2" src="{{asset('assets/arrow_ltr.png')}}" alt="">
                    <button class="btn btn-sm btn-success mt-2" id="btn-bulk-delivered">Delivered</button>
                    <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">

                  </div>

                  <div class="tab-pane fade" id="delivered_tab" role="tabpanel" aria-labelledby="delivered-tab">

                    <div class="row">

                      <div class="mt-2 ml-3">
                         Date Delivered
                        </div>              
                      
                      <div class="col-sm-2 mb-3">
                        <input data-column="9" type="date" class="form-control" name="date_from" id="del_date_from" value="{{ $currentDate }}">
                        </div>
      
                        <div class="mt-2">
                          -
                          </div>
            
                        <div class="col-sm-2 mb-3">
                          <input data-column="9" type="date" class="form-control" name="date_to" id="del_date_to" value="{{ $currentDate }}">
                          </div>                 

                     </div>

                    <table class="table responsive table-hover" id="delivered-table" width="100%">                               
                      <thead>
                        <tr>

                          <th>Order #</th>
                          <th>Customer Name</th>                                                           
                          <th>Phone No</th>        
                          <th>Email</th>
                          <th>Payment method</th>
                          <th>Date placed</th>
                          <th>Date delivered</th>
                          <th>Status</th>
                        
                        </tr>
                      </thead>
                    </table>

                  </div>

                  <div class="tab-pane fade" id="cancelled_tab" role="tabpanel" aria-labelledby="cancelled-tab">

                    <div class="row">

                      <div class="mt-2 ml-3">
                         Date Cancelled
                        </div>              
                      
                      <div class="col-sm-2 mb-3">
                        <input data-column="9" type="date" class="form-control" name="date_from" id="cancelled_date_from" value="{{ $currentDate }}">
                        </div>
      
                        <div class="mt-2">
                          -
                          </div>
            
                        <div class="col-sm-2 mb-3">
                          <input data-column="9" type="date" class="form-control" name="date_to" id="cancelled_date_to" value="{{ $currentDate }}">
                          </div>                 

                     </div>
                     
                    <table class="table responsive table-hover" id="cancelled-table" width="100%">                               
                      <thead>
                        <tr>

                          <th>Order #</th>
                          <th>Customer Name</th>                                                           
                          <th>Phone No</th>        
                          <th>Email</th>
                          <th>Status</th>
                          <th>Reason</th>
                          <th>Date placed</th>
                          <th>Date cancelled</th>
                        
                        </tr>
                      </thead>
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

    @extends('manageonlineorder.modals')
    @section('modals')
    @endsection

@endsection



