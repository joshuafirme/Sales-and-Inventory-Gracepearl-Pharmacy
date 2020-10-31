

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

