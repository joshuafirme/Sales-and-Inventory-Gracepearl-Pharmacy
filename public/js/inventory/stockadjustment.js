
$(document).ready(function(){

    //search product
      $('#stock_search').keyup(function(){
          var search_key = $(this).val();
          $('#qty_order').val(1);
          
          if(search_key == ''){
            $('#product_code').val('');
            $('#description').val('');
            $('#qty').val('');
            $('#price').val('');
            $('#qty_order').val('');
            $('#total').val('');
            
          }
          else{
            $.ajax({
              url:"/sales/cashiering/"+search_key,
              type:"POST",
              data:{search_key:search_key},
  
              success:function(response){
                if(response == ''){
                  $('#product_code').val('');
                  $('#description').val('');
                  $('#qty').val('');
                  $('#price').val('');
                  $('#qty_order').val('');
                  $('#total').val('');
                }
                var product_code = response[0].productCode;
  
                $('#product_code').val(product_code);
                $('#description').val(response[0].description);
                $('#qty').val(response[0].qty);
                $('#price').val(response[0].selling_price);
                $('#qty_order').val();
                $('#total').val(response[0].selling_price);
  
                $('#qty_order').keyup(function(){
  
                    var qty = $(this).val();
                    var price = $('#price').val();
                    var total = parseFloat(price) * parseFloat(qty);
                
                    $('#total').val(total.toFixed(2));
                       
                  
                });
              } 
            });
          }
            
    }); 
  

  
  });
  