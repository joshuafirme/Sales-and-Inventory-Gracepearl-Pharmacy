
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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

      removeProceedToCheckout();

      function removeProceedToCheckout(){
        $.ajax({
          url:"/cart/countcart",
          type:"GET",
          success:function(response){
            if(response == 0){
              $('.card-proceed-checkout').css('display', 'none');
          }
          }
           
         });
      
      }

      getSubtotal();

      function getSubtotal(){
        $.ajax({
            url:"/cart/getsubtotal",
            type:"GET",
            success:function(response){
                $('.cart-subtotal').text('₱'+convertToMoneyFormat(response));
            }         
           });
      }

      function convertToMoneyFormat(total)
      {
        var round_off = Math.round((parseInt(total) + Number.EPSILON) * 100) / 100;
        return money_format = round_off.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }


    $(document).on('click', '#btn-add-to-cart', function(){
        countCart();
    });

    $(document).on('click', '#btn-remove-from-cart', function(){

        var product_code = $(this).attr('product-code');
        removeFromCart(product_code);
        countCart();
        getSubtotal();
        removeProceedToCheckout();//if cart is equal to 0
    });

    function removeFromCart(product_code){
        $.ajax({
            url:"/cart/remove",
            type:"POST",
            data: {
                product_code:product_code
            },
            
            success:function(){
              setTimeout(function(){
                $('#loading-modal').modal('toggle');
                $( ".card-cart" ).load( "cart .card-cart" );
                countCart();
              },1500);
             
            }
             
           });
      }

      $(document).on('blur', '#item-qty', function(){
        var qty = $(this).val();
        var product_code = $(this).attr('product-code');
        process(product_code, qty);
        
      });

      
      $(document).on('click', '#btn-inc', function(){
        var qty = $(this).attr('qty');
        var product_code = $(this).attr('product-code');
        process(product_code, qty);

        console.log(qty);
        console.log(product_code);
      });

      $(document).on('click', '#btn-dec', function(){
        var qty = $(this).attr('qty');
        var product_code = $(this).attr('product-code');
        process(product_code, qty);
        
      });
   
      function process(product_code, qty){
        if(qty){
          if(qty == 0){
            $('#loading-modal').modal('toggle');
            removeFromCart(product_code);
            getTotalAmount();
            countCart();
          }
  
          $('#loading-modal').modal('toggle');
          updateQtyAndAmount(product_code, qty);
          getSubtotal();
          countCart();
        }
      }

    function updateQtyAndAmount(product_code, qty){
      $.ajax({
          url:"/cart/updateQtyAndAmount",
          type:"POST",
          data: {
              product_code:product_code,
              qty:qty
          },
          
          success:function(){
            setTimeout(function(){
              $('#loading-modal').modal('toggle');
              $( ".card-cart" ).load( "cart .card-cart" );
              countCart();
            },1000);
           
          }
           
         });
    }


});
  
  
  
  
  