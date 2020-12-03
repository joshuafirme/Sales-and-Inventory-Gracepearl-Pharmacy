
$(document).ready(function(){

    fetch_purchase_order();

    function fetch_purchase_order(){
      var po_tbl = $('#po-table').DataTable({
     
        processing: true,
        serverSide: true,
        lengthChange: false,
        
       
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


});
    