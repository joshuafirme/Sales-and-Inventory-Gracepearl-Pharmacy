@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Audit Trail Report</h3>
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

                <div class="row">


                    <div class="mt-2 ml-3">
                       Date
                      </div>              
                    
                    <div class="col-sm-2 mb-3">
                      <input data-column="9" type="date" class="form-control" name="sales_date_from" id="sales_date_from" value="">
                      </div>

                      <div class="mt-2">
                        -
                        </div>
          
                      <div class="col-sm-2 mb-3">
                        <input data-column="9" type="date" class="form-control" name="sales_date_to" id="sales_date_to" value="">
                        </div>


                        <div class="col-sm-4 mt-1">
                          <button class="btn btn-primary btn-sm btn-load-records"><span class='fas fa-sync-alt'></span> Load Records</button>   
                            
                          </div>
                 

                   </div>

                <table class="table responsive table-hover" id="audit-report-table" width="100%">                               
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Position</th> 
                        <th>Module</th> 
                        <th>Action</th>
                        <th>Date</th>     
                        <th>Time</th>                     
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



