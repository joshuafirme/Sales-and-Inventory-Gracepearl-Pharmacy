
var supplier_id, supplier_name;
$(document).ready(function(){

      
         // delete supplier alert
    $(document).on('click', '#delete-supplier', function(){
        supplier_id = $(this).attr('delete-id');
        supplier_name =  $(this).closest("tr").find('td:eq(1)').text();
        $('#confirmModal').modal('show');
        $('.delete-suplr-confirm').html('Are you sure do you want to delete <b>'+ supplier_name +'</b> supplier?');
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


  
});

