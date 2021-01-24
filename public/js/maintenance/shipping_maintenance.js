

$(document).ready(function(){
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});  

if(municipality){       
    getBrgy(municipality);
    }

 $('#municipality').change(function () {
    var municipality = $(this).val();
       
    getBrgy(municipality);
    
});         
     
 function getBrgy(municipality_name) {

    $.ajax({
        url: '/maintenance/shippingadd/brgylist/'+municipality_name,
        tpye: 'GET',
        success:function(data){
            $('#brgy').empty();
            for (var i = 0; i < data['barangay_list'].length; i++) 
            {
                $('#brgy').append('<option value="' + data['barangay_list'][i] + '">' + data['barangay_list'][i] + '</option>');
            }
           
    
        }
      });
}


});
