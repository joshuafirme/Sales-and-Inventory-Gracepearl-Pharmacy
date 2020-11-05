

$(document).ready(function(){

    //edit show
$(document).on('click', '#btn-edit-markup', function(){
  var id = $(this).attr('markup-id');
  
  console.log(id);

  $.ajax({
    url:"/maintenance/markup/edit/"+id,
    type:"POST",
    data:{
        id:id
      },

    success:function(response){
      $('#id').val(id);
      $('#edit_supplier_name').val(response[0].supplierName);
      $('#edit_markup').val(response[0].markup);
    }
   });
}); 

//update
$(document).on('click', '#btn-update-markup', function(){
  var id = $('#id').val();
  var markup = $('#edit_markup').val();

  console.log(id);
  console.log(markup);

  $.ajaxSetup({
      headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
   });

  $.ajax({
    url:"/maintenance/markup/update/"+id,
    type:"POST",
    data:{
        markup:markup
      },

      beforeSend:function(){
          $('#btn-update-markup').text('Updating...');
          $('.loader').css('display', 'inline');
        },
      success:function(response){
  
          setTimeout(function(){
              $('.update-success-validation').css('display', 'inline');
              $('.loader').css('display', 'none');
              $('#btn-update-markup').text('Update');
              setTimeout(function(){
              $('.update-success-validation').fadeOut('slow')
              $( "#markup-table" ).load( "markup #markup-table" );
        
              },2000);
          
          },1000);
      }
      });
}); 



});

