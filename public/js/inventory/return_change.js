
$(document).ready(function(){
    $.ajaxSetup({
      headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
   });
    //search product
    $('#rc_sales_inv_no').keyup(function(){
        searchSalesInvoice();
        searchProductCodeAndInvoice();
     }); 

     $('#rc_product_code').change(function(){
         searchProductCodeAndInvoice();
     }); 
  

    function searchSalesInvoice(){
          var sales_inv_no = $('#rc_sales_inv_no').val();
       //   var product_code = $('#rc_prouct_code').val();
          
          if(sales_inv_no == '' || product_code == ''){
             clear();    
          }
          else{
            $.ajax({
              url:"/inventory/returnchange/searchSalesInvoice",
              type:"POST",
              data:{
                 sales_inv_no:sales_inv_no
                },
  
              success:function(response){
                console.log(response);

                $('#rc_product_code').val('');
                $('#rc_product_code').text('');
                var dropdown = $('#rc_product_code');
        
                    $.each(response, function() {
                      dropdown.append($("<option/>").val(this.product_code).text(this.product_code));   
                    });
                   
                //  $('#rc_description').text(response[0].description);
                 // $('#rc_unit').text(response[0].unit);
                //  $('#rc_category').text(response[0].category_name);
                //  $('#rc_qty_purchased').text(response[0].qty);
               //   $('#rc_amount_purchased').text(response[0].amount);
               //   $('#rc_qty_to_rc').val();
            
              } 
            });
          }       
    }

    function searchProductCodeAndInvoice(){
      var sales_inv_no = $('#rc_sales_inv_no').val();
      var product_code = $('select[name=rc_product_code] option').filter(':selected').val();

      console.log(sales_inv_no+' and '+product_code);
      
      if(sales_inv_no == '' || product_code == ''){
         clear();    
      }
      else{
        $.ajax({
          url:"/inventory/returnchange/searchProdAndInv",
          type:"POST",
          data:{
             sales_inv_no:sales_inv_no,
             product_code:product_code
            },

          success:function(response){
            console.log(response);
               
              $('#rc_description').text(response[0].description);
              $('#rc_unit').text(response[0].unit);
              $('#rc_category').text(response[0].category_name);
              $('#rc_qty_purchased').text(response[0].qty);
              $('#rc_selling_price').text(response[0].selling_price);
              $('#rc_amount_purchased').text(response[0].amount);
        
          } 
        });
      }       
}

$('#rc_qty_to_rc').keyup(function(){
  computeAmount();
})

function computeAmount(){
  var qty = $('#rc_qty_to_rc').val();
  var price =  $('#rc_selling_price').text();
  var amount = qty * price;
  $('#rc_amount').val(amount);
}



    function clear(){    
        $('#rc_description').text('');
        $('#rc_unit').text('');
        $('#rc_category').text('');
        $('#rc_qty_purchased').text('');
        $('#rc_amount_purchased').text('');
    }
  
  
  });
  