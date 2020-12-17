

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });


$('#contact-no').keyup(function(e)
{
    //retricts value of letter
    if (/\D/g.test(this.value)){
        this.value = this.value.replace(/\D/g, '');
    }
    });     


});
  
  
  
  
  