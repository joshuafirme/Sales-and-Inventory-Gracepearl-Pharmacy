<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gracepearl Pharmacy</title>
    <link href="{{asset('components/vendor/bootstrap4/css/bootstrap.min.css')}}" rel="stylesheet"> 
    <link href="{{asset('components/vendor/DataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('components/css/master.css')}}" rel="stylesheet">
    <link href="{{asset('components/css/homepage.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700;900&display=swap" rel="stylesheet">
   
    <meta name="csrf-token" content="{{ csrf_token() }}">
 
</head>

<body>
    <div class="wrapper">
        <div id="body" class="active">
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
           
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <div class="sidebar-header" style="margin-left:-16px;  background-color:#2A2F6E">
                                    <img src="../../assets/slogo.jpg" alt="bootraper logo" class="app-logo">
                                    </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                            <a href="{{ url('/') }}" class="nav-item nav-link dropdown-toggle text-secondary">Home</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary">About us</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="{{ url('/contact-us') }}" class="nav-item nav-link dropdown-toggle text-secondary">Contact us</a>
                            </div>
                        </li>
          
                    </ul>
                    <ul class="nav navbar-nav ml-auto">
                    
                        <li class="nav-item dropdown cart">
                            <div class="nav-dropdown">
                            <a href="{{ url('/cart')}}" class="nav-item nav-link dropdown-toggle text-secondary">
                                  <i class="fas fa-shopping-cart"></i>
                                    <span class='badge-cart badge-warning count-cart' id='lblCartCount'></span> </a>
                        
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" id="login-url" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown">
                                    @if(session()->get('avatar'))
                                    <img  class="google-avatar" id="user-profile" src="{{ session()->get('avatar') }}" alt="avatar">
                                    @else
                                    <img  class="google-avatar" id="user-profile" src="{{ asset('assets/male_user_50px.png') }}" alt="avatar">
                                    @endif
                                    <span id="customer-name"> </span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu" id="dropdown-items">
                                    <ul class="nav-list">
                                        <li><a href="{{ url('/account') }}" class="dropdown-item"><i class="fas fa-user"></i> My Account</a></li>
                                        <li><a href="{{ url('/myorders') }}" class="dropdown-item"><i class="fas fa-cube"></i> My Orders</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="{{ url('/customer-login') }}" onclick="logout()" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <section class="content">
                <div class="container-fluid">               
                    @yield('content')

                  
          </div>

              
    
          <script>
          function logout(){
            $.ajax({
            url:"/customer/logout",
            type:"GET",
            success:function(){
                console.log('cust log')
            }
            
          });
      }
            </script>

          <!-- components -->
          <script src="{{asset('components/vendor/jquery3/jquery.min.js')}}"></script>
          <script src="{{asset('components/vendor/bootstrap4/js/bootstrap.bundle.min.js')}}"></script>
          <script src="{{asset('components/vendor/fontawesome5/js/solid.min.js')}}"></script>
          <script src="{{asset('components/vendor/fontawesome5/js/fontawesome.min.js')}}"></script>
          <script src="{{asset('components/js/script.js')}}"></script>
          <script src="{{asset('components/js/alert-auto-close.js')}}"></script>
          <script src="{{asset('components/vendor/DataTables/datatables.min.js')}}"></script>
        
          <!-- scripts -->
          <script src="{{asset('js/customer/homepage.js')}}"></script>
          <script src="{{asset('js/customer/cart.js')}}"></script>
          <script src="{{asset('js/customer/checkout.js')}}"></script>
          <script src="{{asset('js/customer/payment.js')}}"></script>
          <script src="{{asset('js/customer/account.js')}}"></script>
          <script src="{{asset('js/customer/myorder.js')}}"></script>
          <script src="{{asset('js/customer/contact-us.js')}}"></script>
          
          <script type="text/javascript" src="https://js.stripe.com/v2/"></script>


      </body>
      
      </html>