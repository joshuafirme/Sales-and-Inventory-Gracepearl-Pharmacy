
$(document).ready(function(){

  fetch_data();

  function fetch_data(){
    $('#stockadjustment-table').DataTable({
   
      processing: true,
      serverSide: true,
      
     
      ajax:{
       url: "/maintenance/product",
      }, 
      
       
      columns:[       
       {data: 'productCode', name: 'productCode'},
       {data: 'description', name: 'description'},
       {data: 'qty', name: 'qty'},
       {data: 'exp_date', name: 'exp_date'},
       {data: 'action', name: 'action',orderable: false},
      ]
      
     });
  

  }
  

  
  });
  