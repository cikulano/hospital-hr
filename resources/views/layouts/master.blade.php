<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="SoengSouy Admin Template">
	<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
	<meta name="author" content="SoengSouy Admin Template">
	<meta name="robots" content="noindex, nofollow">
	<title>Dashboard - HRMS</title>
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('assets/img/favicon.png') }}">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
	<!-- Lineawesome CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css') }}">
	<!-- Datatable CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
	<!-- Select2 CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
	<!-- Chart CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}">
	<!-- Main CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

	{{-- message toastr --}}
	<link rel="stylesheet" href="{{ URL::to('assets/css/toastr.min.css') }}">
	<script src="{{ asset('assets/js/toastr_jquery.min.js') }}"></script>
	<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
</head>

<body>
	@yield('style')
	<style>    
		.invalid-feedback{
			font-size: 14px;
		}
		.error{
			color: red;
		}
	</style>
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<!-- Loader -->
		<div id="loader-wrapper">
			<div id="loader">
				<div class="loader-ellips">
				  <span class="loader-ellips__dot"></span>
				  <span class="loader-ellips__dot"></span>
				  <span class="loader-ellips__dot"></span>
				  <span class="loader-ellips__dot"></span>
				</div>
			</div>
		</div>
		<!-- /Loader -->

		<!-- Header -->
		<div class="header">
			<!-- Logo -->
			<div class="header-left">
				<a href="{{ route('home') }}" class="logo">
					<img src="{{ URL::to('/assets/images/'. Auth::user()->avatar) }}" width="40" height="40" alt="">
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
				<h3>Hi, {{ Session::get('name') }}</h3>
			</div>
			<!-- /Header Title -->
			<a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
			<!-- Header Menu -->
			<ul class="nav user-menu">
				<!-- Search -->
				<li class="nav-item">
					<div class="top-nav-search">
						<a href="javascript:void(0);" class="responsive-search"> <i class="fa fa-search"></i> </a>
						<form action="search.html">
							<input class="form-control" type="text" placeholder="Search here">
							<button class="btn" type="submit">
								<i class="fa fa-search"></i>
							</button>
						</form>
					</div>
				</li>
				<!-- /Search -->

				<!-- Flag -->
				<li class="nav-item dropdown has-arrow flag-nav">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
						<img src="{{ URL::to('assets/img/flags/us.png') }}" alt="" height="20"> <span>English</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a href="javascript:void(0);" class="dropdown-item">
						<img src="{{ URL::to('assets/img/flags/us.png') }}" alt="" height="16"> English </a>
						<a href="javascript:void(0);" class="dropdown-item">
						<img src="{{ URL::to('assets/img/flags/kh.png') }}" alt="" height="16"> Khmer </a>
					</div>
				</li>
				<!-- /Flag -->

				<!-- Notifications -->
				<li class="nav-item dropdown">
					<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
						<i class="fa fa-bell-o"></i>
						<span class="badge badge-pill">3</span> 
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
												<img alt="" src="{{ URL::to('/assets/images/'.Auth::user()->avatar) }}">
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
												<img alt="" src="{{ URL::to('/assets/images/'.Auth::user()->avatar) }}">
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
												<img alt="" src="{{ URL::to('/assets/images/'.Auth::user()->avatar) }}">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Misty Tison</span
