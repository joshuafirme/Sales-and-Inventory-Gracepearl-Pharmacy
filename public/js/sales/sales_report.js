
$(document).ready(function(){
   
  fetch_sales();

   function fetch_sales(date_from, date_to){
    console.log(date_from);
    console.log(date_to);

    var d = new Date();

    var month = d.getMonth()+1;
    var day = d.getDate();
    
    var output = d.getFullYear() + '/' +
        (month<10 ? '0' : '') + month + '/' +
        (day<10 ? '0' : '') + day;

    $('#sales-report-table').DataTable({
       processing: true,
       serverSide: true,
     
       ajax:{
        url: "/sales/displaySalesByDate",
        data:{
          date_from:date_from,
          date_to:date_to
        },
       }, 
       
       columns:[       
        {data: 'transNo', name: 'transNo'},
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
            title: 'Sales Report',
            messageTop: output
        },
        {
            extend: 'pdf',
            title: 'Sales Report',
            messageTop: output
        },
        {
          extend: 'csv',
          title: 'Sales Report',
          messageTop: output
        },
        {
            extend: 'print',
            text: '<em>P</em>rint',
            key: {
                key: 'p',
                altkey: true
            },
            title: 'Sales Report',
            messageTop: output,         
            customize: function (win){
              $(win.document.body).find('h1').css('text-align', 'center');
              $(win.document.body).css( 'font-size', '10pt' )
                  
            },
        }
    ],
       
      });

    $('#sales_date_from').change(function() {
      var date_from = $(this).val()
      var date_to = $('#sales_date_to').val();
    //  console.log(date_from +' to '+ date_to);

      $('#sales-report-table').DataTable().destroy();
      fetch_sales(date_from, date_to)

      
    });

    $('#sales_date_to').change(function() {
      var date_to = $(this).val()
      var date_from = $('#sales_date_from').val();
   //   console.log(date_from +' to '+ date_to);

      $('#sales-report-table').DataTable().destroy();
      fetch_sales(date_from, date_to)
    });

 //end of fetch_sales
   }

   

  });
  