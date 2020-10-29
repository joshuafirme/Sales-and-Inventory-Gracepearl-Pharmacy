@extends('layouts.admin')
@section('content')

<div class="page-header">
    <h3 class="mt-2" id="page-title">Update Product</h3>
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
         
            <div class="card ml-3 mt-3" style="width: 50%">
             
                <div class="card-body">
                  
                

                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="container-fluid">
                          <div class="row">
                            {{ csrf_field() }}   
                          
                            @foreach ($product as $products)
                            <div class="col-md-8">
                              <label class="col-form-label">Description</label>
                              <input type="text" class="form-control"  name="description"  value={{ $products->description }} required>
                            </div>
                  
                            <div class="col-md-4 mb-2">    
                              <label class="col-form-label">Category</label>
                              <select class="form-control category_name" name="category_name" >
                
                                @foreach ($category as $categories)
                              <option >{{ $categories->category_name }}</option>
                                @endforeach
                
                              </select>
                            </div>
                  
                            <div class="col-md-4">
                              <label class="col-form-label">Supplier</label>
                              <select class="form-control" name="supplierID">
                                <option id="edit_supplier_name"></option>
                
                            
                
                              </select>
                            </div> 
                
                            <div class="col-md-4">
                              <label class="col-form-label">Quantity</label>
                              <input type="text" class="form-control" name="qty" id="edit_qty" {{ $products->qty }} required>
                            </div>
                  
                            <div class="col-md-4">
                              <label class="col-form-label">Re-Order Point</label>
                              <input type="text" class="form-control" name="re_order" id="edit_re_order" required>
                            </div>
                  
                            <div class="col-md-4  mb-2">
                              <label class="col-form-label">Original Price</label>
                              <input type="text" class="form-control" name="orig_price" id="edit_orig_price" required>
                            </div>
                            
                            <div class="col-md-4">
                              <label class="col-form-label">Selling Price</label>
                              <input type="text" class="form-control orig_price" name="selling_price" id="edit_selling_price" required>
                            </div>
                
                            <div class="col-md-4">
                              <label class="col-form-label">Expiration Date</label>
                              <input type="date" class="form-control" name="exp_date" id="edit_exp_date" required>
                            </div>
                
                            <div class="col-md-4">
                            <img width="100px"  alt="No image" class="img-thumbnail" id="edit_img_view">
                            </div> 
                
                            <div class="col-md-4">
                              <label class="col-form-label">Upload Photo</label>
                              <input type="file"  name="image" id="edit_image">
                            <div>{{ $errors->first('image') }}</div>
                            </div> 
                   
                            
                          </div>
                        </div>  
                
                      </div>
                    </form>
                        @endforeach
                       
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