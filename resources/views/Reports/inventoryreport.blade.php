@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Inventory Report</h3>
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
                <table class="table responsive table-hover" id="inventory-report-table" width="100%">                               
                    <thead>
                      <tr>

                        <th>Product Code</th>
                        <th>Description</th>   
                        <th>Category</th>        
                        <th>Unit</th>   
                        <th>Supplier</th>             
                        <th>Quantity</th>
                        <th>Expiration</th>
                      
                      </tr>
                    </thead>
                  </table>
                    
                  </div>
                </div>
                
            </div>
        </div>

        <!-- /.row (main row) -->
        
     
    </section>
    <!-- /.content -->


@endsection



