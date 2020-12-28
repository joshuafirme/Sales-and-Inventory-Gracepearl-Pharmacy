
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      fetch_customer();
  
      function fetch_customer(){
        $('#verify-customer-table').DataTable({
       
          processing: true,
          serverSide: true,
         
          ajax:{
           url: "/verifycustomer",
          }, 
 
          columns:[       
           {data: 'user_id', name: 'user_id'},
           {data: 'fullname', name: 'fullname'},
           {data: 'phone_no', name: 'phone_no'},
           {data: 'email', name: 'email'},
           {data: 'id_type', name: 'id_type'},
           {data: 'id_number', name: 'id_number'},
           {data: 'status', name: 'status'},
           {data: 'action', name: 'action',orderable: false},
          ] 
        });
  
      }

      $(document).on('click', '#btn-view-upload', function(){
          var cust_id = $(this).attr('customer-id');
          fetchUploadInfo(cust_id);
      });

      function fetchUploadInfo(cust_id){
        $.ajax({
          url:"/verifycustomer/getverificationinfo/"+ cust_id,
          type:"GET",

          success:function(data){
                console.log(data);
            $('#cust-id-hidden').val(data[0].user_id);
            $('#id-type').text(data[0].id_type);
            $('#id-number').text(data[0].id_number);

            if(data[0].image !== null){
                var img_source = '../../storage/'+data[0].image;
              }
              else{
                var img_source = '../assets/noimage.png';
              }
            
              $('#img-valid-id').attr('src', img_source);
          }
           
         });
      }

      $(document).on('click', '#btn-approve', function() {

        var cust_id = $('#cust-id-hidden').val();
        var id_type = $('#id-type').text();
        approve(cust_id, id_type);

      });

    function approve(cust_id, id_type) {
      $.ajax({
        url:"/verifycustomer/approve/"+ cust_id,
        type:"POST",
        data:{
          id_type:id_type
        },

        success:function(data){
          alert('success');
          $('#verify-customer-table').DataTable().ajax.reload();
        }
         
       });
    }

    $(document).on('click', '#btn-decline', function(){
      var cust_id = $('#cust-id-hidden').val();

      decline(cust_id);

    });

    function decline(cust_id) {
      $.ajax({
        url:"/verifycustomer/decline/"+ cust_id,
        type:"POST",

        success:function(data){
          alert('success');
          $('#verify-customer-table').DataTable().ajax.reload();
        }
         
       });
    }

});
  
  
  
  
  