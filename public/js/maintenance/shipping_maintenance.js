

$(document).ready(function(){
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 

fetchData();


function fetchData(){
    $('#shipping-table').DataTable({
    
       processing: true,
       serverSide: true,
      
       ajax:"/maintenance/shippingadd",
           
       columns:[       
        {data: 'municipality', name: 'municipality'},
        {data: 'brgy', name: 'brgy'},
        {data: 'shipping_fee', name: 'shipping_fee'},
        {data: 'action', name: 'action',orderable: false},
       ]
      });

   }


initMunicipality();

function initMunicipality()
{
    var municipality =$('select[name=municipality]').val();

    if(municipality){       
        getBrgy(municipality);
    }
}



 $('select[name=municipality]').change(function () {
    var municipality = $(this).val();
       
    getBrgy(municipality);
    
});         
     
 function getBrgy(municipality_name) {

    $.ajax({
        url: '/maintenance/shippingadd/brgylist/'+municipality_name,
        tpye: 'GET',
        success:function(data){
            $('select[name=brgy]').empty();
            for (var i = 0; i < data['barangay_list'].length; i++) 
            {
                $('select[name=brgy]').append('<option value="' + data['barangay_list'][i] + '">' + data['barangay_list'][i] + '</option>');
            }
           
    
        }
      });
}

//edit show
$(document).on('click', '#btn-edit-shipping', function(){
    var id = $(this).attr('edit-id');
    
    var municipality =$('#edit_municipality').val();
    console.log(municipality);
    getBrgy(municipality);
  
    $.ajax({
      url:"/maintenance/shippingadd/show/"+id,
      type:"GET",

      success:function(data){
        $('#id_hidden').val(id);
        $('#edit_municipality').val(data[0].municipality);
        $('#edit_brgy').append('<option selected value="' + data[0].brgy + '">' + data[0].brgy + '</option>');
        $('#edit_fee').val(data[0].shipping_fee);
      }
     });
  });       


});


var id;
$(document).on('click', '#btn-delete-shipping', function(){
    id = $(this).attr('delete-id');
    $('#confirmModal').modal('show');
    $('.delete-success').hide();
    $('.delete-message').html('Are you sure do you want to inactive this address?');
  }); 
  
  
  $('#confirm-del-ship').click(function(){
      $.ajax({
          url: '/maintenance/shippingadd/delete/'+ id,
          type: 'POST',
        
          beforeSend:function(){
              $('#confirm-del-ship').text('Deleting...');
              $('.loader').css('display', 'inline');
          },
          
          success:function(){
              setTimeout(function(){
                  $('.delete-success').show();
                  $('.loader').css('display', 'none');
                  $('#confirm-del-ship').text('Delete');
                  $( "#shipping-table" ).load( "shippingadd #shipping-table" );
                    setTimeout(function(){
                      $('#confirmModal').modal('hide');
                  }, 1000);
              }, 1000);
          }
      });
    
  });
