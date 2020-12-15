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
                                <a href="{{ url('/homepage') }}" class="nav-item nav-link dropdown-toggle text-success"><b style="font-size: 18px">Gracepearl Pharmacy</b></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                            <a href="{{ url('/homepage') }}" class="nav-item nav-link dropdown-toggle text-secondary">Home</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary">About us</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary">Contact us</a>
                            </div>
                        </li>
          
                    </ul>
                    <ul class="nav navbar-nav ml-auto">
                    
                        <li class="nav-item dropdown cart">
                            <div class="nav-dropdown">
                            <a href="{{ url('/cart')}}" class="nav-item nav-link dropdown-toggle text-secondary">  <i class="fas fa-shopping-cart"></i>
                                    <span class='badge-cart badge-warning count-cart' id='lblCartCount'></span> </a>
                        
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown">
                                    <img class="google-avatar" src="{{ session()->get('avatar')}}" alt="avatar"> 
                                    <span>{{ session()->get('name')}}</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cube"></i> My Orders</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-envelope"></i> Messages</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="{{ url('customer-login') }}" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
            console.log('logout');
            $.ajax({
            url:"/customer/logout",
            type:"GET",
            success:function(){
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

          <script src="{{asset('js/homepage.js')}}"></script>
          <script src="{{asset('js/cart.js')}}"></script>



      </body>
      
      </html>