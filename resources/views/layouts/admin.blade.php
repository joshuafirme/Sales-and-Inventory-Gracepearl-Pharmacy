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
        <nav id="sidebar">
            <div class="sidebar-header" style="margin-left:-16px;  background-color:#2A2F6E">
            <img src="../../assets/slogo.jpg" alt="bootraper logo" class="app-logo">
            </div>

            <div class="row mt-1">
            <img src="../../assets/male_user_50px.png" style=" display: block;
            margin-left: auto;
            margin-right: auto;">
            </div>
            <div class="row mb-1">
              
            <a style="color: #494F54; margin:auto"  href="#" class="text-secondary">{{ session()->get('emp-username') }}</a>
                </div>

            <div class="line"></div>

            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="{{ url('/dashboard') }}"><i class="fas fa-chart-bar"></i> Dashboard</a>
                </li>
                <li>
                    <a href="{{ url('/products') }}"><i class="fas fa-search"></i> Products</a>
                </li>

                <li>
                    <a href="#sales-menu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-dollar-sign"></i> Sales</a>
                    <ul class="collapse list-unstyled" id="sales-menu">
                        <li>
                            <a href="{{ url('sales/cashiering') }}"><i class="fas fa-cash-register"></i> Cashiering</a>
                        </li>
                     
                        <li>
                            <a href="{{ url('sales/salesreport') }}"><i class="fas fa-file-invoice-dollar"></i> Sales Report</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ url('/manageorder') }}" ><i class="fas fa-shopping-cart"></i> Manage online orders</a>
                </li>
                <li>
                    <a href="{{ url('/verifycustomer') }}" ><i class="fas fa-user-check"></i> Verify customer</a>
                </li>

                <li>
                    <a href="#inventory-menu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-cube"></i> Inventory </a>
                    <ul class="collapse list-unstyled" id="inventory-menu">
                        <li>
                            <a href="{{ url('/inventory/stockadjustment') }}"><i class="fas fa-sliders-h"></i> Stock Adjustment</a>
                        </li>
                        <li>
                            <a href="{{ url('/inventory/purchaseorder') }}"><i class="fas fa-cart-arrow-down"></i> Purchase Order </a>
                        </li>
                        <li>
                            <a href="{{ url('/inventory/delivery') }}"><i class="fas fa-truck-loading"></i> Supplier Delivery</a>
                        </li>
                        <li>
                            <a href="{{ url('/inventory/notification') }}"><i class="fas fa-bell"></i> Notification</a>
                        </li>
                        <li>
                            <a href="{{ url('/inventory/return') }}"><i class="fas fa-hand-holding"></i> Product Return</a>
                        </li>
                        <li>
                            <a href="{{ url('/inventory/drugdisposal') }}"><i class="fas fa-trash"></i> Drug Disposal<span class="badge badge-warning"></a>
                        </li>
                    </ul>
                </li>
               
                <li>
                    <a href="#reports-menu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-file-contract"></i> Reports</a>
                    <ul class="collapse list-unstyled" id="reports-menu">
                        <li>
                            <a href="blank.html"><i class="fas fa-cube"></i> Inventory Report</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-file-invoice-dollar"></i> Sales Report</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-file-invoice-dollar"></i> Stock Adjustment</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-truck-moving"></i> Supplier Delivery</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-radiation-alt"></i> Expired Products</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-list-ul"></i> Reorder List</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-chart-bar"></i> Fast and Slow Moving</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-hand-holding"></i> Returns</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#tools-menu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-tools"></i> Maintenance</a>
                    <ul class="collapse list-unstyled" id="tools-menu">
                        <li>
                            <a href="{{ url('maintenance/product') }}"><i class="fas fa-boxes"></i> Product</a>
                        </li>
                        <li>
                            <a href="{{ url('maintenance/supplier') }}" ><i class="fas fa-warehouse"></i> Supplier</a>
                        </li>
                        <li>
                            <a href="{{ url('maintenance/category') }}" ><i class="fas fa-list-ul"></i> Category</a>
                        </li>
                        <li>
                            <a href="{{ url('maintenance/unit') }}"><i class="fas fa-box"></i> Unit</a>
                        </li>
                        <li>
                            <a href="{{ url('maintenance/company') }}" ><i class="fas fa-chart-line"></i> Company</a>
                        </li>
                        <li>
                            <a href="{{ url('maintenance/discount') }}" ><i class="fas fa-percentage"></i> Discount</a>
                        </li>
                        <li>
                            <a href="{{ url('maintenance/shipping') }}" ><i class="fas fa-dollar-sign"></i> Shipping Fee</a>
                        </li>
                        <li>
                            <a href="{{ url('maintenance/user') }}"><i class="fas fa-user"></i> User</a>
                        </li>
                    </ul>
                </li>   
                
                <li>
                    <a href="{{ url('admin-login') }}" onclick="logout();"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </nav>
        <div id="body" class="active">
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-outline-secondary default-secondary-menu"><i class="fas fa-bars"></i><span></span></button>
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
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown">
                                    <i class="fas fa-user"></i> <span id="auth-name"> </span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-address-card"></i> Profile</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-envelope"></i> Messages</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="{{ url('admin-login') }}" onclick="logout()" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
          <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    
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

           <!-- verify cutomer -->
           <script src="{{asset('js/verify_customer.js')}}"></script>
           
           <!-- manage order -->
           <script src="{{asset('js/manage_online_order.js')}}"></script>

          <!-- inventory -->
          <script src="{{asset('js/inventory/stockadjustment.js')}}"></script>
          <script src="{{asset('js/inventory/purchase_order.js')}}"></script>
          <script src="{{asset('js/inventory/notification.js')}}"></script>
          <script src="{{asset('js/inventory/supplier_delivery.js')}}"></script>
          <script src="{{asset('js/inventory/return.js')}}"></script>

          <!-- main - count all notifs and get user's name--> 
          <script src="{{asset('js/main.js')}}"></script>

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