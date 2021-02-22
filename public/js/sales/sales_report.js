
$(document).ready(function(){
   
    load_data();

   function load_data()  {
      var date_from = $('#sales_date_from').val()
      var date_to = $('#sales_date_to').val();
      var category = $('select[name=sales_category] option').filter(':selected').text();
      var order_type = $('#order_type option').filter(':selected').text();

      computeSales(date_from, date_to, category, order_type);
      fetch_sales(date_from, date_to, category, order_type);
   }  

   
   function salesDate() {
    var date_from = $('#sales_date_from').val()
    var date_to = $('#sales_date_to').val();
    var sales = $('#total-sales').text();
    return '<h3>Total sales: <b>' + sales + '</b></h3> <h5> From ' + date_from +' to '+ date_to + '</h5>';
 }

   function fetch_sales(date_from, date_to, category, order_type){


    $('#sales-report-table').DataTable({
    
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
          category:category,
          order_type:order_type
        },
       }, 
       
       columns:[       
        {data: 'transNo', name: 'transNo'},
        {data: 'sales_inv_no', name: 'sales_inv_no'},
        {data: 'product_code', name: 'product_code'},
        {data: 'description', name: 'description'},
        {data: 'category_name', name: 'category_name'},         
        {data: 'unit', name: 'unit'},      
        {data: 'qty', name: 'qty'},
        {data: 'amount', name: 'amount'},
        {data: 'payment_method', name: 'payment_method'},   
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
            title: 'Gracepearl Pharmacy <br> Sales Report',
            messageTop: salesDate()
        },
        {
            extend: 'pdf',
            title: 'Gracepearl Pharmacy <br> Sales Report',
            messageTop: salesDate()
        },
        {
            extend: 'csv',
            title: 'Gracepearl Pharmacy <br> Sales Report',
            messageTop: salesDate()
        },
        {
            extend: 'print',
            text: '<em>P</em>rint',
            key: {
                key: 'p',
                altkey: true
            },
            
            title: '<p>Gracepearl Pharmacy <br> Sales Report</p><p>'+getCategory()+'</p>',
            messageTop: salesDate(),                
            customize: function (win){
              $(win.document.body).find('h1').css('text-align', 'center');
              $(win.document.body).css( 'font-size', '10pt' )
                  
            },
        }
    ],
       
      });


       function getCategory() {
          let category = $('select[name=sales_category] option').filter(':selected').text();
          if(category == 'All'){
            category = 'All Categories';
          }
          return category
       }
      

    $('.btn-load-records').click(function(){

      //  getTotalSales();
     });
     
     $('.btn-compute-sales').click(function(){
      filterAndCompute();
     });

     $('#sales_date_from').change(function () {
      filterAndCompute();
     });

     $('#sales_date_to').change(function () {
      filterAndCompute();
    });

    $('#sales_category').change(function () {
      filterAndCompute();
    });

    $('#order_type').change(function () {
      filterAndCompute();
    });


    $('#btn-compute-sales').change(function () {
      var date_from = $('#sales_date_from').val()
      var date_to = $('#sales_date_to').val();
      var category = $('select[name=sales_category] option').filter(':selected').text();
      var order_type = $('#order_type option').filter(':selected').text();
      computeSales(date_from, date_to, category, order_type);
    });
    
    function filterAndCompute() {
      var date_from = $('#sales_date_from').val()
      var date_to = $('#sales_date_to').val();
      var category = $('select[name=sales_category] option').filter(':selected').text();
      var order_type = $('#order_type option').filter(':selected').text();

      console.log(order_type);

      $('#sales-report-table').DataTable().destroy();
      computeSales(date_from, date_to, category, order_type);
      fetch_sales(date_from, date_to, category, order_type); 
    }

     function computeSales(date_from, date_to, category, order_type){

      $.ajax({
        url:"/sales/salesreport/compute",
        type:"GET",
        data:{
          date_from:date_from,
          date_to:date_to,
          category:category,
          order_type:order_type
        },
        success:function(data){
  
          $('#total-sales').text(moneyFormat(data));

        }
      });
     }

     function moneyFormat(total)
     {
       var decimal = (Math.round(total * 100) / 100).toFixed(2);
      // var round_off = Math.round((parseInt(parseFloat(decimal)) + Number.EPSILON) * 100) / 100;
       return money_format = parseFloat(decimal).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
     }

  

 //end of fetch_sales
   }

   function computeSales(date_from, date_to, category, order_type){

    $.ajax({
      url:"/sales/salesreport/compute",
      type:"GET",
      data:{
        date_from:date_from,
        date_to:date_to,
        category:category,
        order_type:order_type  
      },
      success:function(data){

        $('#total-sales').text(moneyFormat(data));

      }
    });
   }

   

  });
  