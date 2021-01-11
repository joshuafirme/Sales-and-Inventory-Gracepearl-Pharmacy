
$(document).ready(function(){
   
   load_data();

   function load_data()  {
      var date_from = $('#date_from').val()
      var date_to = $('#date_to').val();

      fetchStockAdjustment(date_from, date_to);
   }  

   function fetchStockAdjustment(date_from, date_to){

    $('#stockadjustment-report-table').DataTable({
    
       processing: true,
       serverSide: true,
       bPaginate: false,

       ajax: '/path/to/script',
       scrollY: 530,
       scroller: {
           loadingIndicator: true
       },
     
       ajax:{
        url: "/reports/stockadjustment",
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
        {data: 'unit', name: 'unit'},     
        {data: 'supplierName', name: 'supplierName'},    
        {data: 'qtyToAdjust', name: 'qtyToAdjust'},
        {data: 'action', name: 'action'},
        {data: 'remarks', name: 'remarks',orderable: false},
        {data: 'created_at', name: 'created_at',orderable: false},
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
            title: 'Stock Adjustment Report',
            messageTop: getDate()
        },
        {
            extend: 'pdf',
            title: 'Stock Adjustment Report',
            messageTop: getDate()
        },
        {
            extend: 'csv',
            title: 'Stock Adjustment Report',
            messageTop: getDate()
        },
        {
            extend: 'print',
            text: '<em>P</em>rint',
            key: {
                key: 'p',
                altkey: true
            },
            
            title: 'Stock Adjustment Report',
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

      $('#stockadjustment-report-table').DataTable().destroy();
      fetchStockAdjustment(date_from, date_to);
   });

   $('#date_to').change(function()
   {
      var date_from = $('#date_from').val()
      var date_to = $('#date_to').val();

      $('#stockadjustment-report-table').DataTable().destroy();
      fetchStockAdjustment(date_from, date_to);
   });

  function getDate() {
    var d = new Date();

    var month = d.getMonth()+1;
    var day = d.getDate();
    
    return date = d.getFullYear() + '/' +
        (month<10 ? '0' : '') + month + '/' +
        (day<10 ? '0' : '') + day;
  }
   

  });
  