
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
                        countCart();
                    },500);
                  
                }
                 
               });
            }
       
          }
           
         });
      
    });

    countCart();

    function countCart(){
      $.ajax({
          url:"/cart/countcart",
          type:"GET",
          success:function(response){
              $('.count-cart').text(response);
              return response;
          }
           
         });
    }

    getCustomerName();

    function getCustomerName(){
     
      $.ajax({
        url:"/account/getaccountinfo",
        type:"GET",
        success:function(data){
          $('#customer-name').text(data[0].fullname);
        }
         
       });
    }

    if($('ul li').length > 3){

      $('ul li').length - 10;
      var highlights = $('#highlights').text()
      highlights.replace(50, '...');
    }

    $(document).on('click', '#btn-view-more', function(){

     

     
    
  });
    
  
});
  
  
  
  
  