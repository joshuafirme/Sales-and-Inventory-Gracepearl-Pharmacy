@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Markup Maintenance</h3>
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

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"></p>
                    <table class="table table-hover" id="markup-table">
                      @if(count($markup) > 0)
                        <thead>
                            <tr>
                                <th>Supplier Name</th>
                                <th>Markup</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
           
                        <tbody>
                            <tr>    
                              @foreach ($markup as $data)   
                              <input type="hidden" id="id" value={{ $data->id }}>
                              <td>{{ $data->supplierName }}</td>                                     
                              <td>{{ $data->markup }}</td>                                                           
                                <td>
                                  <a class="btn" id="btn-edit-markup" markup-id="{{ $data->id }}" data-toggle="modal" data-target="#editMarkupModal"><i class="fa fa-edit"></i></a>
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
    @extends('maintenance.markup.modals')
    @section('modals')
    @endsection

@endsection



