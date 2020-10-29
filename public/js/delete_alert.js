
var supplier_id, supplier_name;
$(document).ready(function(){

      
         // delete supplier alert
    $(document).on('click', '#deleteSupplier', function(){
        supplier_id = $(this).attr('delete-id');
        supplier_name =  $(this).closest("tr").find('td:eq(1)').text();
        $('#confirmModal').modal('show');
        $('.delete-suplr-confirm').text('Are you sure do you want to delete '+ supplier_name +'?');
      }); 
      
      $.ajaxSetup({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      
      $('#ok_button').click(function(){
          $.ajax({
              url: '/maintenance/supplier/'+ supplier_id,
              type: 'DELETE',
            
              beforeSend:function(){
                  $('#ok_button').text('Deleting...');
              },
              success:function(data){
                  setTimeout(function(){
                      $('#confirmModal').modal('hide');
                      $( "#supplier-table" ).load( "supplier #supplier-table" );
                     
                  }, 1000);
              }
          });
        
      });


        


      // delete category alert
      var category_id, category_name;
      $(document).on('click', '#deleteCategory', function(){
        category_id = $(this).attr('delete-id');
        category_name =  $(this).closest("tr").find('td:eq(0)').text();
        $('#confirmModal').modal('show');
        $('.delete-category-message').text('Are you sure do you want to delete '+category_name+'?');
      }); 
      
      $.ajaxSetup({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      
      $('#ok_button').click(function(){
          $.ajax({
              url: '/maintenance/category/'+ category_id,
              type: 'DELETE',
            
              beforeSend:function(){
                  $('#ok_button').text('Deleting...');
              },
              success:function(data){
                  setTimeout(function(){
                      $('#ok_button').text('Delete');
                      $('#confirmModal').modal('hide');
                      $( "#category-table" ).load( "category #category-table" );
                     
                  }, 1000);
              }
          });
        
      });
  
});

