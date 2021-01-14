
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
            if(response == 'For validation') 
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
            alert('Your account is not verified! \n Please verify your account before you proceed to checkout.');
            window.location.href = "/account";
          }
            
        }
         
       });
    }
   // window.top.close();



    getSubtotal();

    function getSubtotal(){
      $.ajax({
          url:"/checkout/getsubtotal",
          type:"GET",
          success:function(response){
              $('#lbl-payment-total').text('₱'+convertToMoneyFormat(response));
              $('#lbl-after-payment').text('₱'+convertToMoneyFormat(response));
              
          }         
         });
     
    }
  

    $(window).on('load', function() {
      setTimeout(function(){
        forgetOrder();
      },3500)
     });
    
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

    function convertToMoneyFormat(total)
    {
      var round_off = Math.round((parseInt(total) + Number.EPSILON) * 100) / 100;
      return money_format = round_off.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    var stripe_window;
    $('#btn-stripe').click(function(){
        var left  = ($(window).width()/2)-(400/2),
        top   = ($(window).height()/2)-(600/2);
        stripe_window = window.open ("/stripe", "popup", "width=485, height=450, top="+top+", left="+left);
        
    });
    $('#btn-stripe-pay').click(function(){
      alert('yay');
      stripe_window.close();
    });


});
  
  
  
  
  