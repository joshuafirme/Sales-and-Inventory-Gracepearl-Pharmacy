

$(document).ready(function(){

    // delete unit alert
    var id;
    $(document).on('click', '#deleteUnit', function(){
      id = $(this).attr('delete-id');
      var unit =  $(this).closest("tr").find('td:eq(0)').text();
      $('#confirmModal').modal('show');
      $('.delete-unit-message').html('Are you sure do you want to delete <b>'+ unit +'?</b>');
    }); 
    
    $.ajaxSetup({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
    
    $('#ok_button').click(function(){
        $.ajax({
            url: '/maintenance/unit/'+ id,
            type: 'POST',
          
            beforeSend:function(){
                $('#ok_button').text('Deleting...');
                $('.loader').css('display', 'inline');
            },
            success:function(data){
                setTimeout(function(){
                    $('#ok_button').text('Delete');
                    $('#confirmModal').modal('hide');
                    $( "#unit-table" ).load( "unit #unit-table" );
                    $('.loader').css('display', 'none');
                }, 1000);
            }
        });
      
    });



    //edit show
$(document).on('click', '#btn-edit-unit', function(){
  var id = $(this).attr('unit-id');
  
  $.ajax({
    url:"/maintenance/unit/edit/"+id,
    type:"POST",
    data:{
        id:id
      },

    success:function(response){
      $('#edit_id').val(response[0].id);
      $('#edit_unit').val(response[0].unit);
      console.log(response[0].id);
      console.log(response[0].unit);
    }
   });
}); 

//update
$(document).on('click', '#btn-update-unit', function(){
  var id = $('#edit_id').val();
  var unit = $('#edit_unit').val();


  $.ajaxSetup({
      headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
   });

  $.ajax({
    url:"/maintenance/unit/update/"+id,
    type:"POST",
    data:{
        unit:unit
      },

      beforeSend:function(){
          $('#btn-update-unit').text('Updating...');
          $('.loader').css('display', 'inline');
        },
      success:function(response){
  
          setTimeout(function(){
              $('.update-success-validation').css('display', 'inline');
              $('.loader').css('display', 'none');
              $('#btn-update-unit').text('Update');
              setTimeout(function(){
              $('.update-success-validation').fadeOut('slow')
              $( "#unit-table" ).load( "unit #unit-table" );
        
              },1000);
          
          },1000);
      }
      });
}); 



});

