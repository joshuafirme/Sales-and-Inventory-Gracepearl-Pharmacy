
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    $('#btn-edit-account').click(function(){

      fetchAccountInfo();
      fetchShippingInfo();
    });

    function fetchAccountInfo(){
      $.ajax({
        url:"/account/getaccountinfo",
        type:"GET",
        success:function(data){
          $('#fullname').val(data[0].fullname);
          $('#email').val(data[0].email);
          $('#phone_no').val(data[0].phone_no);
        }
         
       });
    }

    function fetchShippingInfo(){
      $.ajax({
        url:"/account/getshippinginfo",
        type:"GET",
        success:function(data){
         if(data){
         
        //  $('#municipality').append('<option selected value="' + data[0].municipality + '">' + data[0].municipality + '</option>');

        $('#barangay').empty(); 
          $('#barangay').append('<option selected value="' + data[0].brgy + '">' + data[0].brgy + '</option>');

       //   $("#municipality option[value="+data[0].municipality+"]").remove();

          $('#flr-bldg-blk').val(data[0].flr_bldg_blk);
             
          getBrgy(data[0].municipality, data[0].brgy);

          $('#notes').val(data[0].note);
         }
        }
         
       });
    }


  initMunicipality();

  function initMunicipality()
  {
      var municipality = $('#municipality').val();

      if(municipality){       
          getBrgy(municipality, '');
      }
  }
     

 $('#municipality').change(function () {
    var municipality = $(this).val();
    
    $('#barangay').empty(); 
    getBrgy(municipality, '');
    
});         
     
 function getBrgy(municipality, brgy) {

    $.ajax({
        url: '/account/getBrgyList/'+municipality,
        tpye: 'GET',
        success:function(data){
            for (var i = 0; i < data.length; i++) 
            { 
                $('#barangay').append('<option value="' + data[i].brgy + '">' + data[i].brgy  + '</option>');
            }
            
    
        }
      });
}



    $('#phone_no').blur(function() {
      var phone_no = $('#phone_no').val();
      isPhoneNumberExists(phone_no.replace(/\s/g, ''));
  });

  function isPhoneNumberExists(phone_no) {
      $.ajax({
          url:"/signup/isexists",
          type:"GET",
          data:{
              phone_no:phone_no
          },
          beforeSend:function(){
            $('#loading-modal').modal('toggle');
          },
          success:function(response){
           
           setTimeout(function() {
              if(isPhoneNoValid(phone_no) == true)
              {
                  if(response == '1')
                  {
                      $('#loading-modal').modal('toggle');
                      $("#pn-validation").remove();
                      $('#phone_no')
                      .after('<span class="label-small text-danger" id="pn-validation">Phone number is already exists.</div>');
                      $('#phone_no').val('');
                  }
                  else{
                      $('#loading-modal').modal('toggle');
                      $("#pn-validation").remove();
                  }
                }
           },500);
            
          }         
         })
  }

  function isPhoneNoValid(phone_no) {
      if(phone_no.replace(/ /g,'').length > 11 || phone_no.replace(/ /g,'').length < 11){
          $('#loading-modal').modal('toggle');
          $("#pn-validation").remove();
          $('#phone_no')
          .after('<span class="label-small text-danger" id="pn-validation">Please enter a valid phone number!</div>');
      }
      else{
          $('#loading-modal').modal('toggle');
          $("#pn-validation").remove();
          return true;
      }
  }

    
    $('#btn-update-account').on('click', function(){

        var fullname = $('#fullname').val();
        var email = $('#email').val();
        var phone_no = $('#phone_no').val();
        var flr_bldg_blk = $('#flr-bldg-blk').val();
        var municipality = $('#municipality').val();
        var brgy = $('#barangay').val();
        var notes = $('#notes').val();

        console.log(brgy);

        var is_valid = validateInputs(
          fullname,
          phone_no,
          brgy,
          flr_bldg_blk
        );

        if(is_valid == true){
          $.ajax({
            url:"/account/update",
            type:"POST",
            data: {
                fullname:fullname,
                email:email,
                phone_no:phone_no,
                flr_bldg_blk:flr_bldg_blk,
                municipality:municipality,
                brgy:brgy,
                notes:notes
            },
            beforeSend:function(){
                $('#btn-update-account').text('Saving...');
                $('.loader').css('display', 'inline');
              },
            success:function(){
              
              $( ".div-my-account" ).load( "account .div-my-account" );
              isVerified();
              
                setTimeout(function(){
                    $('.update-success-validation').css('display', 'inline');
                    $('#btn-update-account').text('Save');
                    $('.loader').css('display', 'none');
                    setTimeout(function(){
                 
                      $('.update-success-validation').fadeOut('slow')
                     
                    },2000);
                  
                  },1000);
            }
             
           });
        }
       
    });
    

    function validateInputs(fullname, phone_no, brgy, flr_bldg_blk) {

      if(fullname == '' || phone_no == '' || brgy == '' || flr_bldg_blk == ''){
          alert('pls input all of your credentials!');
      }
      else{
        return true;
      }
       
  }


    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
          $('#img-valid-id').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }
    
    $("#file-valid-id").change(function() {
      console.log('upload');
      readURL(this);
    });

    isVerified();

    function isVerified(){
      $.ajax({
        url:"/account/checkifverified",
        type:"GET",
 
        success:function(response){
          
          if(response != '')
          {
            if(response == 'For validation') 
            {
              console.log('validation');
              $('#verify-link').css('display', 'inline');
              $('#verification-info').css('display', 'block');
              disabledInputs();
            }
            else if(response == 'Verified')
            {
              console.log('verified');
              $('#verify-link').css('display', 'none');
              $('#verification-badge').toggleClass('badge-secondary badge-success');
              $('#verification-badge').text('Verified');
            }
            else
            {
              console.log('senior');
              $('#verify-link').css('display', 'none');
              $('#verification-badge').toggleClass('badge-secondary badge-success');
              $('#verification-badge').text('Verified Senior Citizen');
            }
          }
          else{
            // if no upload yet
            console.log('no upload');
            $('#verify-link').css('display', 'inline');
          }
            
        }
         
       });
    }

    $('#btn-upload').click(function(){
      $('#verify-customer-table').load('verifycustomer #verify-customer-table');
     
    });

    function disabledInputs(){
      $("#id-type").attr('disabled', true);
      $("#id-number").attr('disabled', true);
      $("#file-valid-id").attr('disabled', true);
      $("#btn-upload").attr('disabled', true);
    }

  
  
  
// Send Email Verification Code------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

$("#btn-send-email-code").change(function() {
  $.ajax({
    url: '/account/send-verification-code/'+email,
    tpye: 'GET',
    success:function(data){
        

    }
  });
});

getUserEmail();
getUserPhoneNo();

function getUserEmail(){
  $.ajax({
    url: '/account/get-user-email',
    tpye: 'GET',
    success:function(data){
        $('.send-code-to').html('Code will be send to <b>'+data+'</b>');
        $('#send-code-to_hidden').val(data);

        if(data == '' || data == null){
          $('.btn-verify-email').prop('disabled', true);
          $('.btn-verify-sms').addClass("active");
          $('.btn-verify-email').removeClass("active");
          getUserPhoneNo();
        }
    }
  });
}


$('.btn-verify-email').click(function(){

  $('.btn-verify-email').addClass("active");
  $('.btn-verify-sms').removeClass("active");

  getUserEmail()
});

$('.btn-verify-sms').click(function(){

  $('.btn-verify-sms').addClass("active");
  $('.btn-verify-email').removeClass("active");

  getUserPhoneNo();
});

function getUserPhoneNo(){
  $.ajax({
    url: '/account/get-user-phone',
    tpye: 'GET',
    success:function(data){
      
        $('.send-code-to').html('Code will be send to <b>'+data+'</b>');
        $('#send-code-to_hidden').val(data);

        if(data == '' || data == null){
          $('.btn-verify-sms').prop('disabled', true);
          $('.btn-verify-email').addClass("active");
          $('.btn-verify-sms').removeClass("active");
          getUserEmail();
        }
    }
  });
}


  $(document).on('click', '#send-email-code', function() {
    var recipient = $('#send-code-to_hidden').val().replace(/^0+/, ''); //remove leading zeros
    console.log(recipient);
    sendOTP(recipient);
  });


function sendOTP(recipient){
  if($('.btn-verify-email').hasClass('active')){
    $.ajax({
      url:"/account/send-email-code/"+recipient,
      type:"GET",
      beforeSend:function(){
        $('#send-email-code').text('Sending...');
      },
      success:function(){
          $('#send-email-code').text('Send Code');
          setTimer();
      }         
     });
  }
  else{
    $.ajax({
      url:"/account/send-sms-code/"+recipient,
      type:"GET",
      beforeSend:function(){
        $('#send-email-code').text('Sending...');
      },
      success:function(){
          $('#send-email-code').text('Send Code');
          setTimer();
      }         
     });
  }

}

function setTimer(){
    $('#send-email-code').css('display', 'none');
    var timer2 = "0:30";
    var interval = setInterval(function() {
    
      var timer = timer2.split(':');
      //by parsing integer, I avoid all extra string processing
      var minutes = parseInt(timer[0], 10);
      var seconds = parseInt(timer[1], 10);
      --seconds;
      minutes = (seconds < 0) ? --minutes : minutes;
      if (minutes < 0) clearInterval(interval);
      seconds = (seconds < 0) ? 59 : seconds;
      seconds = (seconds < 10) ? '0' + seconds : seconds;
      //minutes = (minutes < 10) ?  minutes : minutes;
      $('.countdown').text('Resend Code in ' + minutes + ':' + seconds);
      timer2 = minutes + ':' + seconds;

      if(seconds == 0){
          minutes = 0;
          seconds = 0;
        $('.countdown').css('display', 'none');
        $('#send-email-code').css('display', 'inline');
        $('#send-email-code').text('Resend OTP');
      }
    }, 1000);
}


$(document).on('blur', '#vcode', function(){
     var otp = $(this).val();
     validateOTP(otp);
});

function validateOTP(otp){
    if(otp){
        $.ajax({
            url:"/account/validate-otp/"+otp,
            type:"GET",
            success:function(response){
                if(response == '1'){
                    $("#pn-validation").remove();
                    $('#vcode')
                    .after('<span class="label-small text-success" id="pn-validation">Code is valid.</div>');
                }
                else{
                    $("#pn-validation").remove();
                    $('#vcode')
                    .after('<span class="label-small text-danger" id="pn-validation">Code is invalid.</div>');
                }
            }         
           });
    }
} 

$(document).on('click', '#btn-update-password', function(){
    var otp = $('#vcode').val();
    var password = $('#new-password').val();

    if(otp){
      $.ajax({
        url:"/account/validate-otp/"+otp,
        type:"GET",
        success:function(response){
            $("#pn-validation").remove();
            if(response == '1')
            {     
              if(password){
                $.ajax({
                  url:"/account/update-password/"+password,
                  type:"POST",
                  beforeSend:function(){
                    $('#btn-update-password').text('Updating...');
                  },
                  success:function(){
                    $('#change-pass-success').css('display', 'block');
                    $('#btn-update-password').text('Update Password');
                  }         
                });
              }
              else{
                $("#pn-validation").remove();
                $('#new-password')
                .after('<span class="label-small text-danger" id="pn-validation">Please enter the code</div>');
              }
            }
            else{
                alert('Invalid ');
            }
        }         
       });
    }
    else{
      
      $("#pn-validation").remove();
      $('#vcode')
      .after('<span class="label-small text-danger" id="pn-validation">Please enter the code</div>');
    }
});


$(document).on('click', '#btn-update-email', function(){
  var otp = $('#vcode').val();
  var email = $('#new-email').val();

  if(otp){
    $.ajax({
      url:"/account/validate-otp/"+otp,
      type:"GET",
      success:function(response){
          $("#pn-validation").remove();
          if(response == '1')
          {     
            if(password){
              $.ajax({
                url:"/account/update-password/"+password,
                type:"POST",
                beforeSend:function(){
                  $('#btn-update-password').text('Updating...');
                },
                success:function(){
                  $('#change-pass-success').css('display', 'block');
                  $('#btn-update-password').text('Update Password');
                }         
              });
            }
            else{
              $("#pn-validation").remove();
              $('#new-password')
              .after('<span class="label-small text-danger" id="pn-validation">Please enter the code</div>');
            }
          }
          else{
              alert('Invalid ');
          }
      }         
     });
  }
  else{
    
    $("#pn-validation").remove();
    $('#vcode')
    .after('<span class="label-small text-danger" id="pn-validation">Please enter the code</div>');
  }
});

});