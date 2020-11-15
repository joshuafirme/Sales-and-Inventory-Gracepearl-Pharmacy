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
                          <div class="card">
                              <div class="card-body">
                                  <ul class="nav nav-tabs" id="myTab" role="tablist">

                                    <li class="nav-item">
                                      <a class="nav-link  active" id="reorder-tab" data-toggle="tab" href="#reordertab" role="tab" aria-controls="contact" aria-selected="true">Reorder
                                        <span class="badge badge-pill badge-success"> {{ $reorderCount }} </span>
                                      </a>
                                  </li>
                                      <li class="nav-item">
                                          <a class="nav-link" id="expiry-tab" data-toggle="tab" href="#expirytab" role="tab" aria-controls="home" aria-selected="false">Near Expiry
                                            <span class="badge badge-pill badge-warning" style="color: #fff">{{ $expiryCount }}</span>
                                          </a>
                                      </li>
                                      <li class="nav-item">
                                          <a class="nav-link" id="expired-tab" data-toggle="tab" href="#expiredtab" role="tab" aria-controls="profile" aria-selected="false">Expired
                                            <span class="badge badge-pill badge-danger">{{ $expiredCount }} </span>
                                          </a>
                                      </li>
                                     
                                  </ul>
                                  <div class="tab-content" id="myTabContent">
                                      <div class="tab-pane fade" id="expirytab" role="tabpanel" aria-labelledby="expiry-tab">
             
                                        <table class="table responsive  table-hover" id="near-expiry-table" width="100%">                               
                                          @if(count($nearExpiryProduct) > 0)
                                          <thead>
                                              <tr>
                                                <th>Product Code</th>
                                                <th>Description</th> 
                                                <th>Unit</th> 
                                                <th>Category</th>            
                                                <th>Expiration Date</th>
                                              </tr>
                                          </thead>
                                                 
                                          <tbody>
                                              <tr>    
                                                @foreach ($nearExpiryProduct as $data)                        
                                                <td>{{ $data->productCode }}</td>
                                                <td>{{ $data->description }}</td>
                                                <td>{{ $data->unit }}</td>
                                                <td>{{ $data->category_name }}</td>
                                                <td>{{ $data->exp_date }}</td>
                                                
                                              </tr>
                                              @endforeach  
                                              @else
                                              <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <h5><i class="icon fas fa-exclamation-triangle"></i> </h5>No data found
                                              </div>  
                                        @endif                      
                                          </tbody>
                                        
                                        </table> 
                                      </div>
                                      <div class="tab-pane fade" id="expiredtab" role="tabpanel" aria-labelledby="expired-tab">

                                        <table class="table responsive  table-hover" id="expired-table" width="100%">   
                                                    
                                          @if(count($expiredProduct) > 0)
                                          <thead>
                                              <tr>
                                                <th>Product Code</th>
                                                <th>Description</th> 
                                                <th>Unit</th> 
                                                <th>Category</th>            
                                                <th>Expiration Date</th>
                                              </tr>
                                          </thead>
                                                 
                                          <tbody>
                                              <tr>    
                                                @foreach ($expiredProduct as $data)                        
                                                <td>{{ $data->productCode }}</td>
                                                <td>{{ $data->description }}</td>
                                                <td>{{ $data->unit }}</td>
                                                <td>{{ $data->category_name }}</td>
                                                <td>{{ $data->exp_date }}</td>                                      
                                                
                                              </tr>
                                              @endforeach  
                                              @else
                                              <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <h5><i class="icon fas fa-exclamation-triangle"></i> </h5>No data found
                                              </div>  
                                        @endif                      
                                          </tbody>
                                        
                                        </table> 
                                      </div>
                                      <div class="tab-pane fade  active show" id="reordertab" role="tabpanel" aria-labelledby="reorder-tab">

                                        <table class="table responsive  table-hover" id="reorder-table" width="100%">   
                                                    
                                          @if(count($reorderProduct) > 0)
                                          <thead>
                                              <tr>
                                                <th>Product Code</th>
                                                <th>Description</th> 
                                                <th>Category</th>    
                                                <th>Unit</th>   
                                                <th>Quantity</th>  
                                                <th>Reorder Point</th>  
                                              </tr>
                                          </thead>
                                                 
                                          <tbody>
                                              <tr>    
                                                @foreach ($reorderProduct as $data)                        
                                                <td>{{ $data->productCode }}</td>
                                                <td>{{ $data->description }}</td>
                                                <td>{{ $data->category_name }}</td>
                                                <td>{{ $data->unit }}</td>      
                                                <td>{{ $data->qty }}</td>      
                                                <td>{{ $data->re_order }}</td>   
                                           
                                                
                                              </tr>
                                              @endforeach  
                                              @else
                                              <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <h5><i class="icon fas fa-exclamation-triangle"></i> </h5>No data found
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



