
$(document).ready(function(){
   
    load_data();
 
    function load_data()  {
       var category = $('select[name=sales_category] option').filter(':selected').text();
 
       fetchSupplierDelivery(category);
    }  
 
    function fetchSupplierDelivery(category){
 
     $('#supplierdelivery-report-table').DataTable({
     
        processing: true,
        serverSide: true,
        bPaginate: false,
 
        ajax: '/path/to/script',
        scrollY: 530,
        scroller: {
            loadingIndicator: true
        },
      
        ajax:{
         url: "/reports/supplierdelivery",
         type:"GET",
         data:{
           category:category
         },
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
        ],
 
        //buttons
        dom: 'Bfrtip',
        initComplete: function () {
         $('.buttons-pdf').html('<span class="fa fa-file-pdf" data-toggle="tooltip" title="Download PDF"/>').css({"background-color": "yellow"})
         $('.buttons-print').html('<span class="fa fa-print" data-toggle="tooltip" title="Print"/>')
         $('.buttons-csv').html('<span class="fa fa-file-csv" data-toggle="tooltip" title="Export To CSV"/>')
         },
        buttons: [
         {
          
             extend: 'excel', 
             text:'nya',       
             title: 'Supplier Delivery Report',
             messageTop: getDate()
         },
         {
             extend: 'pdf',
             title: 'Supplier Delivery Report',
             messageTop: getDate()
         },
         {
             extend: 'csv',
             title: 'Supplier Delivery Report',
             messageTop: getDate()
         },
         {
             extend: 'print',
             text: '<em>P</em>rint',
             key: {
                 key: 'p',
                 altkey: true
             },
             
             title: 'Supplier Delivery Report',
             messageTop: getDate(),                
             customize: function (win){
               $(win.document.body).find('h1').css('text-align', 'center');
               $(win.document.body).css( 'font-size', '10pt' )
                   
             },
         }
     ],
        
       });
 
  //end of fetch_sales
    }
 
    function getDate() {
        var date_from = $('#date_from').val()
        var date_to = $('#date_to').val();
          
        return 'From ' + date_from +' to '+ date_to;
       }
    
 
   });
   