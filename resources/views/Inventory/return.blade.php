@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Product Return</h3>
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

        <div class="col-sm-6  col-lg-12 mb-2">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#returnchangeModal" id="btn-add-return-change"><span class='fas fa-plus' ></span> Add</button>
        </div>      

          <div class="col-md-12 col-lg-12 mt-2">
  
          <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                  <div class="row">

             </div>
            </div>    
                    <table class="table responsive  table-hover" id="return-table" width="100%">                               
                      <thead>
                        <tr>
                            <th>Return ID</th>
                            <th>Sales Invoice #</th>
                            <th>Product Code</th>   
                            <th>Description</th>   
                            <th>Unit</th>      
                            <th>Category</th>    
                            <th>Qty</th>       
                            <th>Reason</th>   
                            <th>Date Return</th> 
                        </tr>
                    </thead>
                    
                    </table>
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



