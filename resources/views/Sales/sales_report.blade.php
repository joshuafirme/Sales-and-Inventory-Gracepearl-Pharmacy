@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Sales Report</h3>
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

          <div class="col-sm-2 col-md-2 col-lg-10 mb-3">
            <button class="btn btn-primary btn-sm"><span class='fa fa-print'></span> Print</button> 

            </div>

          <div class="col-md-12 col-lg-12">
  

          <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                  <div class="row">
       
  
             </div>
            </div>    
                    <table class="table table-striped responsive  table-hover" id="sales-report-table" width="100%">                               
                      <thead>
                        <tr>
                            <th>Transaction No</th>
                            <th>Sales Invoice #</th>
                            <th>Product Code</th>
                            <th>Description</th> 
                            <th>Category</th>   
                            <th>Unit</th>    
                            <th>Supplier</th>        
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>From</th>
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
    @extends('sales.sales_modal')
    @section('voidModal')
    @endsection

@endsection

