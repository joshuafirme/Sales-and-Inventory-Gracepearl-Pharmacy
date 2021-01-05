
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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
              $('#login-url').attr("href", "http://127.0.0.1:8000/customer-login");
          }
     
        }
         
       });
    }
  
    var limit = 8;

    $('#btn-viewmore').click(function () {
        limit += 8;
        console.log(limit);
        var search_key = $('#search-product').val();
        var categories = getCategories();
  
        searchProduct(search_key, categories, limit);
    });
    
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
          setTimeout(function() {
            $('#loading-modal').modal('toggle');
          },800);
      },
        success:function(data){
          cardHTML(data); 
    
        }
         
       });
    }

    function getCategories() {
      var categories = [];
      $(':checkbox:checked').each(function(i){
        categories[i] = $(this).val();
      });
      categories = categories.join(", ");
      console.log(categories);

      
      console.log('length: '+categories.length)
      return categories
    }

    $('[name="chk-category[]"]').click(function () {
      var search_key = $('#search-product').val();
      var categories = getCategories();

      if(categories.length == 0){
        
        console.log('length is 0');
        displayAllProduct(limit);
      }
      else{
        searchProduct(search_key, categories, limit);
      }
    });

    $('#search-product').blur(function() {
        var search_key = $(this).val();
        var categories = getCategories();

        searchProduct(search_key, categories, limit);
    });

    function searchProduct(search_key, categories, limit) {
      if(search_key == ''){
        search_key = ' ';
      }
      $.ajax({
        url:"/homepage/searchproduct/"+search_key,
        type:"GET",
        data:{
          categories:categories,
          limit:limit
        },
          beforeSend:function(){
            $('#loading-modal').modal('toggle');
            setTimeout(function() {
              $('#loading-modal').modal('toggle');
            },800);
          },
          success:function(data){
            console.log(data);
            cardHTML(data);

          }  
       });
    }
    function cardHTML(data){

      $('#homepage-cards').html('');
      
      for (var i = 0; i < data.length; i++) {
        
        var cards = ' <div class="card-product"><a class="card__image-container div-product-details" href="/productdetails/'+data[i].product_code+' ">';
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
        cards += '<p class="mt-3 text-success">₱ '+data[i].selling_price+'</p>';
        cards += '<button class="btn btn-sm card__btn-add ml-auto" product-code='+data[i].product_code+' id="btn-add-to-cart">Add to cart</button><br>';      
        cards += '</div></div></div>';    
        
       $('#homepage-cards').append(cards);
      }
      
    }
    


    $(document).on('click', '#btn-add-to-cart', function(){
        var product_code = $(this).attr('product-code');
        console.log(product_code);

        $.ajax({
          url:"/customer/islogged",
          type:"GET",
          success:function(response){
              
            if(response !== 'yes'){
              window.location.href = "http://127.0.0.1:8000/customer-login";
            }
            else{
              $.ajax({
                url:"/homepage/addtocart",
                type:"POST",
                data: {
                    product_code:product_code
                },
                beforeSend:function(){
                    $('#loading-modal').modal('toggle');
                  },
                success:function(){
                    setTimeout(function(){
                        $('#loading-modal').modal('toggle');
                        countCart();
                    },500);
                  
                }
                 
               });
            }
       
          }
           
         });
      
    });

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

    if($('ul li').length > 3){

      $('ul li').length - 10;
      var highlights = $('#highlights').text()
      highlights.replace(50, '...');
    }

    $(document).on('click', '#btn-view-more', function(){

     

     
    
  });
    
  
});
  
  
  
  
  