
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      fetch_users();

      function fetch_users(){
        $('#emp-table-table').DataTable({
        
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

       //NOTE: DO IT LATER: if auth modules have that module then the checkbox is visible. Use jQuery!!!
  
   $('#confirm_password').blur(function(){
     
    var password = $('#password').val();
    var confirm_password = $('#confirm_password').val();

    if(password !== confirm_password){
      alert('Password do not match!')
    }
   });

   $('#edit_confirm_password').blur(function(){
     
    var password = $('#edit_password').val();
    var confirm_password = $('#edit_confirm_password').val();

    if(password !== confirm_password){
      alert('Password do not match!')
    }
   });


  //edit show
  $(document).on('click', '#btn-edit-user', function(){
    var empID = $(this).attr('emp-id');

    $('#edit_chk-Product').prop('checked', false);
    $('#edit_chk-Sales').prop('checked', false);
    $('#edit_chk-Inventory').prop('checked', false);
    $('#edit_chk-Reports').prop('checked', false);
    $('#edit_chk-Maintenance').prop('checked', false);
    $('#edit_chk-User').prop('checked', false);
    
    $.ajax({
      url:"/maintenance/user/show/"+ empID,
      type:"POST",
      data:{
          empID:empID
        },

      success:function(response){
        console.log(response);
        $('#edit_empID_hidden').val(response[0].id);
        $('#edit_empID').val(response[0].empID);
        $('#edit_employee_name').val(response[0].name);
        $('#edit_position').val(response[0].position);
        $('#edit_username').val(response[0].username);
        $('#edit_password').val(response[0].password);

        var modules_arr = response[0].auth_modules.split(', ');
        console.log(modules_arr);

        for (var i = 0; i < modules_arr.length; i++) {
          console.log(modules_arr[i]);
          if($('#edit_chk-'+modules_arr[i]).val() == modules_arr[i]){
            $('#edit_chk-'+modules_arr[i]).prop('checked', true);
          }
         
        }

        
      }
    });
  }); 
   

});
  
  
  
  
  