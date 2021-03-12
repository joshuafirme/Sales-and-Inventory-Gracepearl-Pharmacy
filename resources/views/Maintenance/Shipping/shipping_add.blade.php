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
   
        @elseif(\Session::has('danger'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-circle"></i> </h5>
            {{ \Session::get('danger') }}
          </div>
        @endif

        

        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addShipModal"><span class='fa fa-plus'></span> Add</button>

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"></p>
                    <table class="table table-hover" id="shipping-table">

                        <thead>
                            <tr>
                                <th>Municipality</th>
                                <th>Barangay</th>
                                <th>Shipping Fee</th>
                                <th width="10px">Action</th>
                            </tr>
                        </thead>
           
                        <tbody>                      
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


