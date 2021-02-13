
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
                $('#cart-total').text('₱'+moneyFormat(response));
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
      
            $('#municipality').val(data[0].municipality);
            $('#brgy').val(data[0].brgy);
            $('#flr-bldg-blk').val(data[0].flr_bldg_blk);
            $('#note').val(data[0].note);
            $('#contact-no').val(data[0].phone_no);

            getShippingFee();
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


    $('#contact-no').keyup(function(e){
    //retricts value of letter
    if (/\D/g.test(this.value)){
        this.value = this.value.replace(/\D/g, '');
    }
    }); 

    
    function getShippingFee(){
      var municipality = $('#municipality').val(); 
      var brgy = $('#brgy').val(); 
      console.log(municipality+ 'mun');
      console.log(brgy);
      $.ajax({
        url:"/checkout/shipping_fee",
        type:"GET",
        data:{
          municipality:municipality,
          brgy:brgy
        },
        success:function(shipping_fee){
            $('.txt-shipping-fee').text('₱'+shipping_fee); 
            getTotal(shipping_fee);
        }
         
       });
    
    }

    getSubtotal();

    function getSubtotal(){
      $.ajax({
          url:"/checkout/getsubtotal",
          type:"GET",
          success:function(response){
              $('#txt-subtotal').text('₱'+moneyFormat(response));
          }         
         });
    }


    function getTotal(shipping_fee){
      $.ajax({
          url:"/checkout/getsubtotal",
          type:"GET",
          success:function(subtotal){
            var total = parseFloat(subtotal) + parseFloat(shipping_fee);
              $('#txt-total-due').text('₱'+moneyFormat(total));
          }         
         });
    }

    function moneyFormat(total)
      {
        var decimal = (Math.round(total * 100) / 100).toFixed(2);
       // var round_off = Math.round((parseInt(parseFloat(decimal)) + Number.EPSILON) * 100) / 100;
        return money_format = parseFloat(decimal).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
    

    $('#btn-place-order').click(function(){

      var shipping_fee = $('.txt-shipping-fee').text().slice(1);; 
      
        if(checkFields() == true){
            $.ajax({
                url:"/checkout/placeorder",
                type:"POST",
                data:{
                  shipping_fee:shipping_fee
                },
                beforeSend:function(){
                    $('#loading-modal').modal('toggle');
                },
                success:function(){
                    window.location.href = "/payment";
                }         
        });  
        }
       
});

$(document).on('click', '#btn-edit-shipping-info', function(){

    window.location.href = "/account";
    $('#editAccountModal').modal('toggle');
  
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
  
  
  
  
  