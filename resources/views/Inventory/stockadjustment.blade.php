@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Stock Adjustment</h3>
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

          <div class="col-sm-2 col-md-2 col-lg-10 mb-3">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#stockAdjustmentModal"><span class='fa fa-plus'></span> Add Adjustment</button>  
            </div>


          <div class="col-md-12 col-lg-12">
  

          <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                  <div class="row">

                          
  
             </div>
            </div>    
                    <table class="table responsive  table-hover" id="stockadjustment-table" width="100%">                               
                      <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Description</th>   
                            <th>Quantity On Record</th>
                            <th>Quantity To Adjusted</th>
                            <th>Remarks</th>
                            <th>Date Adjusted</th>
                            <th style="width: 100px;">Action</th>
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



