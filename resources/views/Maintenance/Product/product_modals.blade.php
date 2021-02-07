<!--Add product Modal-->
@yield('modals')
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Add Product</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ action('Maintenance\ProductMaintenanceCtr@store') }}" method="POST" enctype="multipart/form-data">

          <div class="row">
            {{ csrf_field() }}

            <input type="hidden" id="discount_hidden">
            
            <div class="col-md-8">
              <label class="col-form-label">Description</label>
              <input type="text" class="form-control" name="description" id="description" required>
            </div>

            <div class="col-md-4 mb-2">    
              <label class="col-form-label">Unit</label>
              <select class="form-control" name="unitID" id="unitID">
                
                @foreach($unit as $data)
              <option value={{ $data->id }}>{{ $data->unit }}</option>
                @endforeach
              </select>
            </div>
  
            <div class="col-md-4 mb-2">    
              <label class="col-form-label">Category</label>
              <select class="form-control" name="category_name" id="category_name">
                
                @foreach($category as $data)
              <option value={{ $data->id }}>{{ $data->category_name }}</option>
                @endforeach
              </select>
            </div>
  
            <div class="col-md-4">
              <label class="col-form-label">Supplier</label>
              <select class="form-control" name="supplier_name" id="supplier_name">
                @foreach($suplr as $data)
               <option value={{ $data->id }}>{{ $data->supplierName }}</option>
                @endforeach
              </select>
            </div> 

            <div class="col-md-4">
              <label class="col-form-label">Quantity</label>
              <input type="number" min="1" class="form-control" name="qty" id="qty" required>
            </div>
  
            <div class="col-md-4  mb-2">
              <label class="col-form-label">Original Price</label>
              <input type="number" step=".01" min="0" max="9999999"  class="form-control" name="orig_price" id="orig_price" required>
            </div>
            
            <div class="col-md-4  mb-2">
              <label class="col-form-label">Markup</label>
              <input type="number" step=".01" min="0" max="9999999" class="form-control" name="markup" id="markup" required>
            </div>
            
            <div class="col-md-4">
              <label class="col-form-label">Selling Price</label>
              <input  type="text" step=".01" min="0" class="form-control orig_price" name="selling_price" id="selling_price" required>
            </div>
            
            <div class="col-md-4">
              <label class="col-form-label">Reorder Point</label>
              <input type="number" class="form-control" name="re_order" id="re_order" required>
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

            <div class="col-md-12 mt-3 with-prescription"  style="display: none">
              <label for="">With Presciption?</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="with_prescription" id="with_prescription" value="yes">
                <label class="form-check-label" for="add">
                  Yes
                </label>
                <input class="form-check-input ml-2" type="radio" name="with_prescription" id="no_prescription" value="no" checked>
                <label class="form-check-label ml-4" for="less">
                  No
                </label>
              </div>
            </div>
            
            <div class="col-md-12 mt-3">
              <label class="col-form-label">Highlights</label>
              <textarea type="text" class="form-control" name="highlights" id="highlights"></textarea>
            </div>

          </div>

      </div>
      <div class="modal-footer">

              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-sm btn-primary" id="btn-add-product">Save</button>
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
          <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
          <button class="btn btn-sm btn-outline-dark" type="button" name="ok_button" id="product_ok_button">Yes</button>
        <button class="btn btn-sm btn-danger cancel-delete" data-dismiss="modal">Cancel</button>

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
        <form method="POST" action="{{ action('Maintenance\ProductMaintenanceCtr@updateProduct') }}" enctype="multipart/form-data">
          <div class="row">
            {{ csrf_field() }}
            <input type="hidden" id="edit_discount_hidden">
            <input type="hidden" name="product_code_hidden" id="product_code_hidden">
            <input type="hidden" name="id_exp" id="id_exp">

            <div class="col-md-4 mb-2">
              <label class="col-form-label">Product Code</label>
              <input type="text" class="form-control"  name="edit_product_code" id="product_code" readonly>
            </div>
          
            <div class="col-md-4">
              <label class="col-form-label">Description</label>
              <input type="text" class="form-control"  name="edit_description" id="edit_description" required>
            </div>

            <div class="col-md-4 mb-2">    
              <label class="col-form-label">Unit</label>
              <select class="form-control edit_unit" name="edit_unit" >
                <option  id="edit_unit" selected></option>

                @foreach($unit as $data)
              <option value={{ $data->id }}>{{ $data->unit }}</option>
                @endforeach

              </select>
            </div>
  
            <div class="col-md-4 mb-2">    
              <label class="col-form-label">Category</label>
              <select class="form-control category_name" name="edit_category_name" >
                <option  id="edit_category_name" selected></option>

                @foreach($category as $data)
              <option value={{ $data->id }}>{{ $data->category_name }}</option>
                @endforeach

              </select>
            </div>
  
            <div class="col-md-4">
              <label class="col-form-label">Supplier</label>
              <select class="form-control supplier_name" name="edit_supplier_name">
                <option  id="edit_supplier_name" selected></option>

                @foreach($suplr as $data)
               <option value={{ $data->id }}>{{ $data->supplierName }}</option>
                @endforeach

              </select>
            </div> 

            <div class="col-md-4">
              <label class="col-form-label">Quantity</label>
              <input type="number" class="form-control" name="edit_qty" id="edit_qty" readonly>
            </div>
  
            <div class="col-md-4  mb-2">
              <label class="col-form-label">Original Price</label>
              <input type="number" step=".01" min="0" max="9999999" class="form-control" name="edit_orig_price" id="edit_orig_price" required>
            </div>

            <div class="col-md-4  mb-2">
              <label class="col-form-label">Markup</label>
              <input type="number" step=".01" min="0" max="9999999" class="form-control" name="edit_markup" id="edit_markup" required>
            </div>
            
            <div class="col-md-4">
              <label class="col-form-label">Selling Price</label>
              <input type="number" class="form-control orig_price" name="edit_selling_price" id="edit_selling_price" readonly>
            </div>
            
  
            <div class="col-md-4">
              <label class="col-form-label">Reorder Point</label>
              <input type="number" class="form-control" name="edit_re_order" id="edit_re_order" required>
            </div>

            <div class="col-md-4">
              <label class="col-form-label">Expiration Date</label>
              <input type="date" class="form-control" name="edit_exp_date" id="edit_exp_date" required>
            </div>


            <div class="col-md-4">
              <label class="col-form-label">Update Photo</label>
              <input  type="file" name="image">
            <div>{{ $errors->first('image') }}</div>
            </div> 

            <div class="col-md-12 mt-3 with-prescription"  style="display: none">
              <label for="">With Presciption?</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="edit_with_prescription" id="rdo_prescription_yes" value="yes">
                <label class="form-check-label" for="add">
                  Yes
                </label>
                <input class="form-check-input ml-2" type="radio" name="edit_with_prescription" id="rdo_prescription_no" value="no" checked>
                <label class="form-check-label ml-4" for="less">
                  No
                </label>
              </div>
            </div>

            <div class="col-md-4 mt-2">

              <img alt="no available image" style="width: 235px; max-heigth:300px;"  name="img_view" id="img_view">
            <div>{{ $errors->first('image') }}</div>
            </div> 


            <div class="col-md-12 mt-3">
              <label class="col-form-label">Highlights</label>
              <textarea type="text" class="form-control" name="edit_highlights" id="edit_highlights"></textarea>
            </div>
           
        </div>

        
        

      </div>
      <div class="modal-footer">
        
        <div class="update-success-validation mr-auto ml-3" style="display: none">
          <label class="label text-success">Product was successfully updated</label>    
        </div> 
        <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
              <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
              <button type="submit"  class="btn btn-sm btn-success">Update</button> 
      </div>
    </form>
    </div>
  </div>
</div>