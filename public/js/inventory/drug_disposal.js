                                            
$(document).ready(function(){
   
    load_data();
 
    function load_data(){
       fetchExpiredProduct();
    }  
 
    function fetchExpiredProduct(){
 
    $('#drug-disposal-table').DataTable({
     
        processing: true,
        serverSide: true,
      
        ajax:{
         url: "/inventory/drugdisposal",
         type:"GET",
        }, 
        
        columns:[       
            {data: 'product_code', name: 'product_code'},
            {data: 'description', name: 'description'},
            {data: 'unit', name: 'unit'},    
            {data: 'category_name', name: 'category_name'},  
            {data: 'supplierName', name: 'supplierName'},  
            {data: 'exp_date', name: 'exp_date', orderable:false},
            {data: 'action', name: 'action', orderable:false},
           ],    
       });

    }

    
 // dispose product alert
 var id, product_name;
 $(document).on('click', '#btn-dispose', function(){
     row = $(this).closest("tr")
     id = $(this).attr('product-code');
     console.log(id);
     product_name =  $(this).closest("tr").find('td:eq(1)').text();
     $('#proconfirmModal').modal('show');
     $('.dispose-message').html('Are you sure do you want to dispose <b>'+ product_name +'</b>?');
   }); 
   
   $.ajaxSetup({
       headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
   
   $('#ok-button').click(function(){
       $.ajax({
           url: '/inventory/drugdisposal/dispose/'+ id,
           type: 'DELETE',
         
           beforeSend:function(){
               $('#ok-button').text('Deleting...');
               $('.loader').css('display', 'inline');
           },
           success:function(data){
               setTimeout(function(){
                   $('#ok-button').remove();
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
   });
   