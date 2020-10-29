@extends('layouts.admin')
@section('content')

<div class="page-header">
    <h3 class="mt-2" id="page-title">Update Supplier</h3>
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
         
            <div class="card ml-3 mt-3" style="width: 40%">
                <div class="card-body">
                  
                    @foreach ($suplr as $data)

                <form action="/maintenance/supplier/update/{{ $data->id }}" method="POST">
                        {{ csrf_field() }}
                          <div class="form-group">
                            <label class="col-form-label">Supplier Name</label>
                            <input type="text" class="form-control" name="supplierName" id="supplierName" value={{ $data->supplierName }} required>
                          </div>
                
                          <div class="form-group">
                            <label class="col-form-label">Address</label>
                            <textarea class="form-control" name="address" id="address" required>{{ $data->address }}</textarea>
                          </div>
                
                          <div class="form-group">
                            <label class="col-form-label">Person</label>
                            <input type="text" class="form-control" name="person" value={{ $data->person }} id="person" required>
                          </div>
                
                          <div class="form-group">
                            <label class="col-form-label">Contact</label>
                            <input type="text" class="form-control" name="contact" value={{ $data->contact }} id="contact" required>
                          </div>

                          @endforeach 
                          
                          <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>  
                        
                       
                      </div>
                    
                </div>
            </div>

        <!-- /.row (main row) -->
      </div>
      <!-- /.container-fluid -->
      </div>
    </section>
    <!-- /.content -->
@endsection