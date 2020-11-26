
$(document).ready(function(){
  $.ajaxSetup({
    headers: {
  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
 });
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
              console.log(response);
              var product_code = response[0].productCode;

              $('#product_code_hidden').val(response[0].id);
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


          // Add to Cart
          $('#btn-addToCart').click(function(){   

       //     var product_code_hidden  = $('#product_code').val();
            var product_code  = $('#product_code').val();
            var description  = $('#description').val();
            var qty_order  = $('#qty_order').val();
            var price  = $('#price').val();
            var total  = $('#total').val();                         

              $.ajax({
                url:"/sales/cashiering/addToCart",
                type:"GET",
                data:{
                    product_code:product_code, 
                    description:description,
                    qty_order:qty_order, 
                    price:price,
                    total:total
                  },

                success:function(){
           
                  $('#cashiering_search').val('');
                  $('#product_code').val('');
                  $('#description').val('');
                  $('#qty').val('');
                  $('#price').val('');
                  $('#qty_order').val('');
                  $('#total').val(''); 

                  $( "#cashiering-table" ).load( "cashiering #cashiering-table" );

                  computeTotalAmountDue();
                  getCurrentTransNo();  
                }
              });     
              setTimeout(function(){
                $('#total-amount-due').val();
              },2000);
        }); 

        computeTotalAmountDue();

        function computeTotalAmountDue(){
          setTimeout(function(){
            var total_hidden = $('#total_hidden').val();
            console.log(total_hidden);
            $('#total-amount-due').val(total_hidden);
          },500);
         
        }

        $('#void').click(function(){
          product_code = $(this).attr('product-code');
          console.log(product_code);
       
        });
       
        //compute change
          $('#tendered').keyup(function(){

            var tendered  = $(this).val();
            var total_amount_due  = $('#total-amount-due').val();                         
            var change = parseFloat(tendered) - parseFloat(total_amount_due);
            $('#change').val(change.toFixed(2));
                    
        }); 

        $('#senior-chk').click(function(){

          if($('#senior-chk').prop('checked') == true)
          {
            $('#senior-name').css('display','inline');
          }
          else
          {
            $('#senior-name').css('display','none');
          }    
      
      });
      

        //proccess items
        $('#btn-process').click(function(){

          $.ajax({
            url:"/sales/cashiering/process",
            type:"GET",
            success:function(response){
          //    console.log(response);
              $( "#cashiering-table" ).load( "cashiering #cashiering-table" );
          
            }
          });     
      
      });

       //confirm sales invoice
       $('#btn-confirm-inv').click(function(){
        console.log('test');
        if($('#sales-invoice').val() == ''){
          $('.text-danger').css('display','inline');
        }
      
    
    });
      
      function getCurrentTransNo(){
        $.ajax({
          url:"/sales/cashiering/getTransNo",
          type:"GET",
          success:function(response){
            console.log(response);
              $('#transno').val(response);
           
          }
        }); 
      }

});
