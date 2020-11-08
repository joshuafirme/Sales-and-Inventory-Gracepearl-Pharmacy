
$(document).ready(function(){

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
         {data: 'supplierName', name: 'supplierName'},    
         {data: 'qty', name: 'qty'},
         {data: 're_order', name: 're_order'},
         {data: 'exp_date', name: 'exp_date'},
         {data: 'action', name: 'action',orderable: false},
        ]
        
       });
  
    }

    
});
    