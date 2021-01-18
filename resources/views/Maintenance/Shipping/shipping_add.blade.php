@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Shipping Address Maintenance</h3>
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

        

        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addShipModal"><span class='fa fa-plus'></span> Add</button>

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"></p>
                    <table class="table table-hover" id="company-table">
                      @if(count($shippingAdd) > 0)
                        <thead>
                            <tr>
                                <th>Municipality</th>
                                <th>Barangay</th>
                                <th>Shipping Fee</th>
                                <th width="10px">Action</th>
                            </tr>
                        </thead>
           
                        <tbody>
                            <tr>    
                              @foreach ($shippingAdd as $data)   
                              <input type="hidden" id="id" value={{ $data->id }}>
                              <td>{{ $data->municipality }}</td>                                     
                              <td>{{ $data->brgy }}</td>  
                              @if($data->shipping_fee == 0)     
                              <td><span class="text-success">Free</span></td> 
                              @else
                              <td>{{ $data->shipping_fee }}</td> 
                              @endif
                                <td>
                                  <a class="btn btn-sm" id="btn-edit-company" ship-id="{{ $data->id }}" data-toggle="modal" data-target="#editCompanyModal"><i class="fa fa-edit"></i></a>
                                  <a class="btn btn-sm" name="id" id="deleteCompany" delete-id="{{ $data->id }}"><i style="color:#DC3545;" class="fa fa-trash"></i></a>
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

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @extends('maintenance.shipping.modals')
    @section('modals')
    @endsection

@endsection


