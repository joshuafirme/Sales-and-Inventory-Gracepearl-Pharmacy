
$(document).ready(function(){

  fetch_data();
  var highlights = CKEDITOR.replace( 'highlights' );
  var edit_highlights = CKEDITOR.replace( 'edit_highlights' );
  

  function fetch_data(category){
   var product_table = $('#product-table').DataTable({
   
      processing: true,
      serverSide: true,
      ajax: '/path/to/script',
      scrollY: 470,
      scroller: {
          loadingIndicator: true
      },
     
      ajax:"/maintenance/product",
 
      data: {category:category}, 

      columnDefs: [{
        targets: 0,
        searchable: false,
        orderable: false,
        changeLength: false,
        className: 'dt-body-center',
        render: function (data, type, full, meta){
            return '<input type="checkbox" name="checkbox[]" value="' + $('<div/>').text(data).html() + '">';
        }
     }],
     order: [[1, 'asc']],
          
      columns:[       
       {data: 'id_exp', name: 'id_exp'},
       {data: 'product_code', name: 'product_code'},
       {data: 'description', name: 'description'},
       {data: 'category_name', name: 'category_name'},
       {data: 'unit', name: 'unit'},
       {data: 'supplierName', name: 'supplierName'},
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

      $('#select-all-product').on('click', function(){
        var rows = product_table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });
    
        $('#product-table tbody').on('change', 'input[type="checkbox"]', function(){
          if(!this.checked){
             var el = $('#select-all-product').get(0);
             if(el && el.checked && ('indeterminate' in el)){
                el.indeterminate = true;
             }
          }
       });
  }

  $('#btn-bulk-archive').click(function(){

    var id = [];

    $(':checkbox:checked').each(function(i){
      id[i] = $(this).val();
    });

    if(id.length > 0){
      
        if($('#select-all-product').is(":checked")){
          //used slice method to start index at 1, so the value of sellect_all checkbox is not included in array
          id = id.slice(1).join(", ");
          console.log(id);
        }
        else{
          id = id.join(", ");
          console.log(id);
        }
    
        $.ajax({
          url:"/maintenance/product/bulk-archive/"+id,
          type:"POST",
          beforeSend:function(){
            $('.loader').css('display', 'inline');
            $('#btn-bulk-archive').text('Please wait...');
          },
          success:function(){
    
            setTimeout(function(){
              $('#product-table').DataTable().ajax.reload();
              $('.loader').css('display', 'none');
              $('#btn-bulk-archive').text('Archive');
              },1000);
          
          }
        });
    }
    else{
        alert('No data selected!')       
    }
});

  //add product
  $('#btn-add-product').click(function(){
    var summernote_val = $('#summernote').summernote('code');
    var image = $('#image')[0].files;
    console.log(image);
    console.log(summernote_val);
    $.ajax({
      url:"/maintenance/product/store",
      type:"POST",
      data:{
        summernote_val:summernote_val
      },
      success:function(response){
        console.log(response);

      }
     });
  });


  // delete product alert
  var id_exp, product_id, product_name;
  $(document).on('click', '#delete-product', function(){
      row = $(this).closest("tr")
      id_exp = $(this).attr('delete-id');
      product_id = $(this).attr('product-id');
      console.log(id_exp+' '+product_id);
      product_name =  $(this).closest("tr").find('td:eq(1)').text();
      $('#proconfirmModal').modal('show');
      $('.delete-success').hide();
      $('.delete-message').html('Are you sure do you want to archive <b>'+ product_name +'</b>?');
    }); 
    
    $.ajaxSetup({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
    
    $('#product_ok_button').click(function(){
        $.ajax({
            url: '/maintenance/product/delete',
            type: 'POST',
            data:{
              id_exp:id_exp,
              product_id:product_id
            },
          
            beforeSend:function(){
                $('#product_ok_button').text('Deleting...');
                $('.loader').css('display', 'inline');
            },
            
            success:function(response){
              console.log(response);
              console.log(id_exp+' '+product_id);
                setTimeout(function(){
                    $('.delete-success').show();
                    $('.loader').css('display', 'none');
                    $('#product_ok_button').text('Delete');
                    row.fadeOut(500, function () {
                      table.row(row).remove().draw() 
                      });
                      setTimeout(function(){
                        $('#proconfirmModal').modal('hide');
                    }, 1000);
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

      //when branded and generic selected, the "with prescription" appeared
      $('#category_name').change(function(){
        category =  $('select[name=category_name] option').filter(':selected').text();

        showWithPrescriptionRadio(category);  
      });

      $('select[name=edit_category_name]').change(function(){
        category =  $('select[name=edit_category_name] option').filter(':selected').text();

        showWithPrescriptionRadio(category);  
      });

      function showWithPrescriptionRadio(category) {
        if(category == 'Branded' || category == 'Generic'){
          $('.with-prescription').css('display', 'block');
        }
        else{
          $('input[name ="edit_with_prescription"]').val('no');
          $('input[name ="with_prescription"]').val('no');
          $('.with-prescription').css('display', 'none');
        } 
        
      }

      function getCompanyID(supplierID){
        $.ajax({
          url:"/getCompanyID/"+supplierID,
          type:"POST",
          success:function(response){
           //used companyID parameter to get company markup
           getCompanyMarkup(response[0].companyID)
          }
         });
        
      }

      function getCompanyMarkup(companyID){
        $.ajax({
          url:"/maintenance/company/getCompanyMarkup/"+companyID,
          type:"POST",
          success:function(response){
            //get the result from url and pass it to discount_hidden input
           $('#discount_hidden').val(response[0].markup);
           $('#edit_discount_hidden').val(response[0].markup);

           var markup = computeMarkup();
           var edit_markup = editComputeMarkup();
           $('#selling_price').val(markup);
           $('#edit_selling_price').val(edit_markup);
          }
         });
      }

      function computeMarkup(){
        var orig_price = $('#orig_price').val();
        var percentage = $('#markup').val();
        var diff = orig_price * percentage;
        var markup =  parseFloat(orig_price) + diff;
        $('#selling_price').val(markup);
        return moneyFormat(markup);
      }

      function editComputeMarkup(){
        var orig_price = $('#edit_orig_price').val();
        var percentage = $('#edit_markup').val();
        var diff = orig_price * percentage;
        var markup =  parseFloat(orig_price) + diff;
        $('#edit_selling_price').val(markup);
        return moneyFormat(markup);
      }
      
      $('#markup').keyup(function(){
          computeMarkup();
      });

      $('#edit_markup').keyup(function(){
        editComputeMarkup();
      });

   //   $('#supplier_name').change(function(){
  //      var supplierID = $(this).val();
//        getCompanyID(supplierID);
     
 //     });

 //     $('#edit_supplier_name').change(function(){
  //      var supplierID = $(this).val();
 //       getCompanyID(supplierID);
     
 //     });


      $('#orig_price').keyup(function(){
  //     var supplierID = $('#supplier_name').val();
  //      getCompanyID(supplierID);

        var markup = computeMarkup();
        $('#selling_price').val(markup);
      });

      $('#edit_orig_price').keyup(function(){
 //       var supplierID = $('#edit_supplier_name').val();
  //      getCompanyID(supplierID);

        var markup = editComputeMarkup();
        $('#edit_selling_price').val(markup);
      });

      function moneyFormat(total)
      {
        return (Math.round(total * 100) / 100).toFixed(2);
       // var round_off = Math.round((parseInt(parseFloat(decimal)) + Number.EPSILON) * 100) / 100;
      }
      
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
      $('#id_exp').val(productCode);
      $('#product_code_hidden').val(response[0].id);
      $('#product_code').val(response[0].product_code);
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
      $('#edit_markup').val(response[0].markup);
      $('#edit_selling_price').val(response[0].selling_price);
      $('#edit_exp_date').val(response[0].exp_date);
      edit_highlights.setData(response[0].highlights);
      
      showWithPrescriptionRadio(response[0].category_name); 

      if(response[0].image !== null){
        var img_source = '../../storage/'+response[0].image;
      }
      else{
        var img_source = '../assets/noimage.png';
      }
    
      $('#img_view').attr('src', img_source);

      if(response[0].with_prescription == 'yes'){
        $("#rdo_prescription_yes").prop("checked", true);
      }
      else{
        $("#rdo_prescription_no").prop("checked", true);
      }
    }
   });
});  


    //update 
$('#update-product-maintenance').click(function(){
  var id = $('#product_code_hidden').val(); 

  var description = $('#edit_description').val(); 
  var unit = $('select[name=edit_unit] option').filter(':selected').val();
  var category_name = $('select[name=edit_category_name] option').filter(':selected').val();
  console.log(category_name);
  var supplier_name = $('select[name=edit_supplier_name] option').filter(':selected').val();
  var re_order = $('#edit_re_order').val();
  var orig_price = $('#edit_orig_price').val();
  var selling_price = $('#edit_selling_price').val();
  var exp_date = $('#edit_exp_date').val();
  var img_path = $('#edit_image').val();
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
            exp_date:exp_date,
            img_path:img_path
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




