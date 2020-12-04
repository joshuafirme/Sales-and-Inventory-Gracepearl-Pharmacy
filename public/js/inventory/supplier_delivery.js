
$(document).ready(function(){

    fetch_purchase_order();
    fetch_delivered();

    function fetch_purchase_order(){
      var po_tbl = $('#po-table').DataTable({
     
        processing: true,
        serverSide: true,
        
       
        ajax:{
         url: "/inventory/delivery/displayPO",
        }, 
        
        columns:[       
         {data: 'po_num', name: 'po_num'},
         {data: 'product_code', name: 'product_code'},
         {data: 'description', name: 'description'},
         {data: 'unit', name: 'unit'},   
         {data: 'category_name', name: 'category_name'},    
         {data: 'supplierName', name: 'supplierName'},    
         {data: 'qty_order', name: 'qty_order'},
         {data: 'amount', name: 'amount'},
         {data: 'date', name: 'date'},
         {data: 'status', name: 'status',orderable: false},
         {data: 'action', name: 'action',orderable: false},
        ]
        
       });
    }

    function fetch_delivered(){
      var supplier_tbl = $('#supplier-delivery-table').DataTable({
     
        processing: true,
        serverSide: true,
       
        ajax:{
         url: "/inventory/delivered",
        }, 
        
        columns:[       
         {data: 'del_num', name: 'del_num'},
         {data: 'po_num', name: 'po_num'},
         {data: 'product_code', name: 'product_code'},
         {data: 'description', name: 'description'},
         {data: 'supplierName', name: 'supplierName'},  
         {data: 'category_name', name: 'category_name'},  
         {data: 'unit', name: 'unit'},        
         {data: 'qty_order', name: 'qty_order'},
         {data: 'qty_delivered', name: 'qty_delivered'},
         {data: 'exp_date', name: 'exp_date'},
         {data: 'date_recieved', name: 'date_recieved'},
         {data: 'remarks', name: 'remarks',orderable: false},
        ]
        
       });
    }

//show
$(document).on('click', '#btn-add-delivery', function(){
    var product_code = $(this).attr('product-code');

    console.log(product_code);
  
    $.ajax({
      url:"/inventory/delivery/show/"+product_code,
      type:"GET",
      data:{
          product_code:product_code
        },
      success:function(response){
        console.log(response);
       
        $('#del_po_num').text(response[0].po_num);
        $('#del_product_code').text(response[0].product_code);
        $('#del_description').text(response[0].description);
        $('#del_supplier').text(response[0].supplierName);
        $('#del_category').text(response[0].category_name);
        $('#del_unit').text(response[0].unit);
        $('#del_qty_ordered').text(response[0].qty_order);
      }
     });
  });


//add deliver
$(document).on('click', '#btn-add', function(){
    var po_num = $('#del_po_num').text();
    var product_code = $('#del_product_code').text();
    var qty_delivered = $('#del_qty_delivered').val();
    var exp_date = $('#del_exp_date').val();
    var date_recieved = $('#del_date_recieved').val();
    var remarks =  $('select[name=del_remarks] option').filter(':selected').text();
  
    console.log(po_num);
    console.log(product_code);
    console.log(qty_delivered);
    console.log(exp_date);
    console.log(date_recieved);
    console.log(remarks);
    $.ajax({
      url:"/inventory/delivery/recordDelivery",
      type:"POST",
      data:{
          po_num:po_num,
          product_code:product_code,
          qty_delivered:qty_delivered,
          exp_date:exp_date,
          date_recieved:date_recieved,
          remarks:remarks
        },
        beforeSend:function(){
            $('#btn-add').text('Adding...');
            $('.loader').css('display', 'inline');
          },
          success:function(response){
            setTimeout(function(){
              $('.update-success-validation').css('display', 'inline');
           //   $('#stockadjustment-table').DataTable().ajax.reload();
              $('#btn-add').text('Add');
              $('.loader').css('display', 'none');
              setTimeout(function(){
                $('.update-success-validation').fadeOut('slow')
               
              },2000);
            
            },1000);
          }
     });
  });


});
    