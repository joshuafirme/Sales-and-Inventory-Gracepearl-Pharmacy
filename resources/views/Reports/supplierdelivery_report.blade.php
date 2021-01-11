@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Supplier Delivery Report</h3>
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
                   Date Delivered
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

                    <div class="mt-2 ml-4">
                      Supplier
                    </div>

                    <div class="col-sm-2 mb-3">
                      <select data-column="4" class=" form-control col-sm-12" name="sales_category" id="sales_category">
                        <option value="All">All</option>
                  
                      </select>
                      </div>


               </div>

                <table class="table responsive table-hover" id="supplierdelivery-report-table" width="100%">                               
                    <thead>
                      <tr>
                        <th>Delivery #</th>
                        <th>PO #</th>
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
                  </table>
                    
                  </div>
                </div>
                
            </div>
        </div>

        <!-- /.row (main row) -->
        
     
    </section>
    <!-- /.content -->


@endsection



