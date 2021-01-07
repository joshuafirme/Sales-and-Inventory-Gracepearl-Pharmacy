
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('#btn-cash-on-delivery').click(function(){
        cashOnDelivery();
    });


    window.top.close();

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
  
  
  
  
  