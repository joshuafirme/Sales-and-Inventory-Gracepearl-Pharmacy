<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gracepearl Pharmacy</title>
    <link href="{{asset('components/vendor/bootstrap4/css/bootstrap.min.css')}}" rel="stylesheet"> 
    <link href="{{asset('components/vendor/DataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('components/vendor/summernote/summernote-bs4.css')}}" rel="stylesheet">
    <link href="{{asset('components/css/master.css')}}" rel="stylesheet">
    <link href="{{asset('components/vendor/chartsjs/Chart.min.css')}}" rel="stylesheet">
 <!--   <link href="asset('components/vendor/flagiconcss3/css/flag-icon.min.css')}}" rel="stylesheet">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">

   
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
</head>

<body>
    <div class="wrapper">
        <div id="body" class="active">
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <div class="sidebar-header" style="margin-left:-16px;  background-color:#2A2F6E">
                    <img src="../../assets/slogo.jpg" alt="bootraper logo" class="app-logo">
                    </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">

                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-bell"></i><span class="badge badge-pill badge-danger" id="count-all-notif-bell"></span> </a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="{{ url('/inventory/notification') }}" class="dropdown-item"> Reorder <span class="badge badge-pill badge-success" id="count-reorder-notif"></span> </a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="{{ url('/inventory/notification') }}" class="dropdown-item"> Near Expiry <span class="badge badge-pill badge-warning" id="count-expiry-notif"></span></a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="{{ url('/inventory/notification') }}" class="dropdown-item"> Expired <span class="badge badge-pill badge-danger" id="count-expired-notif"></span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-user"></i> <span> Joshua Firme</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-address-card"></i> Profile</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-envelope"></i> Messages</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="{{ url('admin-login') }}" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
            url:"/admin-login/logout",
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
          <script src="{{asset('components/vendor/chartsjs/Chart.min.js')}}"></script>
          <script src="{{asset('components/js/dashboard-charts.js')}}"></script>
          <script src="{{asset('components/js/script.js')}}"></script>
          <script src="{{asset('components/js/alert-auto-close.js')}}"></script>
          <script src="{{asset('components/jquery-tabledit-master/jquery.tabledit.min.js')}}"></script>
          <script src="{{asset('components/vendor/summernote/summernote-bs4.min.js')}}"></script>
          <script src="{{asset('components/js/initiate-summernote.js')}}"></script>
    
          <!-- maintenance -->
          <script src="{{asset('js/maintenance/product_maintenance.js')}}"></script>
          <script src="{{asset('js/maintenance/category_maintenance.js')}}"></script>
          <script src="{{asset('js/maintenance/supplier_maintenance.js')}}"></script>
          <script src="{{asset('js/maintenance/unit_maintenance.js')}}"></script>
          <script src="{{asset('js/maintenance/company_maintenance.js')}}"></script>
          <script src="{{asset('js/maintenance/user_maintenance.js')}}"></script>

          <!-- sales -->
          <script src="{{asset('js/sales/cashiering.js')}}"></script>
          <script src="{{asset('js/sales/sales_report.js')}}"></script>

          <!-- inventory -->
          <script src="{{asset('js/inventory/stockadjustment.js')}}"></script>
          <script src="{{asset('js/inventory/purchase_order.js')}}"></script>
          <script src="{{asset('js/inventory/notification.js')}}"></script>
          <script src="{{asset('js/inventory/supplier_delivery.js')}}"></script>
          <script src="{{asset('js/inventory/return.js')}}"></script>


          <!-- count all notif -->
          <script src="{{asset('js/count_all_notif.js')}}"></script>

          <script src="{{asset('js/products.js')}}"></script>

          <script src="{{asset('components/vendor/DataTables/datatables.min.js')}}"></script>
          <script type="text/javascript" language="javascript" src="https://nightly.datatables.net/buttons/js/dataTables.buttons.min.js"></script>
          <script type="text/javascript" language="javascript" src="https://nightly.datatables.net/buttons/js/buttons.flash.min.js"></script>
          <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
          <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
          <script type="text/javascript" language="javascript" src="https://nightly.datatables.net/buttons/js/buttons.html5.min.js"></script>
          <script type="text/javascript" language="javascript" src="https://nightly.datatables.net/buttons/js/buttons.print.min.js"></script>
          <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/1.10.22/api/sum().js"></script>

      </body>
      
      </html>