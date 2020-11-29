
$(document).ready(function(){
   
   fetch_sales();

   function fetch_sales(){
     $('#sales-report-table').DataTable({
    
       processing: true,
       serverSide: true,
       
      
       ajax:{
        url: "/sales/displaySales",
       }, 
       
       columns:[       
        {data: 'transactionNo', name: 'transactionNo'},
        {data: 'sales_inv_no', name: 'sales_inv_no'},
        {data: 'product_code', name: 'product_code'},
        {data: 'description', name: 'description'},
        {data: 'unit', name: 'unit'},   
        {data: 'category_name', name: 'category_name'},    
        {data: 'supplierName', name: 'supplierName'},    
        {data: 'qty', name: 'qty'},
        {data: 'amount', name: 'amount'},
        {data: 'date', name: 'date'},
        {data: 'order_from', name: 'order_from',orderable: false},
       ]
       
      });
   }

  });
  