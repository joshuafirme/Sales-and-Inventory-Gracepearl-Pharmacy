
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      fetch_users();

      function fetch_users(){
        $('#emp-table').DataTable({
        
           processing: true,
           serverSide: true,
           ajax: '/path/to/script',
           scrollY: 470,
           scroller: {
               loadingIndicator: true
           },
          
           ajax:"/maintenance/user/displayuser",
               
           columns:[       
            {data: 'empID', name: 'empID'},
            {data: 'name', name: 'name'},
            {data: 'position', name: 'position'},
            {data: 'username', name: 'username'},
            {data: 'auth_modules', name: 'auth_modules',orderable: false},
            {data: 'action', name: 'action',orderable: false}
           ]
          });
     
       }
  
   $('#confirm_password').blur(function(){
     
    var password = $('#password').val();
    var confirm_password = $('#confirm_password').val();

    validatePassword(password, confirm_password);
   });

   $('#edit_confirm_password').blur(function(){
     
    var password = $('#edit_password').val();
    var confirm_password = $('#edit_confirm_password').val();

    validatePassword(password, confirm_password);
   });


   function validatePassword(password, confirm_password) {
    if(password.replace(/ /g,'').length >= 6){
        if(password == confirm_password){
            return true;
        }
        else{
            alert('Password do not match!');
        }
    }
    else{
        alert('Minimum of 6 characters!');
        $('#password').val('');
        $('#confirm_password').val('');
        $('#edit_password').val('');
        $('#edit_confirm_password').val('');
    }
}

   
   

  //edit show
  $(document).on('click', '#btn-edit-user', function(){
    var empID = $(this).attr('emp-id');

    $("#edit_position").val('');
    $("#edit_position").text('');
      
    uncheckCheckboxModules(); 
    
    $.ajax({
      url:"/maintenance/user/show/"+ empID,
      type:"POST",

      success:function(response){
        console.log(response);
        $('#edit_empID_hidden').val(response[0].id);
        $('#edit_empID').val(response[0].empID);
        $('#edit_employee_name').val(response[0].name);

        $('#edit_position').append('<option selected value="' + response[0].position + '">' + response[0].position + '</option>');
        populateCheckbox();

    //    $("#edit_position option[value="+response[0].position+"]").remove();  
        $('#edit_username').val(response[0].username);
        $('#edit_password').val(response[0].password);

        var modules_arr = response[0].auth_modules.split(', ');
        console.log(modules_arr);


        for(var i = 0; i < modules_arr.length; i++)
        {
          $('#edit_chk-'+modules_arr[i].replace(/\s/g, '')).prop('checked', true);  
        }

        $('#edit_chk-Utilities').attr("disabled", false);
        if(response[0].position == 'Administrator') // disabled user checkbox if edit admin modal is show
        {
          $('#edit_chk-Utilities').attr("disabled", true);
        }    
      }
    });
  }); 

  
  function populateCheckbox(){
    var data =  [
      'Cashier', 'Purchaser', 'Pharmacy Assistant', 'Certified Pharmacy Assistant', 'Administrator'
    ];

      for (var i = 0; i < data.length; i++) 
      {
          $('#edit_position').append('<option value="' + data[i] + '">' + data[i] + '</option>');
      } 
         
   }

   function uncheckCheckboxModules(){
    $('#edit_chk-Product').prop('checked', false);
    $('#edit_chk-Sales').prop('checked', false);
    $('#edit_chk-Inventory').prop('checked', false);
    $('#edit_chk-Reports').prop('checked', false);
    $('#edit_chk-Maintenance').prop('checked', false);
    $('#edit_chk-User').prop('checked', false);
    $('#edit_chk-Utilities').prop('checked', false);
    $('#edit_chk-manageorder').prop('checked', false);
    $('#edit_chk-verifycustomer').prop('checked', false);
   }
   
  //update
  $(document).on('click', '#btn-update-user', function(){
    
    var empID = $('#edit_empID_hidden').val();
    var emp_name = $('#edit_employee_name').val();
    var position = $('select[name="edit_position"] option').filter(':selected').text();
    var username = $('#edit_username').val();
    var password = $('#edit_password').val();

    console.log(empID);
    console.log(emp_name);
    console.log(position);
    console.log(username);
    console.log(password);

    var modules = [];
    $(':checkbox:checked').each(function(i){
      modules[i] = $(this).val();
    });
    modules = modules.join(", ");

    console.log(modules);
    
    $.ajax({
      url:"/maintenance/user/update",
      type:"POST",
      data:{
          empID:empID,
          emp_name:emp_name,
          position:position,
          username:username,
          password:password,
          modules:modules
        },
        beforeSend:function(){
          $('#btn-update-user').text('Updating...');
          $('.loader').css('display', 'inline');
        },
        success:function(){
          setTimeout(function(){
            
            $('#emp-table').DataTable().ajax.reload();
            $('.update-success-validation').css('display', 'inline');
            $('#btn-update-user').text('Update');
            $('.loader').css('display', 'none');
            
            setTimeout(function(){
              $('.update-success-validation').fadeOut('slow')

            },2000);
          
          },1000);
        }
    });
  }); 
});
  
  
        // delete supplier alert
        var empID, name;
        $(document).on('click', '#delete-user', function(){
          row = $(this).closest("tr")
          empID = $(this).attr('delete-id');
          name =  $(this).closest("tr").find('td:eq(1)').text();
          $('#confirmModal').modal('show');
          $('.delete-user-message').html('Are you sure do you want to delete <b>'+ name +'</b>?');
        }); 
        
        $('#btn-delete-user').click(function(){
            $.ajax({
                url: '/maintenance/user/delete/'+ empID,
                type: 'POST',
              
                beforeSend:function(){
                    $('#btn-delete-user').text('Deleting...');
                    $('.loader').css('display', 'inline');
           
                },
                success:function(data){

                    setTimeout(function(){
                      $('#btn-delete-user').remove();
                      $('.delete-user-message').remove();
                      $('.delete-success').show();
                      $('.loader').css('display', 'none');
                      $('.btn-cancel').text('Close');
                      row.fadeOut(500, function () {
                        table.row(row).remove().draw()
                        
                        });
                     
                  }, 1000);
                }
            });
          
        });

  
  