
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
              var product_code = response[0].product_code;

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

  $('#cashiering_search').keydown(function(e){
      var code = e.keyCode || e.which;
      if(code == 120) { //Enter keycode
          addProduct();
      }
    
  });


   // Add to Cart
   $('#btn-addToCart').click(function(){   
    if($('#cashiering_search').val() == ''){
      alert('Enter product code or product description');
    }
    else{
      addProduct();
    }
    
    });  
    
    function addProduct(){
      var product_code  = $('#product_code').val();
      var qty_order  = $('#qty_order').val();
      var price  = $('#price').val();
      var total  = $('#total').val();                         
      console.log(product_code);
        $.ajax({
          url:"/sales/cashiering/addToCart",
          type:"GET",
          data:{
              product_code:product_code, 
              qty_order:qty_order, 
              price:price,
              total:total
            },

          success:function(){
            $( "#cashiering-table" ).load( "cashiering #cashiering-table" );
            $('#cashiering_search').val('');
            getTotalAmount(); 
            getGenericTotalAmount();
          }
        });     
    }


     function getTotalAmount() {
      $.ajax({
        url:"/cashiering/total_amount",
        type:"GET",
        success:function(data){
          $('#total-amount-due').val(data); 
        }
      });
     }

     getGenericTotalAmount();

     function getGenericTotalAmount() {

        $.ajax({
          url:"/cashiering/generic_total_amount",
          type:"GET",
          success:function(data){
            console.log(data);
            $('#generic_total_hidden').val(data);
          }
        });
     }
       
       
        //compute change
        function computeChange(){
          var tendered  =  $('#tendered').val();
         if(tendered){
          var total_amount_due  = $('#total-amount-due').val();                         
          var change = parseFloat(tendered) - parseFloat(total_amount_due);
          if(change == 0 || change == undefined){
            change = 0;
            console.log('change');
          }
          $('#change').val(change.toFixed(2));
         }
        }

          $('#tendered').keyup(function(){

           computeChange();
                    
          }); 

     /*   $('#senior-chk').click(function(){

          if($('#senior-chk').prop('checked') == true)
          {
            $('#senior-name').css('display','inline');
          }
          else
          {
            $('#senior-name').css('display','none');
          }    
      
      }); 
      */


     $(document).on('click', '.show-void-modal', function()
     {   
      $( "#cashiering-table" ).load( "cashiering #cashiering-table" );

        var product_code = $(this).attr('product-code');
        console.log(product_code);
        $('#product-code-hidden').val(product_code);
    
      });  

          // void product
      $('#btn-void').click(function()
      {   
      //  $( "#cashiering-table" ).load( "cashiering #cashiering-table" );
          credentialBeforeVoid();
      });
      
      function voidItem() {
        var product_code = $('#product-code-hidden').val();
        console.log(product_code);
        $.ajax({
          url:"/cashiering/void",
          type:"GET",
          data:{
            product_code:product_code
          },
          beforeSend:function(){
            $('#btn-void').text('Please wait...');
            $('.loader').css('display', 'inline');
          },
          success:function(){
            setTimeout(function () {
              $('#void-success').css('display', 'inline');
              $('#btn-void').text('Void');
              $('.loader').css('display', 'none');
              $( "#cashiering-table" ).load( "cashiering #cashiering-table" );
              setTimeout(function(){
                $('#void-success').fadeOut('slow');
                $('#admin-username').val('');
                $('#admin-password').val('');
                $('#voidModal').modal('hide');
              },2000);
            },1000);

            
            getTotalAmount();
            computeChange();
            getGenericTotalAmount();
          }
        });
      }

      function credentialBeforeVoid() {
        var username = $('#admin-username').val();
        var password = $('#admin-password').val();
        if(username == '' || password == ''){
          alert('Please input admin credential!');
        }
        else{
          $.ajax({
            url:"/cashiering/credential",
            type:"POST",
            data:{
              username:username,
              password:password
            },
            success:function(response){
              console.log(response);
                if(response == 'success'){
                  voidItem();
                }
                else{
                  alert('Invalid credential!');
                }
            }
          });
        }
        
      }
      getSalesInvoice();
        //get sales inv and pass to input
        function getSalesInvoice(){
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
        $('#discount-chk').click(function(){
          if($('#discount-chk').prop('checked') == true){
            $('.discount-option').css('display', 'block');
             
            getSeniorDiscount();
            getPWDDiscount();
          }
          else{
            $('.discount-option').css('display', 'none');
            getTotalAmount();
            computeChange();
          }
        });

        $('#radio-sc').click(function () {
            getSeniorDiscount();
        });

        $('#radio-pwd').click(function () {
            getPWDDiscount();
        });

      function getSeniorDiscount() {
        if($('#radio-sc').is(':checked')){
          $.ajax({
            url:"/maintenance/discount/sc_discount",
            type:"POST",
            success:function(percentage){          
              computeDiscount(percentage);
              computeChange();
            }
          });
        }
        else{
          computeChange();
        }
       
      }

      function getPWDDiscount() {
        if($('#radio-pwd').is(':checked')){
          $.ajax({
            url:"/maintenance/discount/pwd_discount",
            type:"POST",
            success:function(percentage){
              computeDiscount(percentage);
              computeChange();
            }
          });
        }
        else{
          computeChange();
        }
      }

      function computeDiscount(percentage){
          getTotalAmount();
          setTimeout(function(){
            var total = $('#total-amount-due').val();  
          var total_generic = $('#generic_total_hidden').val();  
          var discount = percentage * total_generic;
          var total_due = total - discount;

          $('#less-discount').text(moneyFormat(discount));
          $('#total-amount-due').val(moneyFormat(total_due));

          computeChange();
          },500);          
      }



    function moneyFormat(total)
    {
      var decimal = (Math.round(total * 100) / 100).toFixed(2);
     // var round_off = Math.round((parseInt(parseFloat(decimal)) + Number.EPSILON) * 100) / 100;
      return money_format = parseFloat(decimal).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

        
        //proccess items
        $('#btn-process').click(function(){
          if($('#total-amount-due').val() == 0){
            $('#btn-confirm-inv').attr('disabled', true);
          }
          getSalesInvoice();
      
        });

      

       $('#btn-confirm-inv').click(function(){
   
        var less_discount = $('#less-discount').text();
        var sales_inv_no= $('#sales-invoice-no').val();
        var payment_method;

        if($('#radio-cash').is(':checked')){
          payment_method = 'Cash';
        }
        else if($('#radio-gcash').is(':checked')){
          payment_method = 'GCash';
        }


          if($('#tendered').val() == ''){
            alert('Please enter the amount tendered.')
          }
          else{
            $.ajax({
              url:"/sales/cashiering/isInvoiceExist/" + sales_inv_no,
              type:"GET",
              success:function(response){
                
                if(response == 'yes'){
                  alert('Sales Invoice is already exist!')
                }
                else{
                  $.ajax({
                    url:"/sales/cashiering/process",
                    type:"GET",
                    data:{
                      sales_inv_no:sales_inv_no,
                      less_discount:less_discount,
                      payment_method:payment_method
                    },
                    beforeSend:function(){
                      $('#btn-confirm-inv').text('Processing...');
                    },
                    success:function(){      
                      clear();
                      getSalesInvoice();
                      initComponents();
                    }
                  });   
                }
              }
            });          
          }
    });

    function initComponents(){
      
     //   $('.loader').css('display', 'none');
      //  $('.update-success-validation').css('display', 'inline');
        $('#btn-confirm-inv').text('Pay');

        $( "#cashiering-table" ).load( "cashiering #cashiering-table" );
  
       setTimeout(function(){
          $('.update-success-validation').fadeOut('slow')

          setTimeout(function(){

            //generate sales invoice in new tab 
            window.open('/cashiering/reciept/print', '_blank'); 
            setTimeout(function(){
              $( ".cashiering-table" ).load( "cashiering .cashiering-table" );
            },3000)

          },1000);

        },500);
    }


    function clear(){
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
    }

});
