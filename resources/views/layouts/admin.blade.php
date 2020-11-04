<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gracepearl Pharmacy</title>
    <link href="{{asset('components/vendor/bootstrap4/css/bootstrap.min.css')}}" rel="stylesheet"> 
    <link href="{{asset('components/vendor/DataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('components/css/master.css')}}" rel="stylesheet">
    <link href="{{asset('components/vendor/chartsjs/Chart.min.css')}}" rel="stylesheet">
    <link href="{{asset('components/vendor/flagiconcss3/css/flag-icon.min.css')}}" rel="stylesheet">
   
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header" style="margin-left:-16px;  background-color:#2A2F6E">
            <img src="../../assets/slogo.jpg" alt="bootraper logo" class="app-logo">
            </div>
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="{{ url('/dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a href="{{ url('/dashboard') }}"><i class="fas fa-search"></i> Product Search</a>
                </li>

                <li>
                    <a href="#sales-menu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-file-invoice"></i> Sales</a>
                    <ul class="collapse list-unstyled" id="sales-menu">
                        <li>
                            <a href="{{ url('sales/cashiering') }}"><i class="fas fa-cash-register"></i> Cashiering</a>
                        </li>
                     
                        <li>
                            <a href="500.html"><i class="fas fa-file-invoice-dollar"></i> Sales Report</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#orders-menu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-shopping-cart"></i> Manage Online Orders</a>
                    <ul class="collapse list-unstyled" id="orders-menu">
                        <li>
                            <a href="{{ url('sales/cashiering') }}"><i class="fas fa-file-prescription"></i>Prescription Approval<span style="color: #fff" class="badge badge-warning"> 20</span></a>
                        </li>
                     
                        <li>
                            <a href="500.html"><i class="fas fa-history"></i> Pending</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-truck-pickup"></i> Ready To Ship</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-shipping-fast"></i> Shipped</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-check-circle"></i> Completed</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-times-circle"></i> Bad Order</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#inventory-menu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-cube"></i> Inventory </a>
                    <ul class="collapse list-unstyled" id="inventory-menu">
                        <li>
                            <a href="{{ url('/inventory/stockadjustment') }}"><i class="fas fa-sliders-h"></i> Stock Adjustment</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-boxes"></i> Purchase Order </a>
                        </li>
                        <li>
                            <a href="404.html"><i class="fas fa-truck-loading"></i> Supplier Delivery</a>
                        </li>
                        <li>
                            <a href="404.html"><i class="fas fa-bell"></i> Notifications <span class="badge badge-danger"> 20</span></a>
                        </li>
                        <li>
                            <a href="404.html"><i class="fas fa-hand-holding"></i> Product Return</a>
                        </li>
                        <li>
                            <a href="404.html"><i class="fas fa-flag"></i> Weed <span class="badge badge-warning" style="color: #fff;"> 20</span></a>
                        </li>
                    </ul>
                </li>
               
                <li>
                    <a href="#reports-menu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-file-contract"></i> Reports</a>
                    <ul class="collapse list-unstyled" id="reports-menu">
                        <li>
                            <a href="blank.html"><i class="fas fa-file-contract"></i> Inventory Report</a>
                        </li>
                        <li>
                            <a href="404.html"><i class="fas fa-truck-moving"></i> Delivery Report</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-file-invoice-dollar"></i> Sales Report</a>
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
                            <a href="{{ url('maintenance/discount') }}" ><i class="fas fa-percent"></i> Discount</a>
                        </li>
                        <li>
                            <a href="{{ url('maintenance/category') }}" ><i class="fas fa-dollar-sign"></i> Shipping Fee</a>
                        </li>
                    </ul>
                </li>   
                <li>
                    <a href="#utility-menu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-user-cog"></i> Utility</a>
                    <ul class="collapse list-unstyled" id="utility-menu">
                        <li>
                            <a ><i class="fas fa-user"></i> User Maintenance</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="body" class="active">
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-outline-secondary default-secondary-menu"><i class="fas fa-bars"></i><span></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                       <!-- <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-link"></i> <span>Quick Links</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-list"></i> Access Logs</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-database"></i> Back ups</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cloud-download-alt"></i> Updates</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-user-shield"></i> Roles</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>-->
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-user"></i> <span> Joshua Firme</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-address-card"></i> Profile</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-envelope"></i> Messages</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="{{ url('login-backend') }}" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
          <script src="{{asset('components/vendor/jquery3/jquery.min.js')}}"></script>
          <script src="{{asset('components/vendor/bootstrap4/js/bootstrap.bundle.min.js')}}"></script>
          <script src="{{asset('components/vendor/fontawesome5/js/solid.min.js')}}"></script>
          <script src="{{asset('components/vendor/fontawesome5/js/fontawesome.min.js')}}"></script>
          <script src="{{asset('components/vendor/chartsjs/Chart.min.js')}}"></script>

          <script src="{{asset('components/js/dashboard-charts.js')}}"></script>
          <script src="{{asset('components/js/script.js')}}"></script>
          <script src="{{asset('components/js/alert-auto-close.js')}}"></script>
          <script src="{{asset('components/jquery-tabledit-master/jquery.tabledit.min.js')}}"></script>
    
          <!-- maintenance -->
          <script src="{{asset('js/maintenance/product_maintenance.js')}}"></script>
          <script src="{{asset('js/maintenance/category_maintenance.js')}}"></script>
          <script src="{{asset('js/maintenance/supplier_maintenance.js')}}"></script>
          <script src="{{asset('js/maintenance/unit_maintenance.js')}}"></script>

          <!-- inventory -->
          <script src="{{asset('js/cashiering/cashiering.js')}}"></script>

          <!-- inventory -->
          <script src="{{asset('js/inventory/stockadjustment.js')}}"></script>

          <script src="{{asset('components/vendor/DataTables/datatables.min.js')}}"></script>

      </body>
      
      </html>