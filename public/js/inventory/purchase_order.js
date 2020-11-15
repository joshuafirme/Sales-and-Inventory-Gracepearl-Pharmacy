
$(document).ready(function(){
  $.ajaxSetup({
    headers: {
  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
 });

    fetch_data();
  
    function fetch_data(){
      $('#purchase-order-table').DataTable({
     
        processing: true,
        serverSide: true,
        
       
        ajax:{
         url: "/inventory/purchaseorder",
        }, 
        
         
        columns:[       
         {data: 'productCode', name: 'productCode'},
         {data: 'description', name: 'description'},
         {data: 'unit', name: 'unit'},   
         {data: 'category_name', name: 'category_name'},    
         {data: 'supplierName', name: 'supplierName'},    
         {data: 'qty', name: 'qty'},
         {data: 're_order', name: 're_order'},
         {data: 'action', name: 'action',orderable: false},
        ]
        
       });
  
    }

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
               $('#po_product_code').val(response[0].productCode);
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

    //add to order
    $(document).on('click', '#btn-add-to-order', function(){
      var product_code = $('#po_product_code').val();
      var description = $('#po_description').val();
      var category = $('#po_category').val();
      var unit = $('#po_unit').val();
      
      var supplier = $('#po_supplier').val();
      var qty_order = $('#po_qty_order').val();
      var price = $('#po_price').val();
      var amount = $('#po_amount').text();
    
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
    
    });

    //show orders           
    $('#btn-show-orders').click(function(){
      $( "#order-table" ).load( "purchaseorder #order-table" );

    });

    //print pdf
    $('#btn-print-order').click(function(){  
      console.log('test');
      window.open('/inventory/order/print', '_blank'); 
   
    });

    $('#btn-download-order').click(function(){  
      console.log('test');


        window.open('/inventory/order/downloadOrderPDF', '_blank'); 
   
    });


    //send order
    $('#btn-send-order').click(function(){
     
    
    });



});
    