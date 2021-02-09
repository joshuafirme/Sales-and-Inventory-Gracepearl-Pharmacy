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
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addProductModal" id="btn-add-product"><span class='fa fa-plus'></span> Add Product</button> 

            </div>

          <div class="col-md-12 col-lg-12">
  

          <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                  <div class="row">

                  <div class="input-group col-sm-3 col-md-3 mt-4 mb-3 ml-auto " id="filter-cont">   
                    <label class="m-2 ml-2">Category</label>  

                    <select data-column="2" class="form-control" id="filter_category" name="filter-category" >
                      <option value="All">All</option>
                      @foreach($category as $data)
                    <option value="{{ $data->category_name }}">{{ $data->category_name }}</option>
                      @endforeach
                    </select>
                  </div>        
  
             </div>
            </div>    
                    <table class="table table-data responsive  table-hover" id="product-table" width="100%">                               
                      <thead>
                        <tr>
                            <th><input type="checkbox" name="select_all" value="1" id="select-all-product"></th>
                            <th>Product Code</th>
                            <th>Description</th> 
                            <th>Category</th>   
                            <th>Unit</th> 
                            <th>Supplier</th>          
                            <th>Quantity</th>
                            <th>Reorder</th>
                            <th>Original Price</th>
                            <th>Selling Price</th>
                            <th>Expiration</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    
                    </table>

                    <img class="ml-2" src="{{asset('assets/arrow_ltr.png')}}" alt="">

                    <button class="btn btn-sm btn-danger mt-2" id="btn-bulk-archive">Archive</button>

                  </div>
                </div>
                
               
            </div>
        </div>

        <footer class="page-copyright ml-auto">
          <p>© 2021. All Rights Reserved.</p>
        </footer>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @extends('maintenance.product.product_modals')
    @section('modals')
    @endsection

@endsection

