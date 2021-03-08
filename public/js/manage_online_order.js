
$(document).ready(function(){

// Pending------------------------------------------------------------------------------------------------------------------------------------------------------------------

    fetchPendingOrders();

    function fetchPendingOrders(){
      $('#pending-table').DataTable({
     
        processing: true,
        serverSide: true,

        ajax:{
         url: "/manageorder/pending",
        }, 

        columns:[       
         {data: 'order_num', name: 'order_num'},
         {data: 'fullname', name: 'fullname'},
         {data: 'phone_no', name: 'phone_no'},
         {data: 'email', name: 'email'},    
         {data: 'created_at', name: 'created_at'},
         {data: 'status', name: 'status',orderable: false},
         {data: 'action', name: 'action',orderable: false},
        ]
        
       });
    }

// Processing------------------------------------------------------------------------------------------------------------------------------------------------------------------

    fetchProcessingOrders();

    function fetchProcessingOrders(){
      $('#processing-table').DataTable({
     
        processing: true,
        serverSide: true,

        ajax:{
         url: "/manageorder/processing",
        }, 

        columns:[       
         {data: 'order_num', name: 'order_num'},
         {data: 'fullname', name: 'fullname'},
         {data: 'phone_no', name: 'phone_no'},
         {data: 'email', name: 'email'},   
         {data: 'payment_method', name: 'payment_method'},   
         {data: 'created_at', name: 'created_at'},
         {data: 'status', name: 'status',orderable: false},
         {data: 'action', name: 'action',orderable: false},
        ]
        
       });
    }

// Packed------------------------------------------------------------------------------------------------------------------------------------------------------------------

    fetchPackedOrders();

    function  fetchPackedOrders(){
      var tbl_packed = $('#packed-table').DataTable({
     
        processing: true,
        serverSide: true,

        ajax:{
         url: "/manageorder/packed",
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
         {data: 'order_num', name: 'order_num'},
         {data: 'order_num', name: 'order_num'},
         {data: 'fullname', name: 'fullname'},
         {data: 'phone_no', name: 'phone_no'},
         {data: 'email', name: 'email'},   
         {data: 'payment_method', name: 'payment_method'},   
         {data: 'created_at', name: 'created_at'},
         {data: 'status', name: 'status',orderable: false},
         {data: 'action', name: 'action',orderable: false},
        ]
        
       });

       $('#select-all').on('click', function(){
        var rows = tbl_packed.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });
    
        $('#packed-table tbody').on('change', 'input[type="checkbox"]', function(){
          if(!this.checked){
             var el = $('#select-all').get(0);
             if(el && el.checked && ('indeterminate' in el)){
                el.indeterminate = true;
             }
          }
       });
    }

// Dispatch------------------------------------------------------------------------------------------------------------------------------------------------------------------

    fetchDispatchOrders();

    function  fetchDispatchOrders(){
      var tbl_dispatch = $('#dispatch-table').DataTable({
     
        processing: true,
        serverSide: true,

        ajax:{
         url: "/manageorder/dispatch",
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
         {data: 'order_num', name: 'order_num'},
         {data: 'order_num', name: 'order_num'},
         {data: 'fullname', name: 'fullname'},
         {data: 'phone_no', name: 'phone_no'},
         {data: 'email', name: 'email'},   
         {data: 'payment_method', name: 'payment_method'},   
         {data: 'created_at', name: 'created_at'},
         {data: 'status', name: 'status',orderable: false},
         {data: 'action', name: 'action',orderable: false},
        ]
        
       });

       $('#select-all-delivered').on('click', function(){
        var rows = tbl_dispatch.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });
    
        $('#dispatch-table tbody').on('change', 'input[type="checkbox"]', function(){
          if(!this.checked){
             var el = $('#select-all-delivered').get(0);
             if(el && el.checked && ('indeterminate' in el)){
                el.indeterminate = true;
             }
          }
       });
    }

// Delivered------------------------------------------------------------------------------------------------------------------------------------------------------------------
    var del_date_from = $('#del_date_from').val()
    var del_date_to = $('#del_date_to').val();

    fetchDelivered(del_date_from, del_date_to);

    function fetchDelivered(date_from, date_to){
      $('#delivered-table').DataTable({
     
        processing: true,
        serverSide: true,

        ajax:{
         url: "/manageorder/delivered",
         data:{
          date_from:date_from,
          date_to:date_to
         },
        }, 

        columns:[       
          {data: 'order_num', name: 'order_num'},
          {data: 'fullname', name: 'fullname'},
          {data: 'phone_no', name: 'phone_no'},
          {data: 'email', name: 'email'},   
          {data: 'payment_method', name: 'payment_method'},   
          {data: 'created_at', name: 'created_at'},
          {data: 'updated_at', name: 'updated_at'},
          {data: 'status', name: 'status',orderable: false},
        ]
        
       });
    }

    $('#del_date_from').change(function()
    {
        var date_from = $('#del_date_from').val()
        var date_to = $('#del_date_to').val();

        $('#delivered-table').DataTable().destroy();
        fetchDelivered(date_from, date_to);
    });

   $('#del_date_to').change(function()
   {
      var date_from = $('#del_date_from').val()
      var date_to = $('#del_date_to').val();

      $('#delivered-table').DataTable().destroy();
      fetchDelivered(date_from, date_to);
   });


// Cancelled------------------------------------------------------------------------------------------------------------------------------------------------------------------
var cancelled_date_from = $('#cancelled_date_from').val()
var cancelled_date_to = $('#cancelled_date_to').val();

fetchCancelled(cancelled_date_from, cancelled_date_to);

function fetchCancelled(date_from, date_to){
  $('#cancelled-table').DataTable({
 
    processing: true,
    serverSide: true,

    ajax:{
     url: "/manageorder/cancelled",
     data:{
      date_from:date_from,
      date_to:date_to
     },
    }, 

    columns:[       
      {data: 'order_num', name: 'order_num'},
      {data: 'fullname', name: 'fullname'},
      {data: 'phone_no', name: 'phone_no'},
      {data: 'email', name: 'email'},   
      {data: 'status', name: 'status',orderable: false},
      {data: 'remarks', name: 'remarks',orderable: false},   
      {data: 'created_at', name: 'created_at'},
      {data: 'updated_at', name: 'updated_at'},
    ]
    
   });
}

$('#cancelled_date_from').change(function()
{
    var date_from = $('#cancelled_date_from').val()
    var date_to = $('#cancelled_date_to').val();

    $('#cancelled-table').DataTable().destroy();
    fetchCancelled(date_from, date_to);
});

$('#cancelled_date_to').change(function()
{
  var date_from = $('#cancelled_date_from').val()
  var date_to = $('#cancelled_date_to').val();

  $('#cancelled-table').DataTable().destroy();
  fetchCancelled(date_from, date_to);
});

// end------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $(document).on('click', '#btn-show-processing', function(){
    
      var order_no = $(this).attr('order-no');
      var order_id = $(this).attr('order-id');
      var user_id = $(this).attr('user-id');
      var btn_data = $(this).attr('btn-text');
      console.log(btn_data);

      $('#order-no').val(order_no);
      $('#user-id').val(user_id);

      $('#showItemsModal').modal('toggle');

      $('#btn-process').removeClass('btn-dispatch btn-delivered');
      $('#btn-process').addClass('btn-pack');
      $('.btn-pack').text(btn_data);
      console.log(order_id);
      getOrderItems(order_no, order_id);
      fetchAccountInfo(user_id);
      fetchShippingInfo(user_id);

    });

    
    $(document).on('click', '#btn-show-pack', function(){
    
      var order_no = $(this).attr('order-no');
      var order_id = $(this).attr('order-id');
      var user_id = $(this).attr('user-id');
      var btn_data = $(this).attr('btn-text');
      console.log(btn_data);

      $('#order-no').val(order_no);
      $('#user-id').val(user_id);

      $('#showItemsModal').modal('toggle');

      $('#btn-process').removeClass('btn-pack btn-delivered btn-dispatch');
      $('#btn-process').addClass('btn-dispatch');
      $('.btn-dispatch').text(btn_data);
      console.log(order_id);
      getOrderItems(order_no, order_id);
      fetchAccountInfo(user_id);
      fetchShippingInfo(user_id);

    });


    $(document).on('click', '#btn-show-dispatch', function(){
    
      var order_no = $(this).attr('order-no');
      var order_id = $(this).attr('order-id');
      var user_id = $(this).attr('user-id');
      var btn_data = $(this).attr('btn-text');
      console.log(btn_data);

      $('#order-no').val(order_no);
      $('#user-id').val(user_id);

      $('#showItemsModal').modal('toggle');

      $('#btn-process').removeClass('btn-pack btn-delivered btn-dispatch');
      $('#btn-process').addClass('btn-delivered');
      $('.btn-delivered').text(btn_data);
      console.log(order_id);
      getOrderItems(order_no, order_id);
      fetchAccountInfo(user_id);
      fetchShippingInfo(user_id);

    });


    
    
    
    function getTotalAmount(order_id){
      $.ajax({
        url:"/manageorder/total_amount/"+order_id,
        type:"GET",
        success:function(data){  
          console.log(data); 
          if(data){
            $('#txt_total_amount').text(data);
          }
         
        }
         
       });
    }

    function fetchAccountInfo(user_id){
      $.ajax({
        url:"/manageorder/customerinfo/"+user_id,
        type:"GET",
        success:function(data){  
          console.log(data);
          if(data){
            $('#fullname').text(data[0].fullname);
            $('#email').text(data[0].email);
            $('#phone-no').text(data[0].phone_no);

            getVerificationInfo(user_id)
          }
         
        }
         
       });
    }

    function fetchShippingInfo(user_id){
      $.ajax({
        url:"/manageorder/shippinginfo/"+user_id,
        type:"GET",
        success:function(data){
         if(data){
          $('#municipality').text(data[0].municipality);
          $('#flr-bldg-blk').text(data[0].flr_bldg_blk);
          $('#brgy').text(data[0].brgy);
          $('#note').text(data[0].note);
         }
         else{
          $('#flr-bldg-blk').text('-');
          $('#brgy').text('-');
          $('#note').text('-');
         }
        }
         
       });
    }

    $(document).on('click', '#btn-gen-sales-inv', function(){

        var user_id, discount, shipping_fee;
        user_id = $('#user-id').val();
        discount = $('#txt_sc_pwd_discount').text().toString().slice(3);
        shipping_fee = $('#txt_shipping_fee').text();
        
        if(!discount){
          discount = 0.00;
        }
        if(!shipping_fee){
          shipping_fee = 0.00;
        }

      window.open('/manageorder/salesinvoice/'+user_id+'/'+discount+'/'+shipping_fee, '_blank'); 
    });


    $(document).on('click', '#fa-gen-sales-inv', function(){

        var user_id, discount, shipping_fee;
        user_id = $('#user-id').val();
        discount = $('#txt_sc_pwd_discount').text().toString().slice(3);
        console.log(discount+' discount');
        shipping_fee = $('#txt_shipping_fee').text();
        
        if(discount == ''){
          discount = 0.00;
        }
        if(shipping_fee == ''){
          shipping_fee = 0.00;
        }

      window.open('/manageorder/salesinvoice/'+user_id+'/'+discount+'/'+shipping_fee, '_blank'); 

    });

  function getOrderItems(order_no, order_id) {
    $.ajax({
      url:"/manageorder/showitems/" + order_no,
      type:"GET",
      success:function(){

        $('#title-order-no').text('Order #'+order_no);
        $( "#cust-order-table" ).load( "manageorder #cust-order-table" );

        getDiscount(order_id);
        getShippingFee(order_id);
        getTotalAmount(order_id);
      }
    });
  }


  function getDiscount(order_id){
    $.ajax({
      url:"/manageorder/discount/"+order_id,
      type:"GET",
      success:function(data){ 
        console.log(data+' discount'); 
        if(data){
          $('#txt_sc_pwd_discount').text('- ₱'+data);
        }
        else{
          $('#txt_sc_pwd_discount').text('-');
        }
       
      }
       
     });
  }


  function getShippingFee(order_id){
    $.ajax({
      url:"/manageorder/shippingfee/"+order_id,
      type:"GET",
      success:function(data){ 
        console.log(data); 
        if(data){
          $('#txt_shipping_fee').text(data);
        }
       
      }
       
     });
  }

  function getVerificationInfo(user_id) {
    $.ajax({
      url:"/manageorder/verification_info/" + user_id,
      type:"GET",
      success:function(data){

        $('#verification-info').text(data);   
      }
    });
  }


  $(document).on('click', '.btn-pack', function(){
    
    var order_no = $('#order-no').val();
    var user_id = $('#user-id').val();

    $.ajax({
      url:"/manageorder/do-pack/" + order_no,
      type:"POST",
      data:{
        user_id:user_id
      },
      beforeSend:function(){
        $('.loader').css('display', 'inline');
    },
      success:function(){
        $('.loader').css('display', 'none');
        $('.update-success-validation').css('display', 'inline');
        $('#processing-table').DataTable().ajax.reload();
        $('#packed-table').DataTable().ajax.reload();
        setTimeout(function(){
          $('.update-success-validation').fadeOut('slow');
    
       
          $('#showItemsModal').modal('hide');
        },2000);

      
      }
    });
  });

  $(document).on('click', '.btn-dispatch', function(){
    
    var order_no = $('#order-no').val();
    var user_id = $('#user-id').val();

    $.ajax({
      url:"/manageorder/do-dispatch/" + order_no,
      type:"POST",
      data:{
        user_id:user_id
      },
      beforeSend:function(){
        $('.loader').css('display', 'inline');
    },
      success:function(){
        $('.loader').css('display', 'none');
        $('.update-success-validation').css('display', 'inline');
        $('#packed-table').DataTable().ajax.reload();
        $('#dispatch-table').DataTable().ajax.reload();
        setTimeout(function(){
          $('.update-success-validation').fadeOut('slow');
    
       
          $('#showItemsModal').modal('hide');
        },2000);

      
      }
    });
  });

  $(document).on('click', '.btn-delivered', function(){
    
    var order_no = $('#order-no').val();
    var user_id = $('#user-id').val();

    $.ajax({
      url:"/manageorder/do-delivered/" + order_no,
      type:"POST",
      data:{
        user_id:user_id
      },
      beforeSend:function(){
        $('.loader').css('display', 'inline');
    },
      success:function(){
        $('.loader').css('display', 'none');
        $('.update-success-validation').css('display', 'inline');
        $('#delivered-table').DataTable().ajax.reload();
        $('#dispatch-table').DataTable().ajax.reload();
        setTimeout(function(){
          $('.update-success-validation').fadeOut('slow');
    
       
          $('#showItemsModal').modal('hide');
        },2000);

      
      }
    });
  });



  $('#btn-bulk-dispatch').click(function(){

    var order_no = [];

    $(':checkbox:checked').each(function(i){
      order_no[i] = $(this).val();
    });

    if(order_no.length > 0){
      
        if($('#select-all').is(":checked")){
          //used slice method to start index at 1, so the value of sellect_all checkbox is not included in array
          order_no = order_no.slice(1).join(", ");
          console.log(order_no);
        }
        else{
          order_no = order_no.join(", ");
          console.log(order_no);
        }
    
        $.ajax({
          url:"/manageorder/bulk_dispatch/"+order_no,
          type:"POST",
          beforeSend:function(){
            $('.loader').css('display', 'inline');
            $('#btn-bulk-dispatch').text('Please wait...')
          },
          success:function(){
    
            setTimeout(function(){
              $('#packed-table').DataTable().ajax.reload();
              $('#dispatch-table').DataTable().ajax.reload();
              $('.loader').css('display', 'none');
              $('#btn-bulk-dispatch').text('Dispatch')
              },1000);
          
          }
        });
    }
    else{
        alert('No data selected!')       
    }
});


$('#btn-bulk-delivered').click(function(){

  var order_no = [];

  $(':checkbox:checked').each(function(i){
    order_no[i] = $(this).val();
  });

  if(order_no.length > 0){
    
      if($('#select-all').is(":checked")){
        //used slice method to start index at 1, so the value of sellect_all checkbox is not included in array
        order_no = order_no.slice(1).join(", ");
        console.log(order_no);
      }
      else{
        order_no = order_no.join(", ");
        console.log(order_no);
      }
  
      $.ajax({
        url:"/manageorder/bulk_delivered/"+order_no,
        type:"POST",
        beforeSend:function(){
          $('.loader').css('display', 'inline');
          $('#btn-bulk-delivered').text('Please wait...')
        },
        success:function(){
  
          setTimeout(function(){
            $('#dispatch-table').DataTable().ajax.reload();
            $('#delivered-table').DataTable().ajax.reload();
            $('.loader').css('display', 'none');
            $('#btn-bulk-delivered').text('Delivered')
            },1000);
        
        }
      });
  }
  else{
      alert('No data selected!')       
  }
});

function moneyFormat(param)
      {
        var decimal = (Math.round(param * 100) / 100).toFixed(2);
       // var round_off = Math.round((parseInt(parseFloat(decimal)) + Number.EPSILON) * 100) / 100;
        return money_format = parseFloat(decimal).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }

 

});
    