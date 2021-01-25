                                            
$(document).ready(function(){
   
    load_data();
 
    function load_data()  {
        var date_from = $('#date_from').val()
        var date_to = $('#date_to').val();
        fetchAuditTrail(date_from, date_to);
    }  
 
    function fetchAuditTrail(date_from, date_to){
 
     $('#audit-report-table').DataTable({
     
        processing: true,
        serverSide: true,
        bPaginate: false,
 
        ajax: '/path/to/script',
        scrollY: 530,
        scroller: {
            loadingIndicator: true
        },
      
        ajax:{
         url: "/reports/audittrail",
         type:"GET",
         data:{
            date_from:date_from,
            date_to:date_to
         }
        }, 
        
        columns:[       
            {data: 'name', name: 'name'},
            {data: 'position', name: 'position'},    
            {data: 'module', name: 'module'},  
            {data: 'action', name: 'action', orderable:false},  
            {data: 'date', name: 'date'},  
            {data: 'time', name: 'time'}, 
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
             title: 'Audit Trail Report',
             messageTop: getDate()
         },
         {
             extend: 'pdf',
             title: 'Audit Trail Report',
             messageTop: getDate()
         },
         {
             extend: 'csv',
             title: 'Audit Trail Report',
             messageTop: getDate()
         },
         {
             extend: 'print',
             text: '<em>P</em>rint',
             key: {
                 key: 'p',
                 altkey: true
             },
             
             title: 'Audit Trail Report',
             messageTop: getDate(),                
             customize: function (win){
               $(win.document.body).find('h1').css('text-align', 'center');
               $(win.document.body).css( 'font-size', '10pt' )
                   
             },
         }
     ],
        
       });

       function getDate() {
        var date_from = $('#date_from').val()
        var date_to = $('#date_to').val();
      
        return 'As of ' + date_from +' to '+ date_to;
       }
 
  //end of fetch_sales
  
    }
 



   $('#date_from').change(function()
   {
       var date_from = $('#date_from').val()
       var date_to = $('#date_to').val();

       $('#audit-report-table').DataTable().destroy();
       fetchAuditTrail(date_from, date_to);
   });

  $('#date_to').change(function()
  {
     var date_from = $('#date_from').val()
     var date_to = $('#date_to').val();

     $('#audit-report-table').DataTable().destroy();
     fetchAuditTrail(date_from, date_to);
  });
    
 
   });
   

