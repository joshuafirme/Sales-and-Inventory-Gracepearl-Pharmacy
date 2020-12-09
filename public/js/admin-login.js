
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      function logout(){
        console.log('logout');
        $.ajax({
          url:"/admin-login/logout",
          type:"POST",
          success:function(){
          }
           
         });
      }
      
   $('#btn-admin-login').click(function(){
    var username = $('#admin-username').val();
    var password = $('#admin-password').val();
    console.log(username);
    console.log(password);
    $.ajax({
        url:"/admin-login/login",
        type:"POST",
        data:{
            username:username,
            password:password
          },
        success:function(response){
            
        if(username == '' || password == ''){
            alert('Please input your username and password');
        }
        else{
            if(response == 'success'){
                window.location.href = "/dashboard";
              }
              else{
                alert('Invalid username or password')
              }      
            }       
         }
         
        
       });
   });

});
  
  
  
  
  