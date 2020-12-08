
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
  
   $('#confirm_password').blur(function(){
     
    var password = $('#password').val();
    var confirm_password = $('#confirm_password').val();
    
    if(password !== confirm_password){
      alert('Password do not match!')
    }
   });

});
  
  
  
  
  