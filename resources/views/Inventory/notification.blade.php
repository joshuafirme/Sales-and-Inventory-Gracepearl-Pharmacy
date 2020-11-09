@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Notification</h3>
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

          <div class="col-md-12 col-lg-12 mt-2">

                <div class="container-fluid">
                     
                       <div class="row">

                        <div class="col-md-12 col-lg-12">
                          <div class="card">
                              <div class="card-body">
                                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                                      <li class="nav-item">
                                          <a class="nav-link active" id="expiry-tab" data-toggle="tab" href="#expirytab" role="tab" aria-controls="home" aria-selected="false">Near Expiry
                                            <span class="badge badge-warning"> 20</span>
                                          </a>
                                      </li>
                                      <li class="nav-item">
                                          <a class="nav-link" id="expired-tab" data-toggle="tab" href="#expiredtab" role="tab" aria-controls="profile" aria-selected="false">Expired
                                            <span class="badge badge-danger"> 3</span>
                                          </a>
                                      </li>
                                      <li class="nav-item">
                                          <a class="nav-link" id="reorder-tab" data-toggle="tab" href="#reordertab" role="tab" aria-controls="contact" aria-selected="true">Re Order
                                            <span class="badge badge-success"> 26</span>
                                          </a>
                                      </li>
                                  </ul>
                                  <div class="tab-content" id="myTabContent">
                                      <div class="tab-pane fade active show" id="expirytab" role="tabpanel" aria-labelledby="expiry-tab">
                                        <table class="table responsive  table-hover" id="near-expiry-table" width="100%">                               
                                          <thead>
                                            <tr>
                                                <th>Product Code</th>
                                                <th>Description</th> 
                                                <th>Unit</th> 
                                                <th>Category</th>            
                                                <th>Expiration Date</th>
                                            </tr>
                                        </thead>
                                        
                                        </table> 
                                      </div>
                                      <div class="tab-pane fade" id="expiredtab" role="tabpanel" aria-labelledby="expired-tab">
                                        <table class="table responsive  table-hover" id="expired-product-table" width="100%">                               
                                          <thead>
                                            <tr>
                                                <th>Product Code</th>
                                                <th>Description</th> 
                                                <th>Unit</th> 
                                                <th>Category</th>            
                                                <th>Expiration Date</th>
                                            </tr>
                                        </thead>
                                        
                                        </table> 
                                      </div>
                                      <div class="tab-pane fade " id="reordertab" role="tabpanel" aria-labelledby="reorder-tab">
                                        <table class="table responsive  table-hover" id="reorder-table" width="100%">                               
                                          <thead>
                                            <tr>
                                                <th>Product Code</th>
                                                <th>Description</th> 
                                                <th>Unit</th> 
                                                <th>Category</th>            
                                                <th>Expiration Date</th>
                                            </tr>
                                        </thead>
                                        
                                        </table> 
                                      </div>
                                  </div>
                              </div>
                          </div>
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



