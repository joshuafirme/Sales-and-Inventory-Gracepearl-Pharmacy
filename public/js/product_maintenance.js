
$(document).ready(function(){

  fetch_data();

  function pad (str, max) {
    str = str.toString();
    return str.length < max ? pad("0" + str, max) : str;
  }

  function fetch_data(category){
    var table = $('#product-table').DataTable({
   
      processing: true,
      serverSide: true,
      
     
      ajax:{
       url: "/maintenance/product",
       data: {category:category}
      }, 
      
       
      columns:[       
       {data: 'productCode', name: 'productCode'},
       {data: 'description', name: 'description'},
       {data: 'qty', name: 'qty'},
       {data: 're_order', name: 're_order'},
       {data: 'orig_price',name: 'orig_price'},
       {data: 'selling_price',name: 'selling_price'},      
       {data: 'exp_date',name: 'exp_date'},
       {data: 'action', name: 'action',orderable: false},
      ]
      
     });
     
  
     $('#filter_category').change(function(){
      var category_id = $('#filter_category').val();
 
      $('#product-table').DataTable().destroy();
     
      fetch_data(category_id);

      });

    

       

        // delete product alert
        var product_id, product_name;
        $(document).on('click', '#delete-product', function(){
            row = $(this).closest("tr")
            product_id = $(this).closest("tr").find('td:eq(0)').text();
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
                  },
                  success:function(data){
                      setTimeout(function(){
                          $('#product_ok_button').text('Delete');
                          $('#proconfirmModal').modal('hide');
                          row.fadeOut(500, function () {
                            table.row(row).remove().draw()
                            
                            });
                         
                      }, 1000);
                  }
              });
            
          });
  
  }
  

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


      $('#orig_price').keyup(function(){
        var orig_price = $(this).val();
        var markup = orig_price * 0.10;
        var result =  parseInt(orig_price) + markup;
        $('#selling_price').val(result);
      });

      $('#edit_orig_price').keyup(function(){
        var orig_price = $(this).val();
        var markup = orig_price * 0.10;
        var result =  parseInt(orig_price) + markup;
        $('#edit_selling_price').val(result);
      });



    
  

 

});



/*$(document).on('click', '#btn-edit-product-maintenance', function(){
  var productCode = $(this).attr('show-productCode-mntnc');
  
  $('#edit_category_name').val('');

  $.ajax({
    url:"/maintenance/product/show/"+productCode,
    type:"POST",
    data:{productCode:productCode},
    success:function(response){
      $('#edit_category_name').val('');
      console.log(response);
      $('#edit_description').val(response[0].description);
      $('#edit_category_name').text(response[0].category_name);
      $('#edit_supplier_name').text(response[0].supplierName);

    //  $(".category_name option[value="+response[0].categoryID+"]").remove();
      
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
});  */


  
/*
      $('#filter_category').change(function(){
        var category_param = $('#filter_category').find(":selected").text();    

        $.ajax({
          url:"/maintenance/product/filterByCategory/"+category_param,
          type:"GET",
          data:{category_param:category_param},
          beforeSend: function(response){
            console.log(response);
            
              $("tbody").html('<p style="margin:10px; margin-top:30px;"> Fetching data...</p>');
             
          },
          success: function(response){
            setTimeout(function(){
              $("tbody").html('');
              $("tbody").html(response);
            },500)
        
          }
        });

      });



     /* $('#filter-search-product').keyup(function(){
        var search_key = $(this).val();
        $("#product-table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(search_key) > -1)
          });
      }); */
