
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    
    $('#btn-update-account').on('click', function(){

        var fullname = $('#fullname').val();
        var email = $('#email').val();
        var phone_no = $('#phone_no').val();

        if(!fullname){
            alert('Please enter your fullname');
        }
        else{
            $.ajax({
                url:"/account/update",
                type:"POST",
                data: {
                    fullname:fullname,
                    email:email,
                    phone_no:phone_no
                },
                beforeSend:function(){
                    $('#btn-update-account').text('Saving...');
                    $('.loader').css('display', 'inline');
                  },
                success:function(){
               
                    setTimeout(function(){
                        $('.update-success-validation').css('display', 'inline');
                        $('#btn-update-account').text('Save');
                        $('.loader').css('display', 'none');
                        setTimeout(function(){
                          $( ".div-my-account" ).load( "account .div-my-account" );
                          $('.update-success-validation').fadeOut('slow')
                         
                        },2000);
                      
                      },1000);
                }
                 
               });
        }
       
    });


});
  
  
  
  
  