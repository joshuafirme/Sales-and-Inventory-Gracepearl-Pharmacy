@extends('layouts.admin')
@section('content')

<div class="page-header">
    <h3 class="mt-2" id="page-title">Cashiering</h3>
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
         
            <div class="card ml-3 mt-3" style="width: 900px">
                
                <div class="card-body">

                      <div class="row mt-5 ml-5">

                        <div class="col-lg-6">

                        
                          
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Search</label>
                            <div class="col-sm-8">
                              <input type="search" class="form-control" id="cashiering_search">
                            </div>
                          </div>

                          <input type="hidden" id="product_code_hidden">

                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-4 col-form-label">Product Code</label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" id="product_code" readonly>
                          </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Description</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="description" readonly>
                            </div>
                          </div>  

                          <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Stock On Hand</label>
                            <div class="col-sm-7">
                              <input type="number" class="form-control" id="qty" readonly>
                            </div>
                          </div> 

                        </div> 
                 

                          <div class="col-lg-6">

                          <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-7">
                              <input type="number" class="form-control" id="price" readonly>
                            </div>
                          </div> 

                          <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Qty</label>
                            <div class="col-sm-7">
                              <input type="number" min="1" class="form-control" id="qty_order" >
                            </div>
                          </div> 


                          <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Total</label>
                            <div class="col-sm-7">
                              <input type="number" class="form-control" id="total" readonly>
                            </div>
                          </div> 

                          <button class="btn btn-primary btn-sm btn-addToCart" id="btn-addToCart"> Add to cart</button> 

                        </div>
             
                      </div>
                 
                      </div>
                    
                </div>

                <div class="card ml-3 mt-3" style="width: 350px">
                
                  <div class="card-body">
  
                        <div class="row amount-due">
                       
                            <label>Total Amout Due</label>
                              <input type="text" class="form-control" id="total-amount-due" value="₱0" readonly>
                  
                              <label>Tentered</label>
                              <input type="text" class="form-control" id="tendered">

                              <label>Change</label>
                              <input type="text" class="form-control" id="change" value="₱0" readonly>

                              <div class="form-check mt-1 mr-2  mb-2">
                                <input type="checkbox" class="form-check-input chk-senior" id="senior-chk">
                                <label class="form-check-label" for="exampleCheck1">Senior Citizen</label>
                              </div>

                              <div class="form-group ml-auto">
                                <button class="btn btn-success btn-sm btn-processs" data-toggle="modal" data-target="#processModal" id="btn-process">Process</button> 
                              </div>

                          </div> 
                    
                        </div>
                         
                        
                         
                        </div>
                      
                  </div>

                <div class="card  mt-1" style="width: 1267px">
                
                  <div class="card-body">
            <div class="box-body cashiering-table">
              <?php $total = 0; ?> 
              <table class="table table-hover" id="cashiering-table" width="100%">
             
                  <thead>
                      <tr>
                          <th>Product Code</th>
                          <th>Description</th>
                          <th>Price</th>
                          <th>Qty</th>
                          <th>Amount</th>
                          <th>Date</th>
                          <th>Action</th>
                      </tr>
                  </thead>
           
                  <tbody>

                      <tr>
                           
                        @if(session('cart'))
                        @foreach(session('cart') as $product_code => $details)
                        <td>{{ $product_code }}</td>
                        <td>{{ $details['description'] }}</td>
                        <td>₱ {{ number_format($details['unit_price'], 2, '.', '') }}</td>
                        <td>{{ $details['qty'] }}</td>
                        <?php 
                        $sub_total = $details['qty'] * $details['unit_price'];
                        $total += $sub_total;
                         ?> 
                        <td>₱ {{ number_format($sub_total, 2, '.', '') }}</td>
                        <td>{{ $details['date'] }}</td>
                          <td>
                            <a class="btn" id="void" product-code="{{ $product_code }}" data-toggle="modal" data-target="#voidModal"><u style="color: #303E9F;">Void</u></a>
                          </td>
                      </tr>  
                                 
                      @endforeach
                      <td>
                        <input type="hidden" id="total_hidden" value={{ $total }}>
                      </td>
                      <td></td>    <td></td>    <td></td>    <td></td>    <td></td>    <td></td>
                      @endif                 
                  </tbody>
             
              </table>
            
          </div>
                  </div>
               
     </div>

            </div>
        <!-- /.row (main row) -->
      </div>
      <!-- /.container-fluid -->
      </div>
    </section>
    <!-- /.content -->
    @extends('sales.sales_modal')
@section('voidModal')
@endsection

@endsection