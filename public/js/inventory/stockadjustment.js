
$(document).ready(function(){

  fetch_data();

  function fetch_data(){
    $('#stockadjustment-table').DataTable({
   
      processing: true,
      serverSide: true,
      
     
      ajax:{
       url: "/inventory/stockadjustment",
      }, 
      
       
      columns:[       
       {data: 'productCode', name: 'productCode'},
       {data: 'description', name: 'description'},
       {data: 'qty', name: 'qty'},
       {data: 'exp_date', name: 'exp_date'},
       {data: 'action', name: 'action',orderable: false},
      ]
      
     });

  }



  //show
$(document).on('click', '#btn-stockad', function(){
  var productCode = $(this).attr('product-code');
  $('#qty_to_adjust').val('');
  $('#remarks').val('');
  console.log(productCode);

  $.ajax({
    url:"/inventory/stockadjustment/show/"+productCode,
    type:"POST",
    data:{productCode:productCode},
    success:function(response){
     
      console.log(response);
      $('#product_code_hidden').val(response[0].id);
      $('#product_code').val(response[0].productCode);
      $('#description').val(response[0].description);
      $('#qty').val(response[0].qty);
    }
   });
});


  //adjust
  $(document).on('click', '#btn-adjust', function(){
    var product_code = $('#product_code_hidden').val();
    var qty_to_adjust = $('#qty_to_adjust').val();
    var remarks = $('#remarks').val();
    var rdo_addless = $("input[name='rdo-addless']:checked").val();
  
    $.ajax({
      url:"/inventory/stockadjustment/adjust",
      type:"POST",
      data:{
            product_code:product_code,
            qty_to_adjust:qty_to_adjust,
            remarks:remarks,
            rdo_addless:rdo_addless,
          },
          beforeSend:function(){
            $('#btn-adjust').text('Adjusting...');
            $('.loader').css('display', 'inline');
          },
          success:function(response){
            setTimeout(function(){
              $('.update-success-validation').css('display', 'inline');
              $('#stockadjustment-table').DataTable().ajax.reload();
              $('#btn-adjust').text('Adjust');
              $('.loader').css('display', 'none');
              setTimeout(function(){
                $('.update-success-validation').fadeOut('slow')
               
              },2000);
            
            },1000);
          }
        });
  });
  

  
  });
  