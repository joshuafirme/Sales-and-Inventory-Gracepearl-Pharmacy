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

            <div class="col-md-12 col-lg-12">
  
              <div class="card mt-3" style="width: 900px">
                
                <div class="card-body">

                      <div class="row mt-5 ml-5">

                        <div class="col-lg-6">
                          
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Search</label>
                            <div class="col-sm-8">
                              <input type="search" class="form-control" id="stock_search">
                            </div>
                          </div>

                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-4 col-form-label">Product Code</label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" name="product_code" id="product_code" readonly>
                          </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Description</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" name="description" id="description" readonly>
                            </div>
                          </div>  
                      
                        </div> 
            

                          <div class="col-lg-6">

                            <div class="form-group row">
                              <label for="inputEmail3" class="col-sm-4 col-form-label">Stock</label>
                              <div class="col-sm-5">
                                <input type="number" class="form-control" id="qty" readonly>
                              </div>
                            </div> 

                          <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Qty to Adjust</label>
                            <div class="col-sm-5">
                              <input type="number" class="form-control" name="qty-to-adjust" id="qty-to-adjust">
                            </div>
                          </div> 

                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="rdo-addless" id="add" value="add" checked>
                            <label class="form-check-label" for="add">
                              Add
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="rdo-addless" id="less" value="less">
                            <label class="form-check-label" for="less">
                              Less
                            </label>
                          </div>

                          <button class="btn btn-primary btn-sm mt-2" id="btn-adjust">Adjust</button> 

                        </div>
             
                      </div>
                 
                      </div>
                    
                </div>

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
                            <th>Stock</th>
                            <th>Action</th>
                            <th>Expiration Date</th>
                         
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

   

@endsection



