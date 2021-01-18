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



});