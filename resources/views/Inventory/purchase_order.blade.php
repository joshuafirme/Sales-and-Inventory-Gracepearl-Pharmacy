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
    
      
      <form method="POST" action="{{action('PurchaseOrderCtr@pay')}}">
        {{ csrf_field() }}
        <div class="row">
        
          <div class="col-sm-6  col-lg-12 mb-3">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ordersModal" id="btn-show-orders"><span class='fas fa-cart-arrow-down' ></span> Request Orders</button>
            <button type="submit" class="btn btn-primary btn-sm" id="btn-pay-"><span class='fas fa-money-bill' ></span> GCash</button>
          </form>
            </div>

          <div class="col-md-12 col-lg-12 mt-2">
  
          <div class="card">
            <div class="card-body">
              <ul class="nav nav-tabs" id="myTab" role="tablist">

                <li class="nav-item">
                  <a class="nav-link  active" id="reorder-tab" data-toggle="tab" href="#reordertab" role="tab" aria-controls="contact" aria-selected="true">Reorder Products
                  <span class="badge badge-pill badge-success">{{ $reorderCount }}</span>
                  </a>
              </li>
             
                 
              </ul>
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
                      @if(count($product) > 0)                        
                      <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Description</th> 
                            <th>Unit</th>      
                            <th>Category</th>      
                            <th>Supplier</th>          
                            <th>Stock</th>                                
                            <th>Reorder Point</th>        
                            <th>Action</th>
                         
                        </tr>
                    </thead>
                    <tbody>
                      <tr>    
                        @foreach ($product as $data)                        
                        <td>{{ $data->productCode }}</td>
                        <td>{{ $data->description }}</td>
                        <td>{{ $data->unit }}</td>
                        <td>{{ $data->category_name }}</td>
                        <td>{{ $data->supplierName }}</td>
                        <td>{{ $data->qty }}</td>
                        <td>{{ $data->re_order }}</td>                                   
                        <td>
                          <a class="btn" id="btn-add-order" product-code="{{ $data->id }}" data-toggle="modal" data-target="#purchaseOrderModal"><i class="fa fa-cart-plus"></i></a>
                        </td>
                      </tr>
                      @endforeach  
                      @else
                      <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> </h5>No data found
                      </div>  
                @endif                      
                  </tbody>
                    
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



