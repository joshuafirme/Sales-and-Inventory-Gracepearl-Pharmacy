
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    checkIfLoggedIn();

    function checkIfLoggedIn(){
      $.ajax({
        url:"/customer/islogged",
        type:"GET",
        success:function(response){
            
          if(response !== 'yes'){
              $('#user-profile').css('display', 'none');
              $('#dropdown-items').css('display', 'none');
              $('#login-url').text('Login');
              $('#login-url').removeAttr('data-toggle');
              $('#lblCartCount').css('display', 'none');
              $('.fa-shopping-cart').css('display', 'none');
              $('#login-url').attr("href", "http://127.0.0.1:8000/customer-login");
          }
     
        }
         
       });
    }


    $(document).on('click', '#btn-add-to-cart', function(){
        var product_code = $(this).attr('product-code');
        console.log(product_code);

        $.ajax({
          url:"/customer/islogged",
          type:"GET",
          success:function(response){
              
            if(response !== 'yes'){
              window.location.href = "http://127.0.0.1:8000/customer-login";
            }
            else{
              $.ajax({
                url:"/homepage/addtocart",
                type:"POST",
                data: {
                    product_code:product_code
                },
                beforeSend:function(){
                    $('#loading-modal').modal('toggle');
                  },
                success:function(){
                    setTimeout(function(){
                        $('#loading-modal').modal('toggle');
                    },1500);
                  
                }
                 
               });
            }
       
          }
           
         });
      
    });
    
  
});
  
  
  
  
  