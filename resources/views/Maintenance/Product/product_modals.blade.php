<!--Add product Modal-->
@yield('modals')
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ action('ProductMaintenanceCtr@store') }}" method="POST" enctype="multipart/form-data">
        <div class="container-fluid">
          <div class="row">
            {{ csrf_field() }}

  
            <div class="col-md-8">
              <label class="col-form-label">Description</label>
              <input type="text" class="form-control" name="description" id="description" required>
            </div>
  
            <div class="col-md-4 mb-2">    
              <label class="col-form-label">Category</label>
              <select class="form-control" name="categoryID" id="categoryID">
                
                @foreach($category as $data)
              <option value={{ $data->id }}>{{ $data->category_name }}</option>
                @endforeach
              </select>
            </div>
  
            <div class="col-md-4">
              <label class="col-form-label">Supplier</label>
              <select class="form-control" name="supplierID" id="supplierID">
                @foreach($suplr as $data)
               <option value={{ $data->id }}>{{ $data->supplierName }}</option>
                @endforeach
              </select>
            </div> 

            <div class="col-md-4">
              <label class="col-form-label">Quantity</label>
              <input type="number" min="1" class="form-control" name="qty" id="qty" required>
            </div>
  
            <div class="col-md-4">
              <label class="col-form-label">Re-Order Point</label>
              <input type="number" class="form-control" name="re_order" id="re_order" required>
            </div>
  
            <div class="col-md-4  mb-2">
              <label class="col-form-label">Original Price</label>
              <input type="number" min="1"  class="form-control" name="orig_price" id="orig_price" required>
            </div>
            
            <div class="col-md-4">
              <label class="col-form-label">Selling Price</label>
              <input type="number" min="1"  class="form-control orig_price" name="selling_price" id="selling_price" required>
            </div>

            <div class="col-md-4">
              <label class="col-form-label">Expiration Date</label>
              <input type="date" class="form-control" name="exp_date" id="exp_date" required>
            </div>

            <div class="col-md-4">
              <label class="col-form-label">Upload Photo</label>
              <input type="file"  name="image" id="image">
            <div>{{ $errors->first('image') }}</div>
            </div> 
            
          </div>
        </div>  

      </div>
      <div class="modal-footer">

              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-sm btn-primary mr-4">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>


  <!--Confirm Modal-->
  <div class="modal fade" id="proconfirmModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="delete-message"></p>
        </div>
        <div class="delete-success" style="display: none;">
          <span style="margin-left:180px;" class="text-success">Deleted Successfully!</span>
          </div>
        <div class="modal-footer">
         
          <button class="btn btn-sm btn-default cancel-delete" data-dismiss="modal">Cancel</button>
          <button class="btn btn-sm btn-danger" type="button" name="ok_button" id="product_ok_button">Yes</button>

        </div>
      </div>
    </div>
  </div>


  <!-- Edit Modal -->
  @yield('editproductmodal')
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="container-fluid">
          <div class="row">
            {{ csrf_field() }}

            <input type="hidden" id="product_code_hidden">

            <div class="col-md-8 mb-2">
              <label class="col-form-label">Product Code</label>
              <input type="text" class="form-control"  name="product_code" id="product_code" readonly>
            </div>
          
            <div class="col-md-8">
              <label class="col-form-label">Description</label>
              <input type="text" class="form-control"  name="description" id="edit_description" required>
            </div>
  
            <div class="col-md-4 mb-2">    
              <label class="col-form-label">Category</label>
              <select class="form-control category_name" name="category_name" >
                <option  id="edit_category_name" selected></option>

                @foreach($category as $data)
              <option value={{ $data->id }}>{{ $data->category_name }}</option>
                @endforeach

              </select>
            </div>
  
            <div class="col-md-4">
              <label class="col-form-label">Supplier</label>
              <select class="form-control supplier_name" name="supplier_name">
                <option  id="edit_supplier_name" selected></option>

                @foreach($suplr as $data)
               <option value={{ $data->id }}>{{ $data->supplierName }}</option>
                @endforeach

              </select>
            </div> 

            <div class="col-md-4">
              <label class="col-form-label">Quantity</label>
              <input type="number" class="form-control" name="qty" id="edit_qty" readonly>
            </div>
  
            <div class="col-md-4">
              <label class="col-form-label">Re-Order Point</label>
              <input type="number" class="form-control" name="re_order" id="edit_re_order" required>
            </div>
  
            <div class="col-md-4  mb-2">
              <label class="col-form-label">Original Price</label>
              <input type="number" class="form-control" name="orig_price" id="edit_orig_price" required>
            </div>

            <input type="hidden" id="discount_hidden">
            
            <div class="col-md-4">
              <label class="col-form-label">Selling Price</label>
              <input type="number" class="form-control orig_price" name="selling_price" id="edit_selling_price" readonly>
            </div>

            <div class="col-md-4">
              <label class="col-form-label">Expiration Date</label>
              <input type="date" class="form-control" name="exp_date" id="edit_exp_date" required>
            </div>


            <div class="col-md-4">
              <label class="col-form-label">Update Photo</label>
              <input type="file"   name="image" id="edit_image">
            <div>{{ $errors->first('image') }}</div>
            </div> 

           

       
   
            
          </div>
        </div>  

      </div>
      <div class="modal-footer">
        
        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">Product was successfully updated</label>    
        </div> 
              <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
              <button type="submit" id="update-product-maintenance" class="btn btn-sm btn-success mr-4">Update</button>
      </div>

    </div>
  </div>
</div>