
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
        function computeChange(){
          var tendered  =  $('#tendered').val();
          var total_amount_due  = $('#total-amount-due').val();                         
          var change = parseFloat(tendered) - parseFloat(total_amount_due);
          $('#change').val(change.toFixed(2));
        }

          $('#tendered').keyup(function(){

           computeChange();
                    
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
              
        //get sales inv and pass to input
        function getSalesInv(){
          $.ajax({
            url:"/sales/cashiering/getSalesInvNo",
            type:"GET",
            success:function(response){
              console.log(response);
              $('#sales-invoice-no').val(response);
              
            }
          });
        }

        //check if senior checkbox is cheked
        $('#senior-chk').click(function(){
          if($('#senior-chk').prop('checked') == true){
            $.ajax({
              url:"/maintenance/discount/getdiscount",
              type:"POST",
              success:function(data){
                
                var discount = data[0].discount;
                var total = $('#total-amount-due').val();

                console.log(discount);
                var result = discount * total;
                var nya = total - result;
                $('#total-amount-due').val(nya);
                computeChange();
              }
            });
          }
          else{
            computeTotalAmountDue();
            setTimeout(function(){
              computeChange();
            },500);
     
          }
        });
        
        //proccess items
        $('#btn-process').click(function(){
    
          getSalesInv();
      
        });

       //enter sales invoice # and check if senior citizen
       $('#btn-confirm-inv').click(function(){
   
        var senior_chk = $('#senior-chk').val();
        var sales_inv_no= $('#sales-invoice-no').val();
        var senior_name = $('#senior-name').val();

        console.log(senior_chk);
        console.log(sales_inv_no);
        console.log(senior_name);

        if($('#senior-chk').prop('checked') == true){
          senior_chk = 'yes';
        }
        else{
          senior_chk = 'no';
        }

          if($('#sales-invoice').val() == ''){
            $('.text-danger').css('display','inline');
          }
          else{
            
            $.ajax({
              url:"/sales/cashiering/process",
              type:"GET",
              data:{
                sales_inv_no:sales_inv_no,
                senior_name:senior_name,
                senior_chk:senior_chk
              },
              beforeSend:function(){
                $('#btn-confirm-inv').text('Processing...');
                $('.loader').css('display', 'inline');
              },
              success:function(){

                setTimeout(function(){

                  $('.loader').css('display', 'none');
                  $('.update-success-validation').css('display', 'inline');
                  $('#btn-confirm-inv').text('Confirm');

                  $('#cashiering_search').val('');
                  $('#product_code').val('');
                  $('#description').val('');
                  $('#qty').val('');
                  $('#price').val('');
                  $('#qty_order').val('');
                  $('#total').val(''); 

                  $('#total-amount-due').val('');
                  $('#change').val('');
                  $('#tendered').val('');
                  $('#senior-chk').prop('checked', false);
                  $('#senior-name').css('display', 'none');
                  $( "#cashiering-table" ).load( "cashiering #cashiering-table" );

                 setTimeout(function(){
                    $('.update-success-validation').fadeOut('slow')

                    setTimeout(function(){
                      $('#processModal').modal('hide');
                    },1000);

                  },500);

                },500);
               
              }
            });   
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