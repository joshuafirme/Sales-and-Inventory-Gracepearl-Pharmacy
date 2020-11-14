@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Company Maintenance</h3>
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

        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCompanyModal"><span class='fa fa-plus'></span> Add Company</button>

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"></p>
                    <table class="table table-hover" id="company-table">
                      @if(count($company) > 0)
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Markup</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
           
                        <tbody>
                            <tr>    
                              @foreach ($company as $data)   
                              <input type="hidden" id="id" value={{ $data->id }}>
                              <td>{{ $data->company_name }}</td>                                     
                              <td>{{ $data->markup }}</td>                                                           
                                <td>
                                  <a class="btn" id="btn-edit-company" company-id="{{ $data->id }}" data-toggle="modal" data-target="#editCompanyModal"><i class="fa fa-edit"></i></a>
                                  <a class="btn" name="id" id="deleteCompany" delete-id="{{ $data->id }}"><i class="fa fa-trash"></i></a>
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
    @extends('maintenance.company.modals')
    @section('modals')
    @endsection

@endsection



