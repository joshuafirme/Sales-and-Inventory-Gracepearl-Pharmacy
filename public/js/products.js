
$(document).ready(function(){

    fetch_data();
  
    function fetch_data(){
      $('#productsearch-table').DataTable({
     
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 530,
        scroller: {
            loadingIndicator: true
        },
       
        ajax:{
         url: "/products",
        }, 
        
         
        columns:[       
         {data: 'product_code', name: 'product_code'},
         {data: 'description', name: 'description'},
         {data: 'category_name', name: 'ategory_name'},
         {data: 'unit', name: 'unit'},
         {data: 'supplierName', name: 'supplierName'},
         {data: 'qty', name: 'qty'},
         {data: 'selling_price',name: 'selling_price'},      
         {data: 'exp_date',name: 'exp_date'},
        ]
        
       });
       
   
    }

  });
  
  
  
  
  