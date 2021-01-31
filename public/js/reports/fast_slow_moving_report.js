
$(document).ready(function(){
   
    load_data();
 
    function load_data()  {
       var date_from = $('#date_from').val()
       var date_to = $('#date_to').val();
 
       fetchFastAndSlowMoving(date_from, date_to);
    }  
 
    function fetchFastAndSlowMoving(date_from, date_to){
 
     $('#fast-and-slow-report-table').DataTable({
     
        processing: true,
        serverSide: true,
        bPaginate: false,
 
        ajax: '/path/to/script',
        scrollY: 530,
        scroller: {
            loadingIndicator: true
        },
      
        ajax:{
         url: "/reports/fastAndSlowMoving",
         type:"GET",
         data:{
           date_from:date_from,
           date_to:date_to,
         },
        }, 
        
        columns:[       
            {data: 'product_code', name: 'product_code'},
            {data: 'description', name: 'description'},
            {data: 'category_name', name: 'category_name'},         
            {data: 'frequency', name: 'frequency'},  
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
             title: 'Fast and Slow Moving Report',
             messageTop: getDate()
         },
         {
             extend: 'pdf',
             title: 'Fast and Slow Moving Report',
             messageTop: getDate()
         },
         {
             extend: 'csv',
             title: 'Fast and Slow Moving Report',
             messageTop: getDate()
         },
         {
             extend: 'print',
             text: '<em>P</em>rint',
             key: {
                 key: 'p',
                 altkey: true
             },
             
             title: 'Fast and Slow Moving Report',
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

    $('#date_from').change(function()
    {
       var date_from = $('#date_from').val()
       var date_to = $('#date_to').val();
 
       $('#fast-and-slow-report-table').DataTable().destroy();
       fetchFastAndSlowMoving(date_from, date_to);
    });
 
    $('#date_to').change(function()
    {
       var date_from = $('#date_from').val()
       var date_to = $('#date_to').val();
       console.log(date_to);
       $('#fast-and-slow-report-table').DataTable().destroy();
       fetchFastAndSlowMoving(date_from, date_to);
    });
 
   function getDate() {
    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
      
    return 'From ' + date_from +' to '+ date_to;
   }
    
 
   });
   