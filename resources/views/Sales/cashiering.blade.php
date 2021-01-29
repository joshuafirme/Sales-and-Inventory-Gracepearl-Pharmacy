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

                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-3 col-form-label">Qty</label>
                          <div class="col-sm-8">
                            <input type="number" min="1" class="form-control" id="qty_order" >
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
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Total</label>
                            <div class="col-sm-7">
                              <input type="number" class="form-control" id="total" readonly>
                            </div>
                          </div> 

                          <button style="font-size: 12px;" class="btn btn-primary btn-sm btn-addToCart" id="btn-addToCart"> ADD [F9]</button> 

                        </div>
             
                      </div>
                 
                      </div>
                    
                </div>

                <div class="card ml-3 mt-3" style="width: 350px">
                
                  <div class="card-body">
  
                        <div class="row amount-due">
                       
                            <label>Total Amout Due</label>
                              <input type="text" class="form-control" id="total-amount-due" value="{{ $getTotalAmount }}" readonly>
                  
                              <label>Tentered</label>
                              <input type="text" class="form-control" id="tendered">

                              <label>Change</label>
                              <input type="text" class="form-control" id="change" value="₱0" readonly>

                              <div class="form-check mt-1 mr-4  mb-2">
                                <input type="checkbox" class="form-check-input chk-discount" id="discount-chk">
                                <label class="form-check-label" for="exampleCheck1">Discount</label>
                              </div>

                              <div class="form-group ml-auto">
                                <button class="btn btn-success btn-sm btn-processs" style="font-size: 14px; width: 100px;" 
                                data-toggle="modal" data-target="#processModal" id="btn-process"><u>P</u>AY</button> 
                              </div>

                              <div class="discount-option" style="display: none;">
                                <div class="form-check ml-2 mr-2 mt-1">
                                  <input class="form-check-input" type="radio" name="radio-discount" id="radio-sc" value="sc" checked required>
                                  <label class="form-check-label" for="add">
                                    SC
                                  </label>
                                </div>
                                <div class="form-check mt-1 ml-2">
                                  <input class="form-check-input" type="radio" name="radio-discount" id="radio-pwd" value="pwd" required>
                                  <label class="form-check-label" for="less">
                                    PWD
                                  </label>
                                </div>

                              <p class="mt-1 ml-2">Less: ₱<span id="less-discount"></span></p>
                              </div>

                          </div> 
                    
                        </div>
                         
                        
                         
                        </div>
                      
                  </div>

                <div class="card  mt-1" style="width: 1267px">
                
                  <div class="card-body">
            <div class="box-body cashiering-table">
              <?php 
                $total = 0;
                $total_amount_generic = 0;
              ?> 
              <table class="table table-hover" id="cashiering-table" width="100%">
             
                  <thead>
                      <tr>
                          <th>Product Code</th>
                          <th>Description</th>
                          <th>Price</th>
                          <th>Qty</th>
                          <th>Amount</th>
                          <th>Action</th>
                      </tr>
                  </thead>
           
                  <tbody>

                      <tr>
                           
                        @if($getProduct)
                        @foreach($getProduct as $data)
                        <td>{{ $data->product_code }}</td>
                        <td>{{ $data->description }}</td>
                        <td>₱{{ number_format($data->selling_price, 2, '.', '') }}</td>
                        <td>{{ $data->qty }}</td>    
                        <td>₱ {{ number_format($data->amount, 2, '.', '') }}</td>
                        <td><a href="" style="cursor: pointer; color:#24568D;" class="show-void-modal" product-code="{{ $data->product_code }}"
                           data-toggle="modal" data-target="#voidModal">Void</a>
                        </td>
                      </tr>  
                                 
                      @endforeach
                      <input type="hidden" id="generic_total_hidden">
                      <td>
                      </td>
                      <td></td>    <td></td>    <td></td>    <td></td>  <td></td>
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