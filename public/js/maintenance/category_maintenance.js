

$(document).ready(function(){

      // delete category alert
      var category_id, category_name;
      $(document).on('click', '#deleteCategory', function(){
        category_id = $(this).attr('delete-id');
        category_name =  $(this).closest("tr").find('td:eq(0)').text();
        $('#confirmModal').modal('show');
        $('.delete-category-message').html('Are you sure do you want to delete <b>'+category_name+'?</b>');
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
                  $('.loader').css('display', 'inline');
              },
              success:function(data){
                  setTimeout(function(){
                      $('#ok_button').text('Delete');
                      $('#confirmModal').modal('hide');
                      $( "#category-table" ).load( "category #category-table" );
                      $('.loader').css('display', 'none');
                  }, 1000);
              }
          });
        
      });



      //edit show
$(document).on('click', '#btn-edit-category-maintenance', function(){
    var id = $(this).attr('category-id');
    
    console.log(id);
  
    $.ajax({
      url:"/maintenance/category/edit/"+id,
      type:"POST",
      data:{
          id:id
        },

      success:function(response){
        $('#category_id').val(id);
        $('#edit_category_name').val(response[0].category_name);
      }
     });
  }); 
  
  //update
  $(document).on('click', '#btn-update-category', function(){
    var category_id = $('#category_id').val();
    var category_name = $('#edit_category_name').val();
  
    console.log(category_id);
    console.log(category_name);

    $.ajaxSetup({
        headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
     });

    $.ajax({
      url:"/maintenance/category/update/"+category_id,
      type:"POST",
      data:{
        category_name:category_name
        },

        beforeSend:function(){
            $('#btn-update-category').text('Updating...');
            $('.loader').css('display', 'inline');
          },
        success:function(response){
    
            setTimeout(function(){
                $('.update-success-validation').css('display', 'inline');
                $('.loader').css('display', 'none');
                $('#btn-update-category').text('Update');
                setTimeout(function(){
                $('.update-success-validation').fadeOut('slow')
                $( "#category-table" ).load( "category #category-table" );
          
                },2000);
            
            },1000);
        }
        });
  }); 

  
  
});

