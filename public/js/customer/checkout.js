
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      getCarttotal();

      function getCarttotal(){
        $.ajax({
            url:"/checkout/getsubtotal",
            type:"GET",
            success:function(response){
                console.log('cart total');
                $('#cart-total').text('₱'+convertToMoneyFormat(response));
            }         
           });
      }
      
    fetchShippingInfo();
    fetchAccountInfo();

      function fetchShippingInfo(){
     //   alert('yay');
        $.ajax({
          url:"/account/getshippinginfo",
          type:"GET",
          success:function(data){
            console.log(data);
           if(data){
      
            $('#flr-bldg-blk').val(data[0].flr_bldg_blk);
            $('#brgy').val(data[0].brgy);
            $('#note').val(data[0].note);
            $('#contact-no').val(data[0].phone_no);
           }
          }
           
         });
      }

      function fetchAccountInfo(){
        $.ajax({
          url:"/account/getaccountinfo",
          type:"GET",
          success:function(data){  console.log(data);
            $('#email').val(data[0].email);
            $('#contact-no').val(data[0].phone_no);
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
       
        if(checkFields() == true){
            $.ajax({
                url:"/checkout/placeorder",
                type:"POST",
                beforeSend:function(){
                    $('#loading-modal').modal('toggle');
                },
                success:function(){
                    window.location.href = "/payment";
                }         
        });  
        }
       
});


    function checkFields() {
       var brgy = $('#brgy').val();
       var note = $('#note').val();
       var contact_no = $('#contact-no').val();

       if(brgy == '' || contact_no == '' || note == ''){
            alert('Please fill all the required information');
       }
       else{
           return true;
       }
    }

  

});
  
  
  
  
  