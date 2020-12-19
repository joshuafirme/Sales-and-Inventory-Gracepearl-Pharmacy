

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });


$('#contact-no').keyup(function(e)
{
    //retricts value of letter
    if (/\D/g.test(this.value)){
        this.value = this.value.replace(/\D/g, '');
    }
    }); 

    getSubtotal();

    function getSubtotal(){
      $.ajax({
          url:"/checkout/getsubtotal",
          type:"GET",
          success:function(response){
              $('#checkout-subtotal').text('₱'+convertToMoneyFormat(response));
          }         
         });
    }

    $('#btn-cash-on-delivery').click(function(){
        cashOnDelivery();
    });

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
    
    $('#btn-stripe').click(function(){
        var left  = ($(window).width()/2)-(400/2),
        top   = ($(window).height()/2)-(600/2),
        popup = window.open ("http://127.0.0.1:8000/stripe", "popup", "width=485, height=450, top="+top+", left="+left);
        return popup;
    });


});
  
  
  
  
  