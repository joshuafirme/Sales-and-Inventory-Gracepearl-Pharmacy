
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
       {data: 'product_code', name: 'product_code'},
       {data: 'description', name: 'description'},
       {data: 'unit', name: 'unit'},
       {data: 'category_name', name: 'category_name'},
       {data: 'supplierName', name: 'supplierName'},
       {data: 'qty', name: 'qty'},
       {data: 'exp_date', name: 'exp_date'},
       {data: 'action', name: 'action',orderable: false},
      ]
      
     });

  }



  //show
$(document).on('click', '#btn-stockad', function(){
  var productCode = $(this).attr('product-code');
  console.log(productCode);
  $('#qty_to_adjust').val('');
  $('#qty_to_adjust').focus();

  $.ajax({
    url:"/inventory/stockadjustment/show/"+productCode,
    type:"POST",
    data:{productCode:productCode},
    success:function(response){
     
      console.log(response);
      $('#product_code_hidden').val(response[0].id_exp);
      $('#product_code').text(response[0].product_code);
      $('#description').text(response[0].description);
      $('#unit').text(response[0].unit);
      $('#category').text(response[0].category_name);
      $('#supplier').text(response[0].supplierName);
      $('#qty').text(response[0].qty);
    }
   });
});


  //adjust
  $(document).on('click', '#btn-adjust', function(){
    var product_code_hidden = $('#product_code_hidden').val();
    var product_code = $('#product_code').text();
    var qty_to_adjust = $('#qty_to_adjust').val();
    var remarks = $('#remarks').val();
    var rdo_addless = $("input[name='rdo-addless']:checked").val();
  
    $.ajax({
      url:"/inventory/stockadjustment/adjust",
      type:"POST",
      data:{
            product_code_hidden:product_code_hidden,
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
  