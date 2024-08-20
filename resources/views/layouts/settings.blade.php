<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    
    <title>Jobs - HRMS admin dashboard</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ secure_asset('assets/img/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ secure_asset('assets/css/bootstrap.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ secure_asset('assets/css/font-awesome.min.css') }}">
    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="{{ secure_asset('assets/css/line-awesome.min.css') }}">
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ secure_asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ secure_asset('assets/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ secure_asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ secure_asset('assets/css/style.css') }}">
    {{-- message toastr --}}
    <link rel="stylesheet" href="{{ secure_asset('assets/css/toastr.min.css') }}">
    <script src="{{ secure_asset('assets/js/toastr_jquery.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/toastr.min.js') }}"></script>

    @yield('style')
    <style>
        .error {
            color: red;
        }
    </style>

</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            <!-- Logo -->
            <div class="header-left">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ secure_asset('assets/img/logo.png') }}" width="40" height="40" alt="">
                </a>
            </div>
            <!-- /Logo -->
            <a id="toggle_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <!-- Header Title -->
            <div class="page-title-box">
                <h3>{{ Auth::user()->name }}</h3>
            </div>
            <!-- /Header Title -->
            <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
            <!-- Header Menu -->
            <ul class="nav user-menu">
                <!-- Search -->
                <li class="nav-item">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="search.html">
                            <input class="form-control" type="text" placeholder="Search here">
                            <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </li>
                <!-- /Search -->
                <!-- Flag -->
                <li class="nav-item dropdown has-arrow flag-nav">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                        <img src="{{ secure_asset('assets/img/flags/us.png') }}" alt="" height="20"> <span>English</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="javascript:void(0);" class="dropdown-item"><img src="{{ secure_asset('assets/img/flags/us.png') }}" alt="" height="16"> English</a>
                        <a href="javascript:void(0);" class="dropdown-item"><img src="{{ secure_asset('assets/img/flags/kh.png') }}" alt="" height="16"> Khmer</a>
                    </div>
                </li>
                <!-- /Flag -->
                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i> <span class="badge badge-pill">3</span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img alt="" src="{{ secure_asset('assets/img/profiles/avatar-02.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
                                                <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img alt="" src="{{ secure_asset('assets/img/profiles/avatar-03.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
                                                <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img alt="" src="{{ secure_asset('assets/img/profiles/avatar-06.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
                                                <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img alt="" src="{{ secure_asset('assets/img/profiles/avatar-17.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
                                                <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img alt="" src="{{ secure_asset('assets/img/profiles/avatar-13.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
                                                <p class="noti-time"><span class="notification-time">2 days ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="activities.html">View all Notifications</a>
                        </div>
                    </div>
                </li>
                <!-- /Notifications -->
                <!-- Message Notifications -->
                <li class="nav-item dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="fa fa-comment-o"></i> <span class="badge badge-pill">8</span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Messages</span>
                            <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img alt="" src="{{ secure_asset('assets/img/profiles/avatar-02.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span class="noti-title">John Doe</span> sent a message</p>
                                                <p class="noti-time"><span class="notification-time">1 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img alt="" src="{{ secure_asset('assets/img/profiles/avatar-03.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span class="noti-title">Tarah Shropshire</span> sent a message</p>
                                                <p class="noti-time"><span class="notification-time">5 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img alt="" src="{{ secure_asset('assets/img/profiles/avatar-06.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span class="noti-title">Misty Tison</span> sent a message</p>
                                                <p class="noti-time"><span class="notification-time">10 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="activities.html">View all Messages</a>
                        </div>
                    </div>
                </li>
                <!-- /Message Notifications -->
                <!-- User Menu -->
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <span class="user-img"><img src="{{ secure_asset('assets/img/profiles/avatar-21.jpg') }}" alt="">
                            <span class="status online"></span></span>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="profile.html">My Profile</a>
                        <a class="dropdown-item" href="settings.html">Settings</a>
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </li>
                <!-- /User Menu -->
            </ul>
            <!-- /Header Menu -->
        </div>
        <!-- /Header -->

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-menu">
                    <ul>
                        <li class="menu-title">Main</li>
                        <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
                        <li class="submenu {{ Request::is('users*') || Request::is('roles*') ? 'active' : '' }}">
                            <a href="#"><i class="fa fa-user"></i> <span> Users </span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li class="{{ Request::is('users') ? 'active' : '' }}"><a href="{{ route('users.index') }}">Users List</a></li>
                                <li class="{{ Request::is('roles') ? 'active' : '' }}"><a href="{{ route('roles.index') }}">Roles</a></li>
                            </ul>
                        </li>
                        <li class="submenu {{ Request::is('settings*') ? 'active' : '' }}">
                            <a href="#"><i class="fa fa-cogs"></i> <span> Settings </span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li class="{{ Request::is('settings/general') ? 'active' : '' }}"><a href="{{ route('settings.general') }}">General Settings</a></li>
                                <li class="{{ Request::is('settings/other') ? 'active' : '' }}"><a href="{{ route('settings.other') }}">Other Settings</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Sidebar -->

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content">
                @yield('content')
            </div>
            <!-- /Page Content -->

            <!-- Footer -->
            <div class="footer">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <ul class="list-unstyled">
                            <li><a href="javascript:void(0);">Terms of Service</a></li>
                            <li><a href="javascript:void(0);">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <p>2024 &copy; Your Company. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
            <!-- /Footer -->
        </div>
        <!-- /Page Wrapper -->
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ secure_asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <!-- Bootstrap Core JS -->
    <script src="{{ secure_asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Slimscroll JS -->
    <script src="{{ secure_asset('assets/js/jquery.slimscroll.min.js') }}"></script>
    <!-- Select2 JS -->
    <script src="{{ secure_asset('assets/js/select2.min.js') }}"></script>
    <!-- Datetimepicker JS -->
    <script src="{{ secure_asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Datatable JS -->
    <script src="{{ secure_asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ secure_asset('assets/js/app.js') }}"></script>

    @yield('script')

</body>

</html>
