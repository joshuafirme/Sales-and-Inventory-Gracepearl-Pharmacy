

$(document).ready(function(){
  
 // delete 
 var company_id, company_name;
 $(document).on('click', '#deleteCompany', function(){
  company_id = $(this).attr('delete-id');
  company_name =  $(this).closest("tr").find('td:eq(0)').text();
   $('#confirmModal').modal('show');
   $('.delete-company-message').html('Are you sure do you want to delete <b>'+company_name+'?</b>');
 }); 
 
 $.ajaxSetup({
     headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
 
 $('#ok_button').click(function(){
     $.ajax({
         url: '/maintenance/company/destroy/'+ company_id,
         type: 'DELETE',
       
         beforeSend:function(){
             $('#ok_button').text('Deleting...');
             $('.loader').css('display', 'inline');
         },
         success:function(data){
             setTimeout(function(){
                 $('#ok_button').text('Delete');
                 $('#confirmModal').modal('hide');
                 $( "#company-table" ).load( "company #company-table" );
                 $('.loader').css('display', 'none');
             }, 1000);
         }
     });
   
 });
    //edit show
$(document).on('click', '#btn-edit-company', function(){
  var id = $(this).attr('company-id');
  
  console.log(id);

  $.ajax({
    url:"/maintenance/company/edit/"+id,
    type:"POST",
    data:{
        id:id
      },

    success:function(response){
      $('#id').val(id);
      $('#edit_company_name').val(response[0].company_name);
      $('#edit_markup').val(response[0].markup);
      console.log(response[0].markup);
    }
   });
}); 

//update
$(document).on('click', '#btn-update-company', function(){
  var id = $('#id').val();
  var company_name = $('#edit_company_name').val();
  var markup = $('#edit_markup').val();

  console.log(id);
  console.log(company_name);


  $.ajax({
    url:"/maintenance/company/update/"+id,
    type:"POST",
    data:{
        company_name:company_name,
        markup:markup
      },

      beforeSend:function(){
          $('#btn-update-company').text('Updating...');
          $('.loader').css('display', 'inline');
        },
      success:function(response){
  
          setTimeout(function(){
              $('.update-success-validation').css('display', 'inline');
              $('.loader').css('display', 'none');
              $('#btn-update-company').text('Update');
              
              setTimeout(function(){
              $('.update-success-validation').fadeOut('slow')
              $( "#company-table" ).load( "company #company-table" );
        
              },2000);
          
          },1000);
      }
      });
}); 



});

