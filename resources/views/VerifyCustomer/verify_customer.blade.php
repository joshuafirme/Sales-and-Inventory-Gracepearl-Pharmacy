@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Verify Customer</h3>
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
        <div class="col-md-12 col-lg-12">

          <div class="card">
            <div class="card-body">
                <div class="container-fluid">
   
                </div>    
                    <table class="table responsive  table-hover" id="verify-customer-table" width="100%">                               
                      <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Fullname</th>   
                            <th>Phone Number</th>   
                            <th>Email</th>   
                            <th>ID Type</th>   
                            <th>ID Number</th>        
                            <th>Status</th>   
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

    @extends('verifycustomer.modals')
    @section('verifyCustomerModal')
    @endsection

@endsection

