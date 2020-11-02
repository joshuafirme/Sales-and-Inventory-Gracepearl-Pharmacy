@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Supplier Maintenance</h3>
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

          <div class="col-sm-6  col-lg-12 mb-3">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addSupplierModal"><span class='fa fa-plus'></span> Add Supplier</button> 
            </div>

            <div class="col-md-12 col-lg-12">

           <div class="card">
            <div class="card-body">

              <div class="row">
              <div class="input-group col-sm-4 col-md-3 mt-4 ml-auto mb-3">
                <input class="form-control" type="search" id="example-search-input" placeholder="search">
                <span class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button">
                      <i class="fa fa-search"></i>
                  </button>
                </span>
             </div>
            </div>

                    <table class="table table-hover" id="supplier-table" width="100%">
                      @if(count($suplr) > 0)
                        <thead>
                            <tr>
                                <th>Supplier ID</th>
                                <th>Supplier Name</th>
                                <th>Address</th>
                                <th>Person</th>
                                <th>Contact</th>
                                <th style="width: 12%;">Action</th>
                            </tr>
                        </thead>
                 
                        <tbody>
                            <tr>    
                              @foreach ($suplr as $data)                        
                              <td>{{ $data->supplierID }}</td>
                              <td>{{ $data->supplierName }}</td>
                              <td>{{ $data->address }}</td>
                              <td>{{ $data->person }}</td>
                              <td>{{ $data->contact }}</td>  
                              <td>
                               <a class="btn" id="btn-edit-supplier" supplier-id="{{ $data->id }}" data-toggle="modal" data-target="#editSupplierModal"><i class="fa fa-edit"></i></a>
                          
                                <a class="btn" id="delete-supplier" delete-id="{{ $data->id }}"><i class="fa fa-trash"></i></a>
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
                    <div class="pl-2">
                      {{ $suplr->links() }}
                  </div>
                </div>
            </div>

        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @extends('maintenance.supplier.supplier_modals')
@section('modals')
@endsection
@endsection


