
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
      
      $('#btn-delete-suplr').click(function(){
          $.ajax({
              url: '/maintenance/supplier/'+ supplier_id,
              type: 'DELETE',
            
              beforeSend:function(){
                  $('#btn-delete-suplr').text('Deleting...');
                  $('.loader').css('display', 'inline');
         
              },
              success:function(data){
                  setTimeout(function(){
                      $('#confirmModal').modal('hide');
                      $( "#supplier-table" ).load( "supplier #supplier-table" );
                      $('.loader').css('display', 'none');
                      $('#btn-delete-suplr').text('Delete');
                  }, 1000);
              }
          });
        
      });
  
});


      //edit show
      $(document).on('click', '#btn-edit-supplier', function(){
        var id = $(this).attr('supplier-id');
        $('#edit_company').val('');
        console.log(id);
      
        $.ajax({
          url:"/maintenance/supplier/edit/"+id,
          type:"POST",
          data:{
              id:id
            },
    
          success:function(response){
              console.log(response);
            $('#edit_supplier_id').val(id);
            $('#edit_supplier_name').val(response[0].supplierName);
            $('#edit_address').val(response[0].address);
            $('#edit_email').val(response[0].email);
            $('#edit_person').val(response[0].person);
            $('#edit_contact').val(response[0].contact);
            
            $('#edit_company').text(response[0].company_name);
            $(".edit_company option[value="+response[0].companyID+"]").remove();
            $('#edit_company').val(response[0].companyID);
        
          }
         });
      }); 

  //update
  $(document).on('click', '#btn-update-supplier', function(){
    var id = $('#edit_supplier_id').val();
    var supplier_name = $('#edit_supplier_name').val();
    var address = $('#edit_address').val();
    var email = $('#edit_email').val();
    var person = $('#edit_person').val();
    var contact = $('#edit_contact').val();
    var company = $('select[name=edit_company] option').filter(':selected').val();
    console.log(company);

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
          email:email,
          person:person,
          contact:contact,
          company:company
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


   //add supplier
   $(document).on('click', '#btn-save-supplier', function(){
    var supplier_name = $('#supplier_name').val();
    var address = $('#address').val();
    var email = $('#email').val();
    var person = $('#person').val();
    var contact = $('#contact').val();
    var company = $('#company').val();

    console.log(supplier_name);
    console.log(address);
    console.log(person);
    console.log(contact);
    console.log(company);

    $.ajaxSetup({
        headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
     });

    $.ajax({
      url:"/maintenance/supplier/store",
      type:"POST",
      data:{
          supplier_name:supplier_name,
          address:address,
          person:person,
          email:email,
          contact:contact,
          company:company
        },

        beforeSend:function(){
            $('#btn-save-supplier').text('Saving...');
            $('.loader').css('display', 'inline');
          },
        success:function(response){
    
            setTimeout(function(){
                $('.update-success-validation').css('display', 'inline');
                $('#btn-save-supplier').text('Save');
                $('.loader').css('display', 'none');

                setTimeout(function(){
                $('.update-success-validation').fadeOut('slow')
                $( "#supplier-table" ).load( "supplier #supplier-table" );
           
                },2000);
            
            },1000);
        }
        });
  }); 


