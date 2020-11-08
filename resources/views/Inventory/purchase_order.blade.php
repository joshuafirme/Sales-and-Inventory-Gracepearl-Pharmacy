@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Purchase Order</h3>
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
        
          <div class="col-sm-6  col-lg-12 mb-3">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ordersModal"><span class='fas fa-cart-arrow-down'></span> Purchase Orders  <span class="badge badge-warning"> 16</span></button> 
            </div>

          <div class="col-md-12 col-lg-12 mt-2">
  
          <div class="card">
            <div class="card-body">

                <div class="form-group row">
            
                    <label class="m-2 ml-2">Filter By:</label>
                    <select class=" form-control col-sm-2" name="unit" id="unit">
                      
                      @foreach($suplr as $data)
                    <option value={{ $data->id }}>{{ $data->supplierName }}</option>
                      @endforeach
                    </select>
                  </div>

                <div class="container-fluid">
                  <div class="row">

             </div>
            </div>    
                    <table class="table responsive  table-hover" id="purchase-order-table" width="100%">                               
                      <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Description</th> 
                            <th>Supplier</th>          
                            <th>Stock</th>                                
                            <th>Re Order</th>             
                            <th>Expiration Date</th>
                            <th>Action</th>
                         
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



