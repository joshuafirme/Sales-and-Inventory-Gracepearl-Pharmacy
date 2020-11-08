
$(document).ready(function(){

    fetch_data();
  
    function fetch_data(){
      $('#near-expiry-table').DataTable({
     
        processing: true,
        serverSide: true,
        
       
        ajax:{
         url: "/inventory/notification",
        }, 
        
         
        columns:[       
         {data: 'productCode', name: 'productCode'},
         {data: 'description', name: 'description'},
         {data: 'unit', name: 'unit'},    
         {data: 'category_name', name: 'category_name'},
         {data: 'exp_date', name: 'exp_date'},
        ]
        
       });

       $('#expired-product-table').DataTable({  
        processing: true,
        serverSide: true,
        ajax:{
          url: "/inventory/notification",
        }, 
        
         
        columns:[       
         {data: 'productCode', name: 'productCode'},
         {data: 'description', name: 'description'},
         {data: 'unit', name: 'unit'},    
         {data: 'category_name', name: 'category_name'},
         {data: 'exp_date', name: 'exp_date'},
        ]
        
       });

    }

    $('#expired-tab').click(function(){
      
    
  });
    
});
    