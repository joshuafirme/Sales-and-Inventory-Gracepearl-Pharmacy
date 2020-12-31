
$(document).ready(function(){

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
         {data: 'payment_method', name: 'payment_method'},   
         {data: 'created_at', name: 'created_at'},
         {data: 'status', name: 'status',orderable: false},
         {data: 'action', name: 'action',orderable: false},
        ]
        
       });
    }

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


    $(document).on('click', '#btn-show-items', function(){
    
      var order_no = $(this).attr('order-no');
      console.log(order_no);
      $('#showItemsModal').modal('toggle');
      getOrderItems(order_no);

    });

    $(document).on('click', '#btn-gen-sales-inv', function(){
      window.open('/manageorder/salesinvoice', '_blank'); 
    });

    $(document).on('click', '#fa-gen-sales-inv', function(){
      var order_no = $(this).attr('order-no');
      getOrderItems(order_no);
      window.open('/manageorder/salesinvoice', '_blank'); 

    });

  function getOrderItems(order_no) {
    $.ajax({
      url:"/manageorder/showitems/" + order_no,
      type:"GET",
      success:function(){

        $('#title-order-no').text('Order #'+order_no);
        $( "#cust-order-table" ).load( "manageorder #cust-order-table" );

      
      }
    });
  }
 

});
    