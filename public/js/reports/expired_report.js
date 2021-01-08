                                            
$(document).ready(function(){
   
    load_data();
 
    function load_data()  {
       var category = $('select[name=sales_category] option').filter(':selected').text();
 
       fetchExpiredProduct(category);
    }  
 
    function fetchExpiredProduct(category){
 
     $('#expired-report-table').DataTable({
     
        processing: true,
        serverSide: true,
        bPaginate: false,
 
        ajax: '/path/to/script',
        scrollY: 530,
        scroller: {
            loadingIndicator: true
        },
      
        ajax:{
         url: "/reports/expired",
         type:"GET",
         data:{
           category:category
         },
        }, 
        
        columns:[       
            {data: 'product_code', name: 'product_code'},
            {data: 'description', name: 'description'},
            {data: 'unit', name: 'unit'},    
            {data: 'category_name', name: 'category_name'},  
            {data: 'supplierName', name: 'supplierName'},  
            {data: 'exp_date', name: 'exp_date', orderable:false},
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
             title: 'Expired Products Report',
             messageTop: getDate()
         },
         {
             extend: 'pdf',
             title: 'Expired Products Report',
             messageTop: getDate()
         },
         {
             extend: 'csv',
             title: 'Expired Products Report',
             messageTop: getDate()
         },
         {
             extend: 'print',
             text: '<em>P</em>rint',
             key: {
                 key: 'p',
                 altkey: true
             },
             
             title: 'Expired Products Report',
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
     var d = new Date();
 
     var month = d.getMonth()+1;
     var day = d.getDate();
     
     return date = d.getFullYear() + '/' +
         (month<10 ? '0' : '') + month + '/' +
         (day<10 ? '0' : '') + day;
   }
    
 
   });
   