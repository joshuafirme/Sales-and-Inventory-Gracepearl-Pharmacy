/*
$(document).ready(function(){
  $.ajaxSetup({
    headers: {
     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
    fetch_data();
    expiredProduct();
  
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
  
    }
   

    function expiredProduct(){
      
      $('#expired-table').DataTable({
     
        processing: true,
        serverSide: true,
            
        ajax:'/inventory/notification/expired',
       
        
        columns:[       
          {data: 'productCode', name: 'productCode'},
          {data: 'description', name: 'description'},
          {data: 'unit', name: 'unit'},    
          {data: 'category_name', name: 'category_name'},
          {data: 'exp_date', name: 'exp_date'},
        ]
        
       });
    }

    
}); */
    