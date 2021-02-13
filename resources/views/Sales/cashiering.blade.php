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
         
            <div class="card ml-3 mt-3">
                
                <div class="card-body">
                  <table id="" class="table responsive table-bordered table-hover" style=" margin-bottom:20px;">
                    <thead>
                        <tr>
                            <th colspan="2">Search<input type="search" class="form-control" id="cashiering_search" placeholder="Search product code or description"></th>
                            <th colspan="4"><button class="btn btn-sm btn-primary" id="btn-addToCart"><i class="fa fa-plus"></i> Add</button></th>
                        </tr>
                        <tr>
                            <th>Qty</th>
                            <th>Product Code</th>
                            <th>Description</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <input type="hidden" id="id">
                            <th><input type="number" min="1" class="form-control" id="qty_order" ></th>
                            <th><input type="text" class="form-control" readonly id="product_code"></th>
                            <th><input type="text" class="form-control" readonly id="description"></th>
                            <th><input type="number" class="form-control" readonly id="qty"></th>
                            <th><input type="number" class="form-control" readonly id="price"></th>
                            <th><input type="number" class="form-control" readonly id="total"></th>
                        </tr>
                    </tbody>    
                </table>

                <?php 
                $total = 0;
                $total_amount_generic = 0;
              ?> 
              <div class="cashiering-table">
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
                        <td>
                          <a href="" style="cursor: pointer; color:#AA0000;" class="show-void-modal" product-code="{{ $data->product_code }}" data-toggle="modal" data-target="#voidModal">&times;</a>
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

              <hr>

              <div class="row mt-2">

                <div class="col-lg-4">
                        <table class="table table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th>Total Amount Due</th>
                                  <th><input type="text" class="form-control peso-sign" id="total-amount-due" value="{{ $getTotalAmount }}" readonly></th>
                              </tr>
                              <tr>
                                  <th>Tendered</th>
                                  <th><input type="text" class="form-control peso-sign" id="tendered"></th>
                              </tr>
                              <tr>
                                  <th>Change</th>
                                  <th><input type="text" class="form-control peso-sign" id="change" readonly></th>
                              </tr>
                          </thead>
                      </table>
                </div>

              <div class="col-lg-1 mr-3">
                        <div class="form-check mt-1 mr-4  mb-2">
                          <input type="checkbox" class="form-check-input chk-discount" id="discount-chk">
                          <label class="form-check-label" for="exampleCheck1">Discount</label>
                        </div>
                        <div class="discount-option" style="display: none;">
                          <div class="form-check ml-2 mr-2 mt-1">
                            <input class="form-check-input" type="radio" name="radio-discount" id="radio-sc" value="sc" checked required>
                            <label class="form-check-label">
                              Senior Citizen
                            </label>
                          </div>
                          <div class="form-check mt-1 ml-2">
                            <input class="form-check-input" type="radio" name="radio-discount" id="radio-pwd" value="pwd" required>
                            <label class="form-check-label">
                              PWD
                            </label>
                          </div>
            
                        <p class="mt-1 ml-2">Less: ₱<span id="less-discount"></span></p>
                        </div>

                        <div class="payment-option">
                          <div class="form-check ml-2 mr-2 mt-1">
                            <input class="form-check-input" type="radio" name="radio-payment-option" id="radio-cash" value="cash" checked required>
                            <label class="form-check-label">
                              Cash
                            </label>
                          </div>
                          <div class="form-check mt-1 ml-2">
                            <input class="form-check-input" type="radio" name="radio-payment-option" id="radio-gcash" value="gcash" required>
                            <label class="form-check-label">
                              Gcash
                            </label>
                          </div>
                        </div>

                        <input type="hidden" class="form-control" name="sales-invoice" id="sales-invoice-no">

                        <div class="form-group ml-auto">
                          <button class="btn btn-success btn-sm btn-processs mt-2" style="font-size: 14px; width: 100px;"  id="btn-confirm-inv">Pay</button> 
                        </div>
              </div>

              <div class="col-lg-3" style="display: none;" id="img-gcash-qrcode">
                  <img src="{{ asset('assets/QR-code-gcash.png') }}" alt="" width="300px">
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