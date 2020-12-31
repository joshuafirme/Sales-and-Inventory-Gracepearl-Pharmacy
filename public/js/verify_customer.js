
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      fetchForValidation();
  
      function fetchForValidation(){

      var tbl_for_validation = $('#for-validation-table').DataTable({
       
          processing: true,
          serverSide: true,
         
          ajax:{
           url: "/verifycustomer",
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
 
          columns:[       
           {data: 'user_id', name: 'user_id'},
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


   $('#select-all').on('click', function(){
    var rows = tbl_for_validation.rows({ 'search': 'applied' }).nodes();
    $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    $('#for-validation-table tbody').on('change', 'input[type="checkbox"]', function(){
      if(!this.checked){
         var el = $('#select-all').get(0);
         if(el && el.checked && ('indeterminate' in el)){
            el.indeterminate = true;
         }
      }
   });
  
      }

      fetchVerified();
  
      function fetchVerified(){
        $('#verified-table').DataTable({
       
          processing: true,
          serverSide: true,
         
          ajax:{
           url: "/verifycustomer/verifiedcustomer",
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
            isVerified(cust_id);
            $('#cust-id-hidden').val(data[0].user_id);
            $('#id-type').text(data[0].id_type);
            $('#id-number').text(data[0].id_number);
            $('#acc-status').text(data[0].status);

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

      function isVerified(cust_id){
        $.ajax({
          url:"/verifycustomer/getverificationinfo/"+ cust_id,
          type:"GET",
   
          success:function(data){

           var status = data[0].status;
              if(status == 'For validation') 
              {
                console.log('validation');
                
              }
              else
              {
                $("#btn-approve").attr('disabled', true);
                $("#btn-decline").attr('disabled', true);
              }
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

    function countForValidation() {
      $.ajax({
        url:"/verifycustomer/countforvalidation/",
        type:"GET",

        success:function(data){
          return data;
        }
         
       });
    }


    $('#btn-bulk-verified').click(function(){

        var user_ids = [];

        $(':checkbox:checked').each(function(i){
          user_ids[i] = $(this).val();
        });
    
        if(user_ids.length > 0){
          
            if($('#select-all').is(":checked")){
              //used slice method to start index at 1, so the value of sellect_all checkbox is not included in array
              user_ids = user_ids.slice(1).join(", ");
              console.log(user_ids);
            }
            else{
              user_ids = user_ids.join(", ");
              console.log(user_ids);
            }
        
            $.ajax({
              url:"/verifycustomer/bulkverified/"+user_ids,
              type:"POST",
              beforeSend:function(){
                $('.loader').css('display', 'inline');
              },
              success:function(){
        
                setTimeout(function(){
                  $('#for-validation-table').DataTable().ajax.reload();
                  $('#verified-table').DataTable().ajax.reload();
                  $('.loader').css('display', 'none');
                  },1000);
              
              }
            });
        }
        else{
            alert('Please select a customer!')
            
        }
        
      
      
      
    });

});
  
  
  
  
  