@extends('layouts.master')

@section('content')
    <?php  
        $hour   = date ("G");
        $minute = date ("i");
        $second = date ("s");
        $msg = " Today is " . date ("l, M. d, Y.");

        if ($hour == 00 && $hour <= 9 && $minute <= 59 && $second <= 59) {
            $greet = "Good Morning,";
        } else if ($hour >= 10 && $hour <= 11 && $minute <= 59 && $second <= 59) {
            $greet = "Good Day,";
        } else if ($hour >= 12 && $hour <= 15 && $minute <= 59 && $second <= 59) {
            $greet = "Good Afternoon,";
        } else if ($hour >= 16 && $hour <= 23 && $minute <= 59 && $second <= 59) {
            $greet = "Good Evening,";
        } else {
            $greet = "Welcome,";
        }
    ?>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">{{ $greet }} {{ Session::get('name') }}!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                            <div class="dash-widget-info">
                                <h3>112</h3> <span>Projects</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
                            <div class="dash-widget-info">
                                <h3>44</h3> <span>Clients</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                            <div class="dash-widget-info">
                                <h3>37</h3> <span>Tasks</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                            <div class="dash-widget-info">
                                <h3>218</h3> <span>Employees</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Total Revenue</h3>
                                    <canvas id="bar-charts"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Sales Overview</h3>
                                    <canvas id="line-charts"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-group m-b-30">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div> <span class="d-block">New Employees</span> </div>
                                    <div> <span class="text-success">+10%</span> </div>
                                </div>
                                <h3 class="mb-3">10</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mb-0">Overall Employees 218</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div> <span class="d-block">Earnings</span> </div>
                                    <div> <span class="text-success">+12.5%</span> </div>
                                </div>
                                <h3 class="mb-3">Rp 1,42,300</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mb-0">Previous Month <span class="text-muted">$1,15,852</span></p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div> <span class="d-block">Expenses</span> </div>
                                    <div> <span class="text-danger">-2.8%</span> </div>
                                </div>
                                <h3 class="mb-3">Rp 8,500</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div> <span class="d-block">Profit</span> </div>
                                    <div> <span class="text-danger">-75%</span> </div>
                                </div>
                                <h3 class="mb-3">Rp 1,12,000</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <!-- Statistics Widget -->
            <div class="row">
                <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h4 class="card-title">Task Statistics</h4>
                            <div class="statistics">
                                <div class="row">
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Total Tasks</p>
                                            <h3>385</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Overdue Tasks</p>
                                            <h3>19</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-purple" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 22%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">22%</div>
                                <div class="progress-bar bg-success" role="progressbar" style="width: 24%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">24%</div>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 26%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">21%</div>
                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">10%</div>
                            </div>
                            <div>
                                <p><i class="fa fa-dot-circle-o text-purple mr-2"></i>Completed Tasks <span class="float-right">166</span></p>
                                <p><i class="fa fa-dot-circle-o text-warning mr-2"></i>Inprogress Tasks <span class="float-right">115</span></p>
                                <p><i class="fa fa-dot-circle-o text-success mr-2"></i>On Hold Tasks <span class="float-right">31</span></p>
                                <p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Pending Tasks <span class="float-right">47</span></p>
                                <p class="mb-0"><i class="fa fa-dot-circle-o text-info mr-2"></i>Review Tasks <span class="float-right">5</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h4 class="card-title">Today Absent <span class="badge bg-inverse-danger ml-2">5</span></h4>
                            <div class="leave-info-box">
                                <div class="media align-items-center">
                                    <a href="profile.html" class="avatar"><img alt="" src="assets/img/user.jpg"></a>
                                    <div class="media-body">
                                        <div class="text-sm my-0">Martin Lewis</div>
                                    </div>
                                </div>
                                <div class="row align-items-center mt-3">
                                    <div class="col-6">
                                        <h6 class="mb-0">4 Sep 2019</h6> <span class="text-sm text-muted">Leave Date</span> </div>
                                    <div class="col-6 text-right"> <span class="badge bg-inverse-danger">Pending</span> </div>
                                </div>
                            </div>
                            <div class="leave-info-box">
                                <div class="media align-items-center">
                                    <a href="profile.html" class="avatar"><img alt="" src="assets/img/user.jpg"></a>
                                    <div class="media-body">
                                        <div class="text-sm my-0">Martin Lewis</div>
                                    </div>
                                </div>
                                <div class="row align-items-center mt-3">
                                    <div class="col-6">
                                        <h6 class="mb-0">4 Sep 2019</h6> <span class="text-sm text-muted">Leave Date</span> </div>
                                    <div class="col-6 text-right"> <span class="badge bg-inverse-success">Approved</span> </div>
                                </div>
                            </div>
                            <div class="load-more text-center"> <a class="text-dark" href="javascript:void(0);">Load More</a> </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Statistics Widget -->
            <div class="row">
                <div class="col-md-12">
                    <div id="bar-charts"></div>
                </div>
                <div class="col-md-12">
                    <div id="line-charts"></div>
                </div>
                <div class="col-md-12">
                    <canvas id="graph-container"></canvas>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
@endsection