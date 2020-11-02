@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Product Maintenance</h3>
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
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addProductModal"><span class='fa fa-plus'></span> Add Product</button> 
            <a class="btn btn-success btn-sm" href="#" target="_blank" ><span class='fa fa-file-excel'></span> Import CSV</a> 
            <a class="btn btn-danger btn-sm" id="btn-pdf" href="#"  ><span class='fa fa-print'></span> Print as PDF</a> 
            </div>


          <div class="col-md-12 col-lg-12">
  

          <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                  <div class="row">

                     
  
                  <div class="input-group col-sm-3 col-md-2 mt-4 mb-3 ml-auto " id="filter-cont">              
                    <select class="form-control" id="filter_category" name="filter-category" >
                      <option>Select Category</option>
                      @foreach($category as $data)
                    <option value={{ $data->id }}>{{ $data->category_name }}</option>
                      @endforeach
                    </select>
                  </div>        
  
             </div>
            </div>    
                    <table class="table responsive  table-hover" id="product-table" width="100%">                               
                      <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Description</th>           
                            <th>Quantity</th>
                            <th>Re-Order Point</th>
                            <th>Original Price</th>
                            <th>Selling Price</th>
                            <th>Expiration</th>
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
    @extends('maintenance.product.product_modals')
    @section('modals')
    @endsection

@endsection

