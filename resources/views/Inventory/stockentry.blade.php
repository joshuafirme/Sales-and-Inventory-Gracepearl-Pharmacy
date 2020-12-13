@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Stock Entry</h3>
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
                  <a class="nav-link  active" id="reorder-tab" data-toggle="tab" href="#reordertab" role="tab" aria-controls="contact" aria-selected="true">Delivered Products </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orderstab" role="tab" aria-controls="contact" aria-selected="true">Stock Entered</a>
                </li>
 
              </ul>

              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="reordertab" role="tabpanel" aria-labelledby="reorder-tab">

       
  
                    <table class="table responsive  table-hover" id="delivered-table" width="100%">                                     
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
                   
                  </tbody>
                    
                    </table>
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



