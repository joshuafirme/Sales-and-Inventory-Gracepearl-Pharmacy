
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      showReminder();
    
      function showReminder() {
        $.ajax({
          url:"/is-reminder-showed",
          type:"GET",
            success:function(response){
                if(response == '1'){
                  $('#reminderModal').modal('toggle');
                }
            }  
         });
      }

      $(document).on('click', '#btn-ok-reminder', function(){
        $.ajax({
          url:"/not-show-reminder",
          type:"POST",
            success:function(){
              $('#reminderModal').modal('toggle');
              console.log('success');
            }
         });
    });


    checkIfLoggedIn();

    function checkIfLoggedIn(){
      $.ajax({
        url:"/customer/islogged",
        type:"GET",
        success:function(response){
            
          if(response !== 'yes'){
              $('#user-profile').css('display', 'none');
              $('#dropdown-items').css('display', 'none');
              $('#login-url').text('Login');
              $('#login-url').removeAttr('data-toggle');
              $('#lblCartCount').css('display', 'none');
              $('.fa-shopping-cart').css('display', 'none');
              $('#login-url').attr("href", "/customer-login");
          }
     
        }
         
       });
    }


    var limit = 12;
    // display product limit by 8 entries
    displayAllProduct(limit);

    function displayAllProduct(limit) {

      $.ajax({
        url:"/homepage/allproduct",
        type:"GET",
        data:{
          limit:limit
        },
        beforeSend:function(){
          $('#loading-modal').modal('toggle');
      },
        success:function(data){
          cardHTML(data); 
        }    
       });
    }
  

    $(document).on('click', '#btn-viewmore', function(){
        limit += 4;
        console.log(limit);
        var search_key = $('#search-product').val();
        var categories = getCategories();
        var min_price = $('#input-minprice').val();
        var max_price = $('#input-maxprice').val();
  
        filter(search_key, categories, min_price, max_price, limit);
    });

    // filter by category, search, limit
    function filter(search_key, categories, min_price, max_price, limit) {
      if(categories.length == 0)
      {
        displayAllProduct(limit);
      }
      else
      {
        searchProduct(search_key, categories, min_price, max_price, limit);
      }
    }
    

    function getCategories() {
      var categories = [];
      $(':checkbox:checked').each(function(i){
        categories[i] = $(this).val();
      });
      categories = categories.join(", ");
      console.log(categories);
      return categories
    }

    $('[name="chk-category[]"]').click(function () {
      var search_key = $('#search-product').val();
      var categories = getCategories();
      var min_price = $('#input-minprice').val();
      var max_price = $('#input-maxprice').val();

      filter(search_key, categories, min_price, max_price, limit);
    });

    $('#input-minprice').blur(function () {
      var search_key = $('#search-product').val();
      var categories = getCategories();
      var min_price = $('#input-minprice').val();
      var max_price = $('#input-maxprice').val();

      filter(search_key, categories, min_price, max_price, limit);
    });

    $('#input-maxprice').blur(function () {
      var search_key = $('#search-product').val();
      var categories = getCategories();
      var min_price = $('#input-minprice').val();
      var max_price = $('#input-maxprice').val();

      filter(search_key, categories, min_price, max_price, limit);
    });

    $('#search-product').blur(function() {
        var search_key = $(this).val();
        var categories = getCategories();
        var min_price = $('#input-minprice').val();
        var max_price = $('#input-maxprice').val();

        console.log(min_price+' and '+max_price);

        if(search_key){
          console.log('search');
          searchProduct(search_key, categories, min_price, max_price, limit);
        }
        else{
          filter(search_key, categories, min_price, max_price, limit);
        }

    });

    function searchProduct(search_key, categories, min_price, max_price, limit) {
      if(search_key == ''){
        search_key = ' ';
      }
      $.ajax({
        url:"/homepage/searchproduct/"+search_key,
        type:"GET",
        data:{
          categories:categories,
          min_price:min_price,
          max_price:max_price,
          limit:limit
        },
          beforeSend:function(){
            $('#loading-modal').modal('toggle');
          },
          success:function(data){
            console.log(data);
            cardHTML(data);
          }  
       });
    }
    function cardHTML(data){
      
      $('#homepage-cards').html('');
      
      if(data.length > 0){

        for (var i = 0; i < data.length; i++) {

        
          var cards = ' <div class="card-product"><a class="card__image-container div-product-details" href="/productdetails/'+data[i].product_code+' ">';
          cards += '<input type="hidden" id="'+data[i].product_code+'">';
          

          if(data[i].image){           
            cards += '<img  src="../../storage/'+data[i].image+'" class="img-fluid w-100" alt="..."></a>'
          }
          else{
            cards += '<img class="img-fluid w-100" src="../assets/noimage.png"></a>';
          }
  
          cards +='<div class="line ml-2 mr-2 mt-2"></div>';
          cards +='<div class="card__content">';
  
          if(data[i].description.length > 28){
            cards += '<p class="card__description">'+data[i].description.slice(0,28)+'...';
          }
          else{
            cards += '<p class="card__description">'+data[i].description+'';
          }
  
          cards += '</p>';
          cards += ' <p class="card__unit text-secondary">    Unit type: '+data[i].unit+'';
          cards += '</p>';
          cards += ' <div class="card__info">';
          cards += '<p class="mt-3 text-success">₱ '+moneyFormat(data[i].selling_price)+'</p>';

          if(data[i].with_prescription == 'yes'){   
            cards += '<p class="label small" style="margin-left: 14px; margin-top: 17px; font-style: italic;">Prescription needed</p>';  
          }
          else{
            cards += '<div style="margin-left:24px;" id="btn'+data[i].product_code+'"></div>';    
            getQty(data[i].product_code);          
          }
         
          cards += '</div></div></div>';    

          if(data.length >= 12){
            if(i == data.length -1){
              cards += '<div class="row">';
              cards += '<div class="col-12">';
              cards += '<button class="btn btn-sm btn-success" id="btn-viewmore"';
              cards += 'style="border-radius: 20px; width:110px; ">View more</button>';
              cards += '</div></div>';
            }
          }
          
         $('#homepage-cards').append(cards);
        }
       
      } 
      else{
        cards += ' <div class="row"><a class="m-auto">No product found.</a></div>';
        $('#homepage-cards').html(cards);
      }
     
    
      setTimeout(function() {
        $('#loading-modal').modal('toggle');
      },500);
    }
    
    function moneyFormat(total)
    {
      var decimal = (Math.round(total * 100) / 100).toFixed(2);
     // var round_off = Math.round((parseInt(parseFloat(decimal)) + Number.EPSILON) * 100) / 100;
      return money_format = parseFloat(decimal).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function getQty(product_code){
      $.ajax({
        url:"/productdetails/get-qty/"+product_code,
        type:"GET",
        success:function(data){
          
          if(data == 0)
          {
           var btn = '<p class="label small" style="margin-left: 14px; margin-top: 17px; font-style: italic; color: red;">Out of stock</p>';
           console.log('oot');
          }
          else{             
            var btn =  '<button class="btn btn-sm card__btn-add ml-auto" product-code='+product_code+' id="btn-add-to-cart-home">Add to cart</button><br>';                  
          }
          $('#btn'+product_code).append(btn);
          console.log(data);
        }
         
       });
    }


    // ADD TO CART
    $(document).on('click', '#btn-add-to-cart', function(){
        var product_code = $(this).attr('product-code');
        var qty = $('#qty-buynow').val();
        console.log(qty);

        console.log(product_code);

        $.ajax({
          url:"/customer/islogged",
          type:"GET",
          success:function(response){
              
            if(response !== 'yes'){
              window.location.href = "/customer-login";
            }
            else{
              $.ajax({ //check QTY
                url:"/inventory/check-qty/"+product_code+'/'+qty,
                type:"GET",
        
                success:function(response){
                  if(response == '1'){         
                    addToCart(product_code, qty);
                  }
                  else{
                      alert('Not enough stock')
                  }
                }
              });    
             
            }
       
          }
           
         });
      
    });

     // ADD TO IN HOMEPAGE
     $(document).on('click', '#btn-add-to-cart-home', function(){
      var product_code = $(this).attr('product-code');
      var qty = $('#qty-buynow').val();
      console.log(qty);

      console.log(product_code);

      $.ajax({
        url:"/customer/islogged",
        type:"GET",
        success:function(response){
            
          if(response !== 'yes'){
            window.location.href = "/customer-login";
          }
          else{
            addToCart(product_code, qty);
          }
     
        }
         
       });
    
  });

    function addToCart(product_code, qty){
      $.ajax({
        url:"/homepage/addtocart",
        type:"POST",
        data: {
            product_code:product_code,
            qty:qty
        },
        beforeSend:function(){
            $('#loading-modal').modal('toggle');
          },
        success:function(){
            setTimeout(function(){
                $('#loading-modal').modal('toggle');
                countCart();
                $('#cartOrHomepageModal').modal('show');
            },500);
          
        }
         
       });
    }

    countCart();

    function countCart(){
      $.ajax({
          url:"/cart/countcart",
          type:"GET",
          success:function(response){
              $('.count-cart').text(response);
              return response;
          }
           
         });
    }

    getCustomerName();

    function getCustomerName(){
     
      $.ajax({
        url:"/account/getaccountinfo",
        type:"GET",
        success:function(data){
          $('#customer-name').text(data[0].fullname);
        }
         
       });
    }

    //buy now 
    $(document).on('click', '#btn-buynow', function(){
      
      var product_code = $(this).attr('product-code');
      var qty = $('#qty-buynow').val();   
      var txt_price = $('#price-buynow').text();
      var price = txt_price.replace(/,/g, ''); // remove commas
      var amount = price * qty;

      buyNow(product_code, qty, amount);
      
    });

    function buyNow(product_code, qty, amount) 
    {
      $.ajax({
        url:"/productdetails/buynow",
        type:"POST",
        data: {
          product_code:product_code,
          qty:qty,
          amount:amount
      },
        success:function(){
          window.location.href = "/checkout";
        }
         
       });
    }
  
});
  
  
  
  
  