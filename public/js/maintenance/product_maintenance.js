
$(document).ready(function(){

  fetch_data();

  function fetch_data(category){
   var product_table = $('#product-table').DataTable({
   
      processing: true,
      serverSide: true,
     
      ajax:"/maintenance/product",
 
      data: {category:category}, 
          
      columns:[       
       {data: 'productCode', name: 'productCode'},
       {data: 'description', name: 'description'},
       {data: 'category_name', name: 'category_name'},
       {data: 'unit', name: 'unit'},
       {data: 'qty', name: 'qty'},
       {data: 're_order', name: 're_order'},
       {data: 'orig_price',name: 'orig_price'},
       {data: 'selling_price',name: 'selling_price'},      
       {data: 'exp_date',name: 'exp_date'},
       {data: 'action', name: 'action',orderable: false},
      ]
     });

     $('#filter_category').change(function(){
      var category = $('#filter_category').val();

      if(category=='All'){
        $('#product-table').DataTable().destroy();
        fetch_data();
      }

      product_table.column( $(this).data('column') )
      .search( $(this).val() )
      .draw();
  
      });
  }




  // delete product alert
  var product_id, product_name;
  $(document).on('click', '#delete-product', function(){
      row = $(this).closest("tr")
      product_id = $(this).attr('delete-id');
      console.log(product_id);
      product_name =  $(this).closest("tr").find('td:eq(1)').text();
      $('#proconfirmModal').modal('show');
      $('.delete-message').html('Are you sure do you want to delete <b>'+ product_name +'</b>?');
    }); 
    
    $.ajaxSetup({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
    
    $('#product_ok_button').click(function(){
        $.ajax({
            url: '/maintenance/product/delete/'+ product_id,
            type: 'DELETE',
          
            beforeSend:function(){
                $('#product_ok_button').text('Deleting...');
                $('.loader').css('display', 'inline');
            },
            success:function(data){
                setTimeout(function(){
                    $('#product_ok_button').remove();
                    $('.delete-message').remove();
                    $('.delete-success').show();
                    $('.cancel-delete').text('Ok');
                    $('.loader').css('display', 'none');
                   // $('#proconfirmModal').modal('hide');
                    row.fadeOut(500, function () {
                      table.row(row).remove().draw()
                      
                      });
                   
                }, 1000);
            }
        });
      
    });
  

      $('#btn-pdf').click(function(){
        var filter_category = $('#filter_category').find(":selected").text();    
          $.ajax({
            url:"/maintenance/product/getCategoryParam/{filter_category}",
            type:"POST",
            data:{filter_category:filter_category},
            success:function(response){
              console.log(response);
              window.open('/maintenance/product/pdf/'+response, '_blank'); 
            }
           });
     
      });

     

      function getMarkup(id){
        $.ajax({
          url:"/getCompanyMarkup/"+id,
          type:"POST",
          success:function(response){
            console.log(response);
            $('#discount_hidden').val(response[0].markup);
          }
         });
        
      }


      $('#orig_price').keyup(function(){
        var id = $('#supplier_name').val();
        console.log(id);
        getMarkup(id);
        var orig_price = $(this).val();
        var percentage = $('#discount_hidden').val();
        console.log(percentage);
        var diff = orig_price * percentage;
        var markup =  parseFloat(orig_price) + diff;
        $('#selling_price').val(markup);
      });

      $('#edit_orig_price').keyup(function(){
        var id = $('#supplier_name').val();
        getMarkup(id);
        var orig_price = $(this).val();
        var percentage = $('#discount_hidden').val();
        console.log(percentage);
        var diff = orig_price * percentage;
        var markup =  parseFloat(orig_price) + diff;
        $('#edit_selling_price').val(markup);
      });

//edit show
$(document).on('click', '#btn-edit-product-maintenance', function(){
  var productCode = $(this).attr('product-code');
  
  console.log(productCode);
  $('#edit_unit').val('');
  $('#edit_category_name').val('');
  $('#edit_supplier_name').val('');

  $.ajax({
    url:"/maintenance/product/show/"+productCode,
    type:"POST",
    data:{productCode:productCode},
    success:function(response){
     
      console.log(response);
      $('#product_code_hidden').val(response[0].id);
      $('#product_code').val(response[0].productCode);
      $('#edit_description').val(response[0].description);
      $('#edit_unit').text(response[0].unit);
      $('#edit_category_name').text(response[0].category_name);
      $('#edit_supplier_name').text(response[0].supplierName);

      $(".edit_unit option[value="+response[0].unitID+"]").remove();
      $(".category_name option[value="+response[0].categoryID+"]").remove();
      $(".supplier_name option[value="+response[0].supplierID+"]").remove();
      
      $('#edit_unit').val(response[0].unitID);
      $('#edit_category_name').val(response[0].categoryID);
      $('#edit_supplier_name').val(response[0].supplierID);
      $('#edit_qty').val(response[0].qty);
      $('#edit_re_order').val(response[0].re_order);
      $('#edit_orig_price').val(response[0].orig_price);
      $('#edit_selling_price').val(response[0].selling_price);
      $('#edit_exp_date').val(response[0].exp_date);

      var img_source = "{{asset('storage/'"+response[0].image+")}}";
      $('#edit_img_view').attr('src', img_source);
    }
   });
});  


    //update 
$('#update-product-maintenance').click(function(){
  var id = $('#product_code_hidden').val(); 
  console.log(product_code);
  var description = $('#edit_description').val(); 
  var unit = $('select[name=edit_unit] option').filter(':selected').val();
  var category_name = $('select[name=edit_category_name] option').filter(':selected').val();
  console.log(category_name);
  var supplier_name = $('select[name=edit_supplier_name] option').filter(':selected').val();
  var re_order = $('#edit_re_order').val();
  var orig_price = $('#edit_orig_price').val();
  var selling_price = $('#edit_selling_price').val();
  var exp_date = $('#edit_exp_date').val();

  $.ajaxSetup({
    headers: {
  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
 });

    $.ajax({
      url:"/maintenance/updateproduct/"+id,
      type:"POST",

      data:{
            description:description,
            unit:unit,
            category_name:category_name,
            supplier_name:supplier_name,
            re_order:re_order,
            orig_price:orig_price,
            selling_price:selling_price,
            exp_date:exp_date
          },

          beforeSend:function(){
            $('#update-product-maintenance').text('Updating...');
            $('.loader').css('display', 'inline');
          },
          success:function(response){
            setTimeout(function(){
              $('.update-success-validation').css('display', 'inline');
              $('#product-table').DataTable().ajax.reload();
              $('#update-product-maintenance').text('Update');
              $('.loader').css('display', 'none');
              setTimeout(function(){
                $('.update-success-validation').fadeOut('slow')
               
              },2000);
            
            },1000);
           
            
          }
     });

});
  

 

});




