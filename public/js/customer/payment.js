
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('#btn-cash-on-delivery').click(function(){
        isVerified();
    });

   

    function isVerified(){
      $.ajax({
        url:"/account/checkifverified",
        type:"GET",
 
        success:function(response){
          
          if(response != '')
          {          
            if(response == 'For validation' || response == '') 
            {
              alert('Your account is not verified! \n Please verify your account before you proceed to checkout.');
              window.location.href = "/account";
            }
            else if(response == 'Verified')
            {
               cashOnDelivery();
               window.location.href = "/payment/afterpayment";
            }
            else
            {

              cashOnDelivery();
              window.location.href = "/payment/afterpayment";
            }
          }
          else{
            alert('Your account is not verified! \nPlease verify your account before you proceed to COD.');
            window.location.href = "/account";
          }
            
        }
         
       });
    }
   // window.top.close();



    getShippingFee();
    
    function getShippingFee(){
      
      $.ajax({
        url:"/checkout/shipping_fee",
        type:"GET",
        success:function(shipping_fee){
            $('.txt-shipping-fee').text('₱'+shipping_fee); 
            getTotal(shipping_fee);
        }
         
       });
    
    }
    
    function getTotal(shipping_fee){
      $.ajax({
          url:"/checkout/getsubtotal",
          type:"GET",
          success:function(subtotal){
            var total = parseFloat(subtotal) + parseFloat(shipping_fee);
            console.log(subtotal +' '+ shipping_fee);
              $('#lbl-payment-total').text('₱'+moneyFormat(total));
          }         
         });
    }
  
      setTimeout(function(){
        forgetOrder();
      },3500)
   
    
    function forgetOrder(){
      $.ajax({
          url:"/payment/afterpayment/forget",
          type:"GET",
          success:function(response){
          }         
         });
    }

    function cashOnDelivery(){
        $.ajax({
            url:"/payment/cod",
            type:"POST",
            beforeSend:function(){
                $('#loading-modal').modal('toggle');
              },
            success:function(){
                setTimeout(function(){
                    $('#loading-modal').modal('toggle');
                },1000);   
             
            }         
           });
      }

      function moneyFormat(total)
      {
        var decimal = (Math.round(total * 100) / 100).toFixed(2);
       // var round_off = Math.round((parseInt(parseFloat(decimal)) + Number.EPSILON) * 100) / 100;
        return money_format = parseFloat(decimal).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }

   /* var stripe_window;
    $('#btn-stripe').click(function(){
        var left  = ($(window).width()/2)-(400/2),
        top   = ($(window).height()/2)-(600/2);
        stripe_window = window.open ("/stripe", "popup", "width=485, height=450, top="+top+", left="+left);
        
    }); */


});
  
  
  
  
  