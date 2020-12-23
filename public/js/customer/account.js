
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


    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
          $('#img-valid-id').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }
    
    $("#file-valid-id").change(function() {
      console.log('upload');
      readURL(this);
    });

    isVerified();

    function isVerified(){
      $.ajax({
        url:"/account/isforvalidation",
        type:"GET",
 
        success:function(response){
          
          if(response != '')
          {
            if(response == 'For validation') 
            {
              console.log('validation');
              $('#verify-link').css('display', 'inline');
              $('#verification-info').css('display', 'block');
              disabledInputs();
            }
            else if(response == 'Verified')
            {
              console.log('verified');
              $('#verify-link').css('display', 'none');
              $('#verification-badge').toggleClass('badge-secondary badge-success');
              $('#verification-badge').text('Verified');
            }
            else
            {
              console.log('senior');
              $('#verify-link').css('display', 'none');
              $('#verification-badge').toggleClass('badge-secondary badge-success');
              $('#verification-badge').text('Verified Senior Citizen');
            }
          }
          else{
            // if no upload yet
            console.log('no upload');
            $('#verify-link').css('display', 'inline');
          }
            
        }
         
       });
    }

    function disabledInputs(){
      $("#id-type").attr('disabled', true);
      $("#id-number").attr('disabled', true);
      $("#file-valid-id").attr('disabled', true);
      $("#btn-upload").attr('disabled', true);
    }

});
  
  
  
  
  