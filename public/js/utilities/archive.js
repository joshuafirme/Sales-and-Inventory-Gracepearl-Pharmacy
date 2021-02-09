$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

  fetchArchiveProducts();

  function fetchArchiveProducts(){
    var tbl_archive_product = $('#archive-product-table').DataTable({
   
      processing: true,
      serverSide: true,
      ajax: '/path/to/script',
      scrollY: 470,
      scroller: {
          loadingIndicator: true
      },

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
     
      ajax:"/utilities/archive/product", 
          
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
       {data: 'updated_at',name: 'updated_at'},
       {data: 'action', name: 'action',orderable: false},
      ]
     });

     $('#select-all-archive-product').on('click', function(){
      var rows = tbl_archive_product.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
      });
  
      $('#archive-product-table tbody').on('change', 'input[type="checkbox"]', function(){
        if(!this.checked){
           var el = $('#select-all-archive-product').get(0);
           if(el && el.checked && ('indeterminate' in el)){
              el.indeterminate = true;
           }
        }
     });
  }

  $('#btn-bulk-retrieve').click(function(){

    var id = [];

    $(':checkbox:checked').each(function(i){
      id[i] = $(this).val();
    });

    if(id.length > 0){
      
        if($('#select-all').is(":checked")){
          //used slice method to start index at 1, so the value of sellect_all checkbox is not included in array
          id = id.slice(1).join(", ");
          console.log(id);
        }
        else{
          id = id.join(", ");
          console.log(id);
        }
    
        $.ajax({
          url:"/utilities/archive/bulk-retrieve-product/"+id,
          type:"POST",
          beforeSend:function(){
            $('.loader').css('display', 'inline');
            $('#btn-bulk-retrieve').text('Please wait...');
          },
          success:function(){
    
            setTimeout(function(){
              $('#archive-product-table').DataTable().ajax.reload();
              $('.loader').css('display', 'none');
              $('#btn-bulk-retrieve').text('Retrieve');
              },1000);
          
          }
        });
    }
    else{
        alert('No data selected!')       
    }
});


  var id;
   $(document).on('click', '.retrieve-data', function(){
      id = $(this).attr('product-id');
      var data_name =  $(this).closest("tr").find('td:eq(1)').text();
      $('#confirmModal').modal('show');
      $('.delete-message').html('Are you sure do you want to retrieve <b>'+data_name+'</b>?');
   }); 
   
   $('#btn-retrieve-product').click(function(){
       $.ajax({
           url: '/utilities/archive/retrieve-product/'+ id,
           type: 'POST',
         
           beforeSend:function(){
               $('#btn-retrieve-product').text('Retrieving...');
               $('.loader').css('display', 'inline');
           },
           success:function(data){
               setTimeout(function(){
                   $('#btn-retrieve-product').text('Retrieve');
                   $('#confirmModal').modal('hide');
                   $( "#archive-product-table" ).DataTable().ajax.reload();
                   $('.loader').css('display', 'none');
               }, 1000);
           }
       });
     
   });





//  fetchArchiveSales();

  function fetchArchiveSales(){
    $('#archive-sales-table').DataTable({
   
      processing: true,
      serverSide: true,
      ajax: '/path/to/script',
      scrollY: 470,
      scroller: {
          loadingIndicator: true
      },
     
      ajax:"/utilities/archive/sales", 
          
      columns:[       
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
        {data: 'updated_at', name: 'updated_at'},
        {data: 'action', name: 'action',orderable: false},
      ]
     });
  }



});