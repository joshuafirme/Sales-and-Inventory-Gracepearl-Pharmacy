
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    $(document).on('click', '#btn-add-to-cart', function(){
        var product_code = $(this).attr('product-code');
        console.log(product_code);
        $.ajax({
            url:"/homepage/addtocart",
            type:"POST",
            data: {
                product_code:product_code
            },
            beforeSend:function(){
                $('#loading-modal').modal('toggle');
              },
            success:function(){
                setTimeout(function(){
                    $('#loading-modal').modal('toggle');
                },1500);
              
            }
             
           });
    });

});
  
  
  
  
  