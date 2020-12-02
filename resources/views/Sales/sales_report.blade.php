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

          <div class="col-md-12 col-lg-12">

          <div class="card">
            <div class="card-body">

              
                  <div class="row">

                    <div class="col-sm-2 mb-3">
                      <input data-column="9" type="date" class="form-control" name="sales_date_from" id="sales_date_from" value="{{ $currentDate }}">
                      </div>

                      <div class=" mt-1">
                        to
                        </div>
          
                      <div class="col-sm-2 mb-3">
                        <input data-column="9" type="date" class="form-control" name="sales_date_to" id="sales_date_to" value="{{ $currentDate }}">
                        </div>

                        <div class="col-sm-2  mb-3">
                          <select data-column="4" class=" form-control col-sm-12" name="sales_category" id="sales_category">
                            @foreach($category as $data)
                          <option value={{ $data->category_name }}>{{ $data->category_name }}</option>
                            @endforeach
                          </select>
                          </div>

                        <div class="col-sm-2 mt-1">
                          <button class="btn btn-primary btn-sm btn-load-records" id="btn-print"><span class='fa fa-redo'></span> Load Records</button> 
                          </div>
                          

                        
                          <div class="col-sm-2 mt-1 ml-auto">          
                            <p class="total-sales">Total Sales: {{ number_format($totalSales) }}</p>
                            </div>

                   </div>

                    <table class="table table-data responsive  table-hover" id="sales-report-table" width="100%">                               
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

