$(document).ready(function () {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    $('.btn-pay-now').click(function(){
        var order_no = $(this).attr('order-no');
        var amount = $('#pay-now-'+order_no).text();
        console.log(amount+' '+order_no);
        payNow(order_no, amount);

        
    });
    
    $('.btn-cancel-order').click(function(){
      var order_no = $(this).attr('order-no');
      var remarks = $('#remarks').val();
      $('#cancelOrderModal').modal('toggle'); 

      cancelOrder(order_no, remarks);

  });

    function payNow(order_no, amount) {
      $.ajax({
        url:"/payment/paynow/"+order_no,
        type:"GET",
        data:{
          amount:amount
        },
        success:function(){ 
          window.location.href = "/payment";
        }         
       });
    }


    function cancelOrder(order_no, remarks) {
        
      $('.confirmation-message').html('Are you sure do you want to cancel your order?</b>');
 
        
        $('#btn-confirm-cancel').click(function(){
          $.ajax({
            url:"/myorder/cancel/"+order_no,
            type:"GET",
            data:{
              remarks:remarks
            },
            beforeSend:function(){
              $('#btn-confirm-cancel').text('Please wait...');
            },
            success:function(){
                setTimeout(function(){
                  $('#btn-confirm-cancel').text('Confirm');
                  $( "#my-order-contr" ).load( "myorders #my-order-contr" );
                  $('#success-message').css('display', 'inline');
                }, 1000);
              }     
            });
          
        });
     
    }




});