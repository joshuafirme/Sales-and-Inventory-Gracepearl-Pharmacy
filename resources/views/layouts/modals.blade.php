
<!-- Add supplier modal -->
@yield('addsuppliermodal')
<div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Add Supplier</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
              
                    <form action="{{ action('SupplierMaintenanceCtr@store') }}" method="POST">
                      {{ csrf_field() }}

                        <div class="form-group">
                          <label class="col-form-label">Supplier Name</label>
                          <input type="text" class="form-control" name="supplierName" id="supplierName" required>
                        </div>
              
                        <div class="form-group">
                          <label class="col-form-label">Address</label>
                          <textarea class="form-control" name="address" id="address" required></textarea>
                        </div>
              
                        <div class="form-group">
                          <label class="col-form-label">Person</label>
                          <input type="text" class="form-control" name="person" id="person" required>
                        </div>
              
                        <div class="form-group">
                          <label class="col-form-label">Contact</label>
                          <input type="text" class="form-control" name="contact" id="contact" required>
                        </div>         
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </form>
                  </div>
                </div>
              </div>

              <!--Confirm Modal-->
              <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Confirmation</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="delete-suplr-confirm"></p>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-danger" type="button" name="ok_button" id="ok_button">Ok</button>
                      <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>

<!--add category Modal-->
              @yield('addcategorymodal')
              <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
              
                    <form action="{{ action('CategoryMaintenanceCtr@store') }}" method="POST">
                      {{ csrf_field() }}
                        <div class="form-group">
                          <label class="col-form-label">Category Name</label>
                          <input type="text" class="form-control" name="category_name" id="category_name" required>
                        </div>
                
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </form>
                  </div>
                </div>
              </div>

              <!--Confirm Modal-->
              <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Confirmation</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="delete-suplr-confirm"></p>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-danger" type="button" name="ok_button" id="ok_button">Ok</button>
                      <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>