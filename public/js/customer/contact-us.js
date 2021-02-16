
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

   
$(document).on('click', '#btn-send-message', function(){
    var fullname, email, phone_no, message;
    fullname = $('#fullname').val();
    email = $('#email').val();
    phone_no = $('#phone_no').val();
    message = $('#message').val();

    $.ajax({
      url:"/contact-us/send",
      type:"GET",
      data:{
        fullname:fullname,
        email:email,
        phone_no:phone_no,
        message:message
      },
      beforeSend:function(){
        $('#btn-send-message').text('Sending...');
      },
      success:function(){
            $('#message-success').css('display', 'block');
            $('#btn-send-message').text('Send Message');
      }         
     });
});

});