
$(document).ready(function(){
    $.ajaxSetup({
      headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
   });

   fetch_returns();

   function fetch_returns(){
    $('#return-table').DataTable({
   
      processing: true,
      serverSide: true,
      
     
      ajax:{
       url: "/inventory/return/displayreturn",
      }, 
      
      columns:[       
       {data: 'returnID', name: 'returnID'},
       {data: 'sales_inv_no', name: 'sales_inv_no'},
       {data: 'product_code', name: 'product_code'},
       {data: 'description', name: 'description'},
       {data: 'unit', name: 'unit'},   
       {data: 'category_name', name: 'category_name'},   
       {data: 'qty', name: 'qty'},
       {data: 'reason', name: 'reason'},
       {data: 'date', name: 'date'},
      ]
      
     });

      
  }


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
          if(sales_inv_no == ''){
             clear();    
          }
          else{
            $.ajax({
              url:"/inventory/return/searchSalesInvoice",
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
          url:"/inventory/return/searchProdAndInv",
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

    $('#rc_qty_to_return').keyup(function(){
      computeAmount();
    })

    function computeAmount(){
      var qty = $('#rc_qty_return').val();
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

    $('#btn-add-return').click(function(){
      returnItem();
    })

    // add to return
    function returnItem(){
      var sales_inv_no = $('#rc_sales_inv_no').val();
      var product_code = $('select[name=rc_product_code] option').filter(':selected').val();
      var qty_return = $('#rc_qty_return').val();
      var exp_date = $('#rc_exp_date').val();
      var reason = $('select[name=rc_reason] option').filter(':selected').val();
      var date = $('#rc_date').val();

      console.log(sales_inv_no+' and '+product_code);
      console.log(qty_return+' and '+reason);
      console.log(date);
        $.ajax({
          url:"/inventory/return/store",
          type:"POST",
          data:{
             sales_inv_no:sales_inv_no,
             product_code:product_code,
             exp_date:exp_date,
             qty_return:qty_return,
             reason:reason,
             date:date
            },
            beforeSend:function(){
              $('#btn-add-return').text('Returning...');
              $('.loader').css('display', 'inline');
            },
            success:function(response){
              
              setTimeout(function(){
                $('.update-success-validation').css('display', 'inline');
                $('#btn-add-return').text('Return');
                $('.loader').css('display', 'none');
                setTimeout(function(){
                  $('.update-success-validation').fadeOut('slow');
   
                },2000);
              
              },1000);
              
              } 
            });
          
}
  
  
  });
  