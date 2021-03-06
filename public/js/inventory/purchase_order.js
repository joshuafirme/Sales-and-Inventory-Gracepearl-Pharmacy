
$(document).ready(function(){

    initLoadData();

    function initLoadData(){
      supplier = $('#ro_supplier').val();
      console.log(supplier);
      $('#reorder-table').DataTable().destroy();
      fetch_reorders(supplier);
    }

    function fetch_reorders(supplier){
      $('#reorder-table').DataTable({
     
        processing: true,
        serverSide: true,
        
       
        ajax:{
         url: "/inventory/displayReorders",
         type:"GET",
         data:{
          supplier:supplier
        }
        }, 
   
        columns:[       
         {data: 'product_code', name: 'product_code'},
         {data: 'description', name: 'description'},
         {data: 'unit', name: 'unit'},   
         {data: 'category_name', name: 'category_name'},    
         {data: 'supplierName', name: 'supplierName'},    
         {data: 'qty', name: 'qty'},
         {data: 're_order', name: 're_order'},
         {data: 'action', name: 'action',orderable: false},
        ]
        
       });
       $('#ro_supplier').change(function(){
        supplier = $(this).val();
        console.log(supplier);
        console.log(supplier);
        $('#reorder-table').DataTable().destroy();
        fetch_reorders(supplier);
    
        });
    }


    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    var supplier = $('#ord_supplier option').filter(':selected').text();
    console.log(date_from, date_to, supplier);
    fetch_orders(date_from, date_to, supplier);

    function fetch_orders(date_from, date_to, supplier){
      console.log(date_from, date_to, supplier);
      $('#ord-table').DataTable({
        
     
        processing: true,
        serverSide: true,
            
        ajax:{
         url: "/inventory/displayOrders",
         data:{
           date_from:date_from,
           date_to:date_to,
           supplier:supplier
         } 
        }, 
        
        columns:[       
         {data: 'po_num', name: 'po_num'},
         {data: 'product_code', name: 'product_code'},
         {data: 'description', name: 'description'},   
         {data: 'supplierName', name: 'supplierName'},     
         {data: 'category_name', name: 'category_name'}, 
         {data: 'unit', name: 'unit'},  
         {data: 'qty_order', name: 'qty_order'},
         {data: 'amount', name: 'amount'},
         {data: 'date', name: 'date'},
         {data: 'status', name: 'status',orderable: false},
        ]
        
       });
      
    }


    $('#ord_supplier').change(function(){
        
      var date_from = $('#date_from').val()
      var date_to = $('#date_to').val();
      var supplier = $('#ord_supplier option').filter(':selected').text();
      console.log(date_from, date_to, supplier);
      $('#ord-table').DataTable().destroy();
      fetch_orders(date_from, date_to, supplier);

    });

    $('#date_from').change(function(){

      var date_from = $('#date_from').val()
      var date_to = $('#date_to').val();
      var supplier = $('#ord_supplier option').filter(':selected').text();
      console.log(date_from);
      $('#ord-table').DataTable().destroy();
      fetch_orders(date_from, date_to, supplier);
    });

    $('#date_to').change(function(){

      var date_from = $('#date_from').val()
      var date_to = $('#date_to').val();
      var supplier = $('#ord_supplier option').filter(':selected').text();
      console.log(date_to);
      $('#ord-table').DataTable().destroy();
      fetch_orders(date_from, date_to, supplier);
    });

    
    //show product details
    $(document).on('click', '#btn-add-order', function(){
      var product_code = $(this).attr('product-code');
      $('#po_qty_order').val('');
      $('#po_amount').text('₱0');
    
        $.ajax({
          url:"/inventory/purchaseorder/show/"+product_code,
          type:"POST",
    
              success:function(response){
               console.log(response);
               $('#po_product_code').val(response[0].product_code);
               $('#po_description').val(response[0].description);
               $('#po_category').val(response[0].category_name);
               $('#po_unit').val(response[0].unit);
               $('#po_qty').val(response[0].qty);
               $('#po_price').val(response[0].orig_price);
               $('#po_supplier').val(response[0].supplierName);
              }
         });
    
    });

    //compute amount
    $('#po_qty_order').keyup(function(){
      var qty = $(this).val();

      var unit_price = $('#po_price').val();
      var amount = qty * unit_price;
      $('#po_amount').text('₱'+amount);
      
    
    });


    function getTotalPOAmount(){
      
      $.ajax({
        url:"/inventory/order/totalamount",
        type:"GET",
  
            success:function(response){
              console.log(response)
              $('#txt_po_total').text(response);
            }
       });
    }

    //add to order
    $(document).on('click', '#btn-add-to-order', function(){

      var product_code = $('#po_product_code').val();
      var description = $('#po_description').val();
      var category = $('#po_category').val();
      var unit = $('#po_unit').val();
      
      var supplier = $('#po_supplier').val();
      var qty_order = $('#po_qty_order').val();
      var price = $('#po_price').val();
      var amount = $('#po_amount').text().slice(1);

      isDifferentSupplier(product_code, description, category, unit, supplier, qty_order, price, amount);
            
    });

    function isDifferentSupplier(product_code, description, category, unit, supplier, qty_order, price, amount) {
      $.ajax({
        url:"/inventory/po/get_po_supplier",
        type:"GET",
  
            success:function(response){
              console.log(response)
              if(response == supplier || response == ''){ 
                  addToOrder(product_code, description, category, unit, supplier, qty_order, price, amount);
              }
              else{
                alert('You already have a pending order from another supplier that is waiting to be sent.\nSend the order first before ordering from another supplier..');
              }
            }
       });
    }

    function addToOrder(product_code, description, category, unit, supplier, qty_order, price, amount) {
      $.ajax({
        url:"/inventory/purchaseorder/addToOrder",
        type:"POST",
        data:{
          product_code:product_code,
          description:description,
          category:category,
          unit:unit,
          qty_order:qty_order,
          price:price,
          supplier:supplier,
          amount:amount
        },
        beforeSend:function(){
          $('#btn-add-to-order').text('Adding...');
          $('.loader').css('display', 'inline');
        },
            success:function(response){
             
                setTimeout(function(){
                  $('.update-success-validation').css('display', 'inline');
                  $('#btn-add-to-order').text('Add to Order');
                  $('.loader').css('display', 'none');
                  setTimeout(function(){
                    $('.update-success-validation').fadeOut('slow');
     
                  },2000);
                
                },1000);
              }          
       });
    }


    $(document).on('click','#btn-remove-order',function(){
      var product_code = $(this).attr('delete-id');
      console.log('remove');
      $.ajax({
        url:"/inventory/order/remove/"+product_code,
        type:"POST",

        success:function(){
          $("#order-table").load( "purchaseorder #order-table" );
          getTotalPOAmount();
          }   

       });
    });

    //show orders           
    $('#btn-show-orders').click(function(){
      $('.text-danger').css('display', 'none');
        $("#order-table").load( "purchaseorder #order-table" );
        
    getTotalPOAmount();
  
   /*  $.ajax({
          url:"/filterSupplier/" + supplier_id,
          type:"POST",
  
              success:function(r){
                  console.log(r['data']);
                  for (i = 0; i < r['data'].length; i++) {
                    var row = $('<tr><td>' + r['data'][i].description+ '</td><td>' 
                                            + r['data'][i].category_name+ '</td><td>' 
                                            + r['data'][i].unit+ '</td></tr>');
                    $('#order-table tbody').html(row);
                  }
                }          
       
    */
    });

    //get supplier's email when change
    $('#ro_supplier').change(function(){
      supplier_id = $(this).val();
      console.log(supplier_id);
      $.ajax({
        url:"/getSupplierEmail/" + supplier_id,
        type:"POST",

            success:function(response){
              // console.log(response);
                $('#supplier_email').val(response);
              }          
       });
    });


    //print pdf
    $('#btn-print-order').click(function(){  

      window.open('/inventory/order/print', '_blank'); 
   
    });

    //download pdf 
    $('#btn-download-order').click(function(){  

        window.open('/inventory/order/downloadOrderPDF', '_blank'); 
   
    });

 /*add record
 $('#btn-add-record').click(function(){
     
  $.ajax({
    url:"/inventory/addRecord",
    type:"POST",
 
    beforeSend:function(){
      $('.loader').css('display', 'inline');
    },
        success:function(response){
         
          setTimeout(function(){
            $('.update-success-validation').css('display', 'inline');
            $('.loader').css('display', 'none');
            setTimeout(function(){
              $('.update-success-validation').fadeOut('slow');
   

            },2000);
          
          },1000);

          }          
   });
}); */

    //send order
    $('#btn-send-order').click(function(){
     
      var supplier_email = $('#supplier_email').val();

      if(supplier_email == ''){
        $('.text-danger').css('display', 'block');
      }
      else{
        $.ajax({
          url:"/sendorder",
          type:"GET",
          data:{
            supplier_email:supplier_email
          },
       
          beforeSend:function(){
            $('#btn-send-order').text('Sending...');
            $('.loader').css('display', 'inline');
          },
              success:function(response){
                $('#ord-table').DataTable().ajax.reload();
                setTimeout(function(){
                  $('#ord-table').DataTable().ajax.reload();
                  $('.update-success-validation').css('display', 'inline');
                  $('#btn-send-order').text('Send Order');
                  $('.loader').css('display', 'none');
                  setTimeout(function(){
                    $('.update-success-validation').fadeOut('slow');
     
                  },2000);
                
                },1000);

                $("#order-table").load( "purchaseorder #order-table" );
                getTotalPOAmount();
  
                }          
         });
      }
     
    });

 //send order
 $('#btn-pay').click(function(){
     
  $.ajax({
    url:"/pay",
    type:"POST",
 
        success:function(response){
            console.log(response);
            console.log('test');
          }          
   });
});

});
    