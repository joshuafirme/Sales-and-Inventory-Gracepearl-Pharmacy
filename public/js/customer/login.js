
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    
    $('#btn-login').click(function(){
      var is_valid = validateInputs();
      console.log('success');
      if(is_valid){
        var phone_email = $('#phone_email').val();
        var password = $('#password').val();
        
        login(phone_email, password);
      }
    });

    function validateInputs() {
        var phone_email = $('#phone_email').val();
        var password = $('#password').val();

        if(phone_email == '' || password == ''){
            alert('Please input your credentials!');
        }
        else{
            return true;        
        }
         
    }

    function login(phone_email, password) {
        $.ajax({
            url:"/customer-login/login",
            type:"POST",
            data:{
                phone_email:phone_email,
                password:password
            },
          
            success:function(response){
                console.log(response);
                if(response == 'valid'){
                    window.location.href = "/";
                }
                else{
                    alert('Invalid credentials!')
                }
             
            }         
           });
    }
});
  
  
  
  
  