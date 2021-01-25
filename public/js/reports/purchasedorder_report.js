
$(document).ready(function(){
   
    load_data();
 
    function load_data()  {
       var supplier = $('select[name=supplier] option').filter(':selected').text();
       var date_from = $('#date_from').val()
       var date_to = $('#date_to').val();
 
       fetchPO(date_from, date_to, supplier);
    }  
 
    function fetchPO(date_from, date_to, supplier){
 
     $('#po-report-table').DataTable({
     
        processing: true,
        serverSide: true,
        bPaginate: false,
 
        ajax: '/path/to/script',
        scrollY: 530,
        scroller: {
            loadingIndicator: true
        },
      
        ajax:{
         url: "/reports/purchasedorder",
         data:{
           date_from:date_from,
           date_to:date_to,
           supplier:supplier
         },
        }, 
        
        columns:[       
            {data: 'po_num', name: 'po_num'},
            {data: 'product_code', name: 'product_code'},
            {data: 'description', name: 'description'},
            {data: 'unit', name: 'unit'},   
            {data: 'category_name', name: 'category_name'},    
            {data: 'supplierName', name: 'supplierName'},    
            {data: 'qty_order', name: 'qty_order'},
            {data: 'amount', name: 'amount'},
            {data: 'date', name: 'date'},
            {data: 'status', name: 'status',orderable: false},
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
             title: 'Purchased Order Report',
             messageTop: getDate()
         },
         {
             extend: 'pdf',
             title: 'Purchased Order Report',
             messageTop: getDate()
         },
         {
             extend: 'csv',
             title: 'Purchased Order Report',
             messageTop: getDate()
         },
         {
             extend: 'print',
             text: '<em>P</em>rint',
             key: {
                 key: 'p',
                 altkey: true
             },
             
             title: 'Purchased Order Report',
             messageTop: getDate(),                
             customize: function (win){
               $(win.document.body).find('h1').css('text-align', 'center');
               $(win.document.body).css( 'font-size', '10pt' )
                   
             },
         }
     ],
        
       });

       function getDate() {
        var d = new Date();
    
        var month = d.getMonth()+1;
        var day = d.getDate();
        
        return date = d.getFullYear() + '/' +
            (month<10 ? '0' : '') + month + '/' +
            (day<10 ? '0' : '') + day;
      }
 
  //end of fetch_sales
    }

    $('#date_from').change(function()
    {
        var date_from = $('#date_from').val()
        var date_to = $('#date_to').val();
        var supplier = $('select[name=supplier] option').filter(':selected').text();

        $('#po-report-table').DataTable().destroy();
        fetchPO(date_from, date_to, supplier);
    });

   $('#date_to').change(function()
   {
      var date_from = $('#date_from').val()
      var date_to = $('#date_to').val();
      var supplier = $('select[name=supplier] option').filter(':selected').text();

      $('#po-report-table').DataTable().destroy();
      fetchPO(date_from, date_to, supplier);
   });

   $('#supplier').change(function()
   {
      var date_from = $('#date_from').val()
      var date_to = $('#date_to').val();
      var supplier = $('select[name=supplier] option').filter(':selected').text();

      $('#po-report-table').DataTable().destroy();
      fetchPO(date_from, date_to, supplier);
   });
 

    
 
   });
   