@extends('layouts.admin')

@section('content')

<div class="page-header">
  <h3 class="mt-2" id="page-title">Dashboard</h3>
          <hr>
      </div>


        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="icon-big text-center">
                                    <i class="fas fa-shopping-cart" style="color:#5CB85C;"></i>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="detail text-center">
                                    <p>New Orders</p>
                                    <span class="number">{{ $newOrders}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr />
                            <div class="stats">
                                <i class="fas fa-redo-alt"></i> Updated every 30 minutes
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="icon-big text-center">
                                    <i class="fas fa-money-bill-alt" style="color:#5CB85C;"></i>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="detail text-center">
                                    <p>Walk-in Sales</p>
                                  <span class="number">₱{{ number_format($walkinSales, 2, '.',',')  }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr />
                            <div class="stats">
                                <i class="fas fa-calendar"></i> In this current Month
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="icon-big text-center">
                                    <i class="fas fa-dollar-sign" style="color:#5CB85C;"></i>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="detail text-center">
                                    <p>Online Sales</p>
                                    <span class="number">₱{{ number_format($onlineSales, 2, '.',',')  }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr />
                            <div class="stats">
                                <i class="fas fa-calendar"></i> In this current Month
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="icon-big text-center">
                                    <i class="fas fa-users" style="color:#5CB85C;"></i>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="detail text-center">
                                    <p>Registered Customer</p>
                                    <span class="number">{{ $registeredCustomer }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr />
                            <div class="stats">
                                <i class="fas fa-users"></i> Current Registered Customer
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="content">
                        <div class="head">
                            <h4 class="mb-0">Traffic Overview</h4>
                            <p class="text-muted">Your year long website traffic data</p>
                        </div>
                        <div class="canvas-wrapper">
                            <canvas class="chart" id="trafficflow"></canvas>
                        </div>
                        <div class="ui hidden divider"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="content">
                        <div class="head">
                            <h4 class="mb-0">Sales Overview</h4>
                            <p class="text-muted">Your year long sales data</p>
                        </div>
                        <div class="canvas-wrapper">
                            <canvas class="chart" id="sales"></canvas>
                        </div>
                        <div class="ui hidden divider"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="content">
                        <div class="head">
                            <h4 class="mb-0">Top Visitors by Country</h4>
                            <p class="text-muted">Your year long website traffic data</p>
                        </div>
                        <div class="canvas-wrapper">
                            <table class="table no-margin bg-lighter-grey">
                                <thead class="success">
                                    <tr>
                                        <th>Country</th>
                                        <th class="text-right">Unique Visitors</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-us"></i> United States</td>
                                        <td class="text-right">27,340</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-in"></i> India</td>
                                        <td class="text-right">21,280</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-jp"></i> Japan</td>
                                        <td class="text-right">18,210</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-gb"></i> United Kingdom</td>
                                        <td class="text-right">15,176</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-es"></i> Spain</td>
                                        <td class="text-right">14,276</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-de"></i> Germany</td>
                                        <td class="text-right">13,176</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-br"></i> Brazil</td>
                                        <td class="text-right">12,176</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-id"></i> Indonesia</td>
                                        <td class="text-right">11,886</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-ph"></i> Philippines</td>
                                        <td class="text-right">11,509</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-sg"></i> Singapore</td>
                                        <td class="text-right">1,700</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="content">
                        <div class="head">
                            <h4 class="mb-0">Most Sales by Country</h4>
                            <p class="text-muted">Your year long sales data</p>
                        </div>
                        <div class="canvas-wrapper">
                            <table class="table no-margin bg-lighter-grey">
                                <thead class="success">
                                    <tr>
                                        <th>Country</th>
                                        <th class="text-right">No. Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-us"></i> United States</td>
                                        <td class="text-right">7,200</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-in"></i> India</td>
                                        <td class="text-right">6,190</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-jp"></i> Japan</td>
                                        <td class="text-right">4,790</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-gb"></i> United Kingdom</td>
                                        <td class="text-right">4,480</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-es"></i> Spain</td>
                                        <td class="text-right">4,276</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-de"></i> Germany</td>
                                        <td class="text-right">3,455</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-br"></i> Brazil</td>
                                        <td class="text-right">3,201</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-id"></i> Indonesia</td>
                                        <td class="text-right">1,996</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-ph"></i> Philippines</td>
                                        <td class="text-right">1,809</td>
                                    </tr>
                                    <tr>
                                        <td><i class="flag-icon flag-icon-sg"></i> Singapore</td>
                                        <td class="text-right">1,550</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-4">
                <div class="card">
                    <div class="content">
                        <div class="head">
                            <h4 class="mb-0">Top Referrals</h4>
                            <p class="text-muted">Your year long website traffic data</p>
                        </div>
                        <div class="canvas-wrapper">
                            <table class="table no-margin bg-lighter-grey">
                                <thead class="success">
                                    <tr>
                                        <th>Refferer</th>
                                        <th class="text-right">Traffic</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="darkgray fas fa-link"></i> Google.com</td>
                                        <td class="text-right">9,340</td>
                                    </tr>
                                    <tr>
                                        <td><i class="darkgray fas fa-link"></i> Facebook.com</td>
                                        <td class="text-right">8,280</td>
                                    </tr>
                                    <tr>
                                        <td><i class="darkgray fas fa-link"></i> Instragram.com</td>
                                        <td class="text-right">6,210</td>
                                    </tr>
                                    <tr>
                                        <td><i class="darkgray fas fa-link"></i> Yourwebsite.com</td>
                                        <td class="text-right">5,176</td>
                                    </tr>
                                    <tr>
                                        <td><i class="darkgray fas fa-link"></i> Youtube.com</td>
                                        <td class="text-right">4,276</td>
                                    </tr>
                                    <tr>
                                        <td><i class="darkgray fas fa-link"></i> Direct</td>
                                        <td class="text-right">3,176</td>
                                    </tr>
                                    <tr>
                                        <td><i class="darkgray fas fa-link"></i> Duckduckgo.com</td>
                                        <td class="text-right">2,176</td>
                                    </tr>
                                    <tr>
                                        <td><i class="darkgray fas fa-link"></i> Landingpage.com</td>
                                        <td class="text-right">1,886</td>
                                    </tr>
                                    <tr>
                                        <td><i class="darkgray fas fa-link"></i> Giantweb.come</td>
                                        <td class="text-right">1,509</td>
                                    </tr> 
                                    <tr>
                                        <td><i class="darkgray fas fa-link"></i> Unknown</td>
                                        <td class="text-right">890</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-3">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="dfd text-center">
                                <i class="blue large-icon mb-2 fas fa-thumbs-up"></i>
                                <h4 class="mb-0">+21,900</h4>
                                <p class="text-muted">FACEBOOK PAGE LIKES</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-3">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="dfd text-center">
                                <i class="orange large-icon mb-2 fas fa-reply-all"></i>
                                <h4 class="mb-0">+22,566</h4>
                                <p class="text-muted">INSTAGRAM FOLLOWERS</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-3">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="dfd text-center">
                                <i class="grey large-icon mb-2 fas fa-envelope"></i>
                                <h4 class="mb-0">+15,566</h4>
                                <p class="text-muted">E-MAIL SUBSCRIBERS</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-3">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="dfd text-center">
                                <i class="olive large-icon mb-2 fas fa-dollar-sign"></i>
                                <h4 class="mb-0">+98,601</h4>
                                <p class="text-muted">TOTAL SALES</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  

@endsection



