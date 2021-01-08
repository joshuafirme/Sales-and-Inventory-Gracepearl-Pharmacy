
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      getCarttotal();

      function getCarttotal(){
        $.ajax({
            url:"/cart/getsubtotal",
            type:"GET",
            success:function(response){
                console.log('cart total');
                $('#cart-total').text('₱'+convertToMoneyFormat(response));
            }         
           });
      }


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

    function convertToMoneyFormat(total)
    {
    var round_off = Math.round((parseInt(total) + Number.EPSILON) * 100) / 100;
    return money_format = round_off.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $('#btn-place-order').click(function(){
        $.ajax({
            url:"/checkout/placeorder",
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

    
});

  

});
  
  
  
  
  