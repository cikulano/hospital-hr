<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
        <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Soeng Souy">
        <meta name="robots" content="noindex, nofollow">
        <title>Settings - HRMS</title>
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ secure_asset('assets/img/favicon.png') }}">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ secure_asset('assets/css/bootstrap.min.css') }}">
        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ secure_asset('assets/css/font-awesome.min.css') }}">
        <!-- Lineawesome CSS -->
        <link rel="stylesheet" href="{{ secure_asset('assets/css/line-awesome.min.css') }}">
        <!-- Select2 CSS -->
        <link rel="stylesheet" href="{{ secure_asset('assets/css/select2.min.css') }}">
        <!-- Main CSS -->
        <link rel="stylesheet" href="{{ secure_asset('assets/css/style.css') }}">
        {{-- message toastr --}}
        <link rel="stylesheet" href="{{ secure_asset('assets/css/toastr.min.css') }}">
        <script src="{{ secure_asset('assets/js/toastr_jquery.min.js') }}"></script>
        <script src="{{ secure_asset('assets/js/toastr.min.js') }}"></script>
    </head>
    @yield('style')
    <style>
        .error {
            color: red;
        }
    </style>
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
                                        <a href="chat.html">
                                            <div class="list-item">
                                                <div class="list-left">
                                                    <span class="avatar">
                                                        <img alt="" src="{{ secure_asset('assets/img/profiles/avatar-09.jpg') }}">
                                                    </span>
                                                </div>
                                                <div class="list-body">
                                                    <span class="message-author">Sarah Smith</span>
                                                    <span class="message-time">8 mins ago</span>
                                                    <div class="clearfix"></div>
                                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio.</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="chat.html">
                                            <div class="list-item">
                                                <div class="list-left">
                                                    <span class="avatar">
                                                        <img alt="" src="{{ secure_asset('assets/img/profiles/avatar-10.jpg') }}">
                                                    </span>
                                                </div>
                                                <div class="list-body">
                                                    <span class="message-author">Jessica Parker</span>
                                                    <span class="message-time">12 mins ago</span>
                                                    <div class="clearfix"></div>
                                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio.</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="chat.html">
                                            <div class="list-item">
                                                <div class="list-left">
                                                    <span class="avatar">
                                                        <img alt="" src="{{ secure_asset('assets/img/profiles/avatar-11.jpg') }}">
                                                    </span>
                                                </div>
                                                <div class="list-body">
                                                    <span class="message-author">Mark Johnson</span>
                                                    <span class="message-time">15 mins ago</span>
                                                    <div class="clearfix"></div>
                                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio.</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="topnav-dropdown-footer">
                                <a href="chat.html">View all Messages</a>
                            </div>
                        </div>
                    </li>
                    <!-- /Message Notifications -->
                    <!-- Profile Menu -->
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <span class="user-img"><img src="{{ secure_asset('assets/img/profiles/avatar-01.jpg') }}" alt=""></span>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="profile.html">My Profile</a>
                            <a class="dropdown-item" href="settings.html">Account Settings</a>
                            <a class="dropdown-item" href="logout.html">Logout</a>
                        </div>
                    </li>
                    <!-- /Profile Menu -->
                </ul>
                <!-- /Header Menu -->
            </div>
            <!-- /Header -->

            <!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner">
                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title">Menu</li>
                            <li class="active">
                                <a href="index.html"><i class="fa fa-home"></i> <span>Dashboard</span></a>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="fa fa-user"></i> <span>HR</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="employees.html">Employees</a></li>
                                    <li><a href="departments.html">Departments</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="fa fa-calendar"></i> <span>Payroll</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="salary.html">Salary</a></li>
                                    <li><a href="payroll.html">Payroll</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="fa fa-envelope"></i> <span>Messages</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="inbox.html">Inbox</a></li>
                                    <li><a href="sent.html">Sent</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="fa fa-cog"></i> <span>Settings</span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="settings.html">General Settings</a></li>
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
            </div>
            <!-- /Page Wrapper -->

            <!-- Footer -->
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 text-center text-sm-left">
                            <p>2024 &copy; <a href="#">HRMS</a>. All rights reserved.</p>
                        </div>
                        <div class="col-md-6 col-sm-12 text-center text-sm-right">
                            <p>Design and developed by <a href="#">Soeng Souy</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Footer -->
        </div>
        <!-- /Main Wrapper -->
    </body>
</html>
