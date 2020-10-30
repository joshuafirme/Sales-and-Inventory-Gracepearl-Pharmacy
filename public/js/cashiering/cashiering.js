
$(document).ready(function(){

  //search product
    $('#cashiering_search').keyup(function(){
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

  function pad (str, max) {
    str = str.toString();
    return str.length < max ? pad("0" + str, max) : str;
  }

          // Add to Cart
          $('#btn-addToCart').click(function(){

            var product_code  = $('#product_code').val();
            var description  = $('#description').val();
            var qty_order  = $('#qty_order').val();
            var price  = $('#price').val();
            var total  = $('#total').val();   
            $('#total-amount-due').val($('#total-amount').text());                         

              $.ajax({
                url:"/sales/cashiering/addToCart",
                type:"GET",
                data:{product_code:product_code, description:description, qty_order:qty_order, price:price, total:total},
                success:function(){
           
                  $( "#cashiering-table" ).load( "cashiering #cashiering-table" );
                  $('#cashiering_search').val('');
                  $('#product_code').val('');
                  $('#description').val('');
                  $('#qty').val('');
                  $('#price').val('');
                  $('#qty_order').val('');
                  $('#total').val(); 
                }
              });        
        }); 

        //compute change
          $('#tendered').keyup(function(){

            var tendered  = $(this).val();
            var total_amount_due  = $('#total-amount-due').val();                         
            var change = parseFloat(tendered) - parseFloat(total_amount_due);
            $('#change').val(change.toFixed(2));
                    
        }); 

});