
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
        success:function(data){  console.log(data);
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
          console.log(data);
          $('#flr-bldg-blk').val(data[0].flr_bldg_blk);
          $('#municipality').val(data[0].municipality);
          $('#brgy').val(data[0].brgy);
          $('#notes').val(data[0].note);
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
        var brgy = $('#brgy').val();
        var notes = $('#notes').val();

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

});
  
  
  
  
  