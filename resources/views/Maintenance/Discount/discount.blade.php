@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Discount Maintenance</h3>
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

          <div class="col-sm-2 col-md-4 col-lg-4 mt-3">
            <div class="card">
            
                <div class="card-body">
                  @if(\Session::has('success'))
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> </h5>
                    {{ \Session::get('success') }}
                  </div>
                  @endif
                <form method="POST" action="{{ action('Maintenance\DiscountCtr@activate') }}">
                    {{ csrf_field() }}                  <small class="form-text text-muted">0.01 is equal to 1% discount.</small>
                        <div class="form-group">
                          <label for="discount">Senior Citizen</label>
                          <input type="number" step="0.01" min="0.01" max="1.0" class="form-control" name="sc-discount" id="sc-discount" value={{ number_format($sc_discount, 2,'.',',') }}>
        
                        </div> 
                        
                        <div class="form-group">
                          <label for="discount">PWD</label>
                          <input type="number" step="0.01" min="0.01" max="1.0" class="form-control" name="pwd-discount" id="pwd-discount" value={{ number_format($pwd_discount, 2,'.',',') }}>
                        </div>  
                        <button type="submit" class="btn btn-sm btn-success" id="btn-activate">Activate</button>
                      </form>
                  
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @extends('maintenance.category.category_modals')
    @section('modals')
    @endsection

@endsection


