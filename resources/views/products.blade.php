@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Products</h3>
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
                  <div class="row">

                     
  
             </div>
            </div>    
                    <table class="table responsive  table-hover" id="productsearch-table" width="100%">                               
                      <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Description</th>   
                            <th>Unit</th>        
                            <th>Quantity</th>
                            <th>Selling Price</th>
                            <th>Expiration</th>
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

@endsection

