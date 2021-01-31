
<!-- Add supplier modal -->
@yield('modals')
<div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Add Supplier</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                          {{ csrf_field() }}
                          <input type="hidden" id="supplier_id">
    
                          <div class="col-md-4">
                            <label class="col-form-label">Supplier Name</label>
                            <input type="text" class="form-control" name="supplier_name" id="supplier_name" required>
                          </div>
              
                  
                          <div class="col-md-4 mb-2">   
                              <label class="col-form-label">Address</label>
                              <input class="form-control" name="address" id="address" required>
                           
                           </div>
    
                           <div class="col-md-4 mb-2">  
                            <div class="form-group">
                              <label class="col-form-label">Email</label>
                              <input type="email" class="form-control" name="address" id="email" required>
                            </div>
                          </div>
              
                            <div class="col-md-4 mb-2">  
                            <div class="form-group">
                              <label class="col-form-label">Person</label>
                              <input type="text" class="form-control" name="person" id="person" required>
                            </div>
                          </div>
                  
                            <div class="col-md-4 mb-2">  
                            <div class="form-group">
                              <label class="col-form-label">Contact</label>
                              <input type="text" class="form-control" name="contact" id="contact" required>
                            </div>
                          </div>
                            
                      </div>         
                      

                    </div>
                    <div class="modal-footer">
                      <div class="update-success-validation mr-auto ml-3" style="display: none">
                        <label class="label text-success">Supplier was successfully added</label>    
                    </div> 
                    <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
                      <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-sm btn-primary" id="btn-save-supplier">Save</button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- edit modal -->
              <div class="modal fade" id="editSupplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Supplier</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
              
          
                      {{ csrf_field() }}

                        <input type="hidden" id="edit_supplier_id">

                        <div class="row">

                          <div class="col-md-4">
                            <label class="col-form-label">Supplier Name</label>
                            <input type="text" class="form-control" name="supplier_name" id="edit_supplier_name" required>
                          </div>
              
                  
                          <div class="col-md-4 mb-2">   
                              <label class="col-form-label">Address</label>
                              <input class="form-control" name="address" id="edit_address" required>
                           
                           </div>
    
                           <div class="col-md-4 mb-2">  
                            <div class="form-group">
                              <label class="col-form-label">Email</label>
                              <input type="email" class="form-control" name="address" id="edit_email" required>
                            </div>
                          </div>
              
                            <div class="col-md-4 mb-2">  
                            <div class="form-group">
                              <label class="col-form-label">Person</label>
                              <input type="text" class="form-control" name="person" id="edit_person" required>
                            </div>
                          </div>
                  
                            <div class="col-md-4 mb-2">  
                            <div class="form-group">
                              <label class="col-form-label">Contact</label>
                              <input type="text" class="form-control" name="contact" id="edit_contact" required>
                            </div>
                          </div>
                          

                        </div>

                        
                    </div>
                    <div class="modal-footer">
                      <div class="update-success-validation mr-auto ml-3" style="display: none">
                        <label class="label text-success">Product was successfully updated</label>    
                      </div> 
                      <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-sm btn-success" id="btn-update-supplier">Update</button>
                    </div>
                
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
                      <img src="../../assets/loader.gif" class="loader" alt="loader" style="display: none">
                      <button class="btn btn-sm btn-outline-dark" type="button" name="ok_button" id="btn-delete-suplr">Yes</button>
                      <button class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>

