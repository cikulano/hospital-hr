<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="SoengSouy Admin Template">
	<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
	<meta name="author" content="SoengSouy Admin Template">
	<meta name="robots" content="noindex, nofollow">
	<title>Reports</title>
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset_url('assets/img/favicon.png') }}">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset_url('assets/css/bootstrap.min.css') }}">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset_url('assets/css/font-awesome.min.css') }}">
	<!-- Lineawesome CSS -->
	<link rel="stylesheet" href="{{ asset_url('assets/css/line-awesome.min.css') }}">
	<!-- Datatable CSS -->
	<link rel="stylesheet" href="{{ asset_url('assets/css/dataTables.bootstrap4.min.css') }}">
	<!-- Select2 CSS -->
	<link rel="stylesheet" href="{{ asset_url('assets/css/select2.min.css') }}">
	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{ asset_url('assets/css/bootstrap-datetimepicker.min.css') }}">
	<!-- Chart CSS -->
	<link rel="stylesheet" href="{{ asset_url('assets/plugins/morris/morris.css') }}">
	<!-- Main CSS -->
	<link rel="stylesheet" href="{{ asset_url('assets/css/style.css') }}">

	{{-- message toastr --}}
	<link rel="stylesheet" href="{{ asset_url('assets/css/toastr.min.css') }}">
	<script src="{{ asset_url('assets/js/toastr_jquery.min.js') }}"></script>
	<script src="{{ asset_url('assets/js/toastr.min.js') }}"></script>

	<!-- Custom JS -->
	<script src="{{ asset_url('assets/js/app.js') }}"></script>
</head>
<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		@yield('content')
		<!-- /Page Wrapper -->
	</div>
	<!-- /Main Wrapper -->
</body>
</html>