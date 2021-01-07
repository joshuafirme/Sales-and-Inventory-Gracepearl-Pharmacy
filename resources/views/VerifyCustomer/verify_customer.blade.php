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
                
              <ul class="nav nav-tabs" id="myTab" role="tablist">

                <li class="nav-item">
                  <a class="nav-link  active" id="validation-tab" data-toggle="tab" href="#validationtab" role="tab" aria-controls="contact" aria-selected="true">For Validation
                 
                  </a>
                 </li>
                  <li class="nav-item">
                      <a class="nav-link" id="verified-tab" data-toggle="tab" href="#verifiedtab" role="tab" aria-controls="home" aria-selected="false">Verified
                    
                      </a>
                  </li>
                 
              </ul> 
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="validationtab" role="tabpanel" aria-labelledby="validation-tab">

                  <table class="table responsive  table-hover" id="for-validation-table" width="100%">                               
                    <thead>
                      <tr>
                        <th><input type="checkbox" name="select_all" value="1" id="select-all"></th>
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
                 <!-- <img src="('assets/arrow_ltr.png')}}" alt="">
                  <button class="btn btn-sm btn-success mt-3" id="btn-bulk-verified">Mark as verified</button>
                  <div class="update-success-validation mr-auto ml-3" style="display: none">
                    <label class="label text-success">Customer is successfully added validate</label>    
                  </div> 
                  <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">-->

                </div>

                <div class="tab-pane fade" id="verifiedtab" role="tabpanel" aria-labelledby="verified-tab">

                  <table class="table responsive  table-hover" id="verified-table" width="100%">                               
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

