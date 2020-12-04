
$(document).ready(function(){
   
    load_data();

   function load_data()  {
      var date_from = $('#sales_date_from').val()
      var date_to = $('#sales_date_to').val();
      var category = $('select[name=sales_category] option').filter(':selected').text();

     fetch_sales(date_from, date_to, category);
     
   }  

   function fetch_sales(date_from, date_to, category){

    var d = new Date();

    var month = d.getMonth()+1;
    var day = d.getDate();
    
    var date = d.getFullYear() + '/' +
        (month<10 ? '0' : '') + month + '/' +
        (day<10 ? '0' : '') + day;

    var sales_table = $('#sales-report-table').DataTable({
    
       processing: true,
       serverSide: true,
       bPaginate: false,

    
       
       ajax: '/path/to/script',
       scrollY: 530,
       scroller: {
           loadingIndicator: true
       },
     
       ajax:{
        url: "/sales/salesreport",
        type:"GET",
        data:{
          date_from:date_from,
          date_to:date_to,
          category:category
        },
       }, 
       
       columns:[       
        {data: 'transNo', name: 'transNo'},
        {data: 'sales_inv_no', name: 'sales_inv_no'},
        {data: 'product_code', name: 'product_code'},
        {data: 'description', name: 'description'},
        {data: 'category_name', name: 'category_name'},         
        {data: 'unit', name: 'unit'},     
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
            text:'nya',       
            title: 'Sales Report',
            messageTop: date
        },
        {
            extend: 'pdf',
            title: 'Sales Report',
            messageTop: date
        },
        {
            extend: 'csv',
            title: 'Sales Report',
            messageTop: date
        },
        {
            extend: 'print',
            text: '<em>P</em>rint',
            key: {
                key: 'p',
                altkey: true
            },
            
            title: 'Sales Report',
            messageTop: date,                
            customize: function (win){
              $(win.document.body).find('h1').css('text-align', 'center');
              $(win.document.body).css( 'font-size', '10pt' )
                  
            },
        }
    ],
       
      });

    $('.btn-load-records').click(function(){

        var date_from = $('#sales_date_from').val()
        var date_to = $('#sales_date_to').val();
        var category = $('select[name=sales_category] option').filter(':selected').text();

        $('#sales-report-table').DataTable().destroy();
        fetch_sales(date_from, date_to, category);
      //  getTotalSales();
     });
     
     $('.btn-compute-sales').click(function(){

        getTotalSales();
     });

     function getTotalSales(){
      var total_sales = sales_table.column(8).data().sum();
      var round_off = Math.round((total_sales + Number.EPSILON) * 100) / 100;
      var money_format = round_off.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return $('#total-sales').text(money_format);
     }

  

 //end of fetch_sales
   }

 
   

  });
  