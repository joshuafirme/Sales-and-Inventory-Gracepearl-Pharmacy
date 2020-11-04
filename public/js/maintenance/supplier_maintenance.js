
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
                  $('.loader').css('display', 'inline');
         
              },
              success:function(data){
                  setTimeout(function(){
                      $('#confirmModal').modal('hide');
                      $( "#supplier-table" ).load( "supplier #supplier-table" );
                      $('.loader').css('display', 'none');
                  }, 1000);
              }
          });
        
      });
  
});


      //edit show
      $(document).on('click', '#btn-edit-supplier', function(){
        var id = $(this).attr('supplier-id');
        
        console.log(id);
      
        $.ajax({
          url:"/maintenance/supplier/edit/"+id,
          type:"POST",
          data:{
              id:id
            },
    
          success:function(response){
              console.log(response);
            $('#supplier_id').val(id);
            $('#edit_supplier_name').val(response[0].supplierName);
            $('#edit_address').val(response[0].address);
            $('#edit_person').val(response[0].person);
            $('#edit_contact').val(response[0].contact);
          }
         });
      }); 

  //update
  $(document).on('click', '#btn-update-supplier', function(){
    var id = $('#supplier_id').val();
    var supplier_name = $('#edit_supplier_name').val();
    var address = $('#edit_address').val();
    var person = $('#edit_person').val();
    var contact = $('#edit_contact').val();


    $.ajaxSetup({
        headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
     });

    $.ajax({
      url:"/maintenance/supplier/update",
      type:"POST",
      data:{
          id:id,
          supplier_name:supplier_name,
          address:address,
          person:person,
          contact:contact
        },

        beforeSend:function(){
            $('#btn-update-supplier').text('Updating...');
            $('.loader').css('display', 'inline');
          },
        success:function(response){
    
            setTimeout(function(){
                $('.update-success-validation').css('display', 'inline');
                $('#btn-update-supplier').text('Update');
                $('.loader').css('display', 'none');

                setTimeout(function(){
                $('.update-success-validation').fadeOut('slow')
                $( "#supplier-table" ).load( "supplier #supplier-table" );
           
                },2000);
            
            },1000);
        }
        });
  }); 


