<!DOCTYPE html>
<html lang="en">
<?php

// start session
session_start();
// check if session is set
if (!isset($_SESSION['login'])) {
	// if session is set, redirect to dashboard
	header("Location: login.php");
}

include 'helper.php';
foreach (glob("orm/*.php") as $filename) {
	include $filename;
}

$page = 'dashboard';
if (isset($_GET['page'])) {
	$page = $_GET['page'] == '' ? 'dashboard' : $_GET['page'];
}

$aksi = '';
if (isset($_GET['aksi'])) {
	$aksi = $_GET['aksi'] == '' ? '' : $_GET['aksi'];
}

?>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dashboard</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- JQVMap -->
	<link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/adminlte.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
	<!-- summernote -->
	<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
	<!-- Select2 bootstrap -->
	<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">

		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
			</ul>

			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<!-- logout  -->
					<a class="nav-link" href="logout.php">
						<i class="fas fa-sign-out-alt"></i>
						<span>Logout</span>
					</a>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="<?= site_url('dashboard') ?>" class="brand-link">
				<div class="row">
					<div class="col-md-12">
						<img src="assets/img/POLIBAN.png" alt="PT PRIMA KIMIA SURYATAMA" class="brand-image img-circle elevation-3" style="opacity: .8">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<span class="brand-text font-weight-light text-wrap">
							PT. PRIMA KIMIA SURYATAMA
						</span>
					</div>
				</div>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user panel (optional) -->
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<!-- icon user font awesome white bg-primary -->
						<i class="fas fa-user-circle fa-3x text-white"></i>
					</div>
					<div class="info">
						<a href="#" class="d-block"><?= $_SESSION['nama_user'] ?></a>
					</div>
				</div>

				<!-- SidebarSearch Form -->
				<div class="form-inline">
					<div class="input-group" data-widget="sidebar-search">
						<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
						<div class="input-group-append">
							<button class="btn btn-sidebar">
								<i class="fas fa-search fa-fw"></i>
							</button>
						</div>
					</div>
				</div>

				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

						<!-- Dashboard -->
						<li class="nav-item">
							<a href="<?= site_url('dashboard') ?> " class="nav-link <?= $page == 'dashboard' ? 'active' : '' ?>">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>
									Dashboard
								</p>
							</a>
						</li>

						<?php if ($_SESSION['level'] == 'gandi' || $_SESSION['level'] == 'rasel' || $_SESSION['level'] == 'admin') : ?>

							<!-- Data Master  -->
							<li class="nav-item   <?= $page == 'barang' ||  $page == 'supplier' || $page == 'pelanggan' || $page == 'user' ? 'menu-open' : '' ?>">
								<a href="#" class="nav-link">
									<i class="fas fa-asterisk"></i>
									<p>
										Data Master
										<i class="fas fa-angle-left right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<?php if ($_SESSION['level'] == 'gandi' || $_SESSION['level'] == 'rasel' || $_SESSION['level'] == 'admin') : ?>
										<!-- Data Barang -->
										<li class="nav-item">
											<a href="<?= site_url('barang') ?> " class="nav-link  <?= $page == 'barang' ? 'active' : '' ?>">
												<i class="far fa-circle nav-icon"></i>
												<p>Data Barang</p>
											</a>
										</li>
									<?php endif; ?>

									<?php if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'rasel') : ?>
										<!-- Data Supplier -->
										<li class="nav-item">
											<a href="<?= site_url('supplier') ?> " class="nav-link <?= $page == 'supplier' ? 'active' : '' ?>">
												<i class="far fa-circle nav-icon"></i>
												<p>Data Supplier</p>
											</a>
										</li>

										<!-- Data Customer -->
										<li class="nav-item">
											<a href=" <?= site_url('pelanggan') ?> " class="nav-link <?= $page == 'pelanggan' ? 'active' : '' ?>">
												<i class="far fa-circle nav-icon"></i>
												<p>Data Customer</p>
											</a>
										</li>
									<?php endif; ?>

									<?php if ($_SESSION['level'] == 'admin') : ?>
										<!-- Data User -->
										<li class="nav-item">
											<a href=" <?= site_url('user') ?> " class="nav-link <?= $page == 'user' ? 'active' : '' ?>">
												<i class="far fa-circle nav-icon"></i>
												<p>Data User</p>
											</a>
										</li>
									<?php endif; ?>


								</ul>
							</li>
						<?php endif; ?>

						<!-- Data Transaksi -->
						<li class="nav-item <?= $page == 'penjualan' || $page == 'pembelian' || $page == 'kas-masuk' || $page == 'kas-keluar' || $page == 'kartu-persediaan' ? 'menu-open' : '' ?>">
							<a href="#" class="nav-link">
								<i class="fas fa-file-invoice-dollar"></i>
								<p>
									Data Transaksi
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<?php if ($_SESSION['level'] == 'rasel' || $_SESSION['level'] == 'gandi' || $_SESSION['level'] == 'admin') : ?>
									<!-- Data Penjualan -->
									<li class="nav-item">
										<a href="<?= site_url('penjualan') ?> " class="nav-link <?= $page == 'penjualan' ? 'active' : '' ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Data Penjualan</p>
										</a>
									</li>

									<!-- Data Pembelian -->
									<li class="nav-item">
										<a href="<?= site_url('pembelian') ?> " class="nav-link <?= $page == 'pembelian' ? 'active' : '' ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Data Pembelian</p>
										</a>
									</li>
								<?php endif; ?>

								<?php if ($_SESSION['level'] == 'gandi' || $_SESSION['level'] == 'admin') : ?>
									<!-- Data Pembelian -->
									<li class="nav-item">
										<a href="<?= site_url('kartu-persediaan') ?> " class="nav-link <?= $page == 'kartu-persediaan' ? 'active' : '' ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Kartu Persediaan</p>
										</a>
									</li>
								<?php endif; ?>

								<?php if ($_SESSION['level'] == 'dea' || $_SESSION['level'] == 'admin') : ?>

									<!-- Penerimaan Kas -->
									<li class="nav-item">
										<a href="<?= site_url('kas-masuk') ?> " class="nav-link <?= $page == 'kas-masuk' ? 'active' : '' ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Penerimaan Kas</p>
										</a>
									</li>

									<!-- Pengeluaran Kas -->
									<li class="nav-item">
										<a href="<?= site_url('kas-keluar') ?> " class="nav-link <?= $page == 'kas-keluar' ? 'active' : '' ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Pengeluaran Kas</p>
										</a>
									</li>

								<?php endif; ?>
							</ul>
						</li>

						<?php if ($_SESSION['level'] == 'dea' || $_SESSION['level'] == 'admin') : ?>

							<!-- Rekap Keuangan -->
							<li class="nav-item">
								<a href="<?= site_url('rekap-keuangan') ?> " class="nav-link <?= $page == 'rekap-keuangan' ? 'active' : '' ?>">
									<i class="fas fa-money-check"></i>
									<p>
										Rekap Keuangan
									</p>
								</a>
							</li>

						<?php endif; ?>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">

			<?php

			// dashboard
			if ($page == 'dashboard') {
				include 'pages/dashboard.php';
			}

			// data barang
			if ($page == 'barang') {
				include 'pages/master/barang.php';
			}

			// data supplier
			if ($page == 'supplier') {
				include 'pages/master/supplier.php';
			}

			// data pelanggan
			if ($page == 'pelanggan') {
				include 'pages/master/pelanggan.php';
			}

			// data user
			if ($page == 'user') {
				include 'pages/master/user.php';
			}

			// data penjualan
			if ($page == 'penjualan') {
				if ($aksi == 'detail')
					include 'pages/transaksi/penjualan_detail.php';
				else
					include 'pages/transaksi/penjualan.php';
			}

			// data pembelian
			if ($page == 'pembelian') {
				if ($aksi == 'detail')
					include 'pages/transaksi/pembelian_detail.php';
				else
					include 'pages/transaksi/pembelian.php';
			}

			// data penerimaan kas
			if ($page == 'kas-masuk') {
				include 'pages/transaksi/kas-masuk.php';
			}

			// data pengeluaran kas	
			if ($page == 'kas-keluar') {
				include 'pages/transaksi/kas-keluar.php';
			}

			// data kartu_persediaan
			if ($page == 'kartu-persediaan') {
				include 'pages/transaksi/kartu-persediaan.php';
			}

			// data rekap keuangan
			if ($page == 'rekap-keuangan') {
				include 'pages/rekap-keuangan.php';
			}

			// export data
			if ($page == 'export') {
				if ($aksi == 'penjualan-xls')
					include 'pages/export/penjualan-xls.php';
				elseif ($aksi == 'pembelian-xls')
					include 'pages/export/pembelian-xls.php';
			}


			?>


		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<strong>Copyright &copy; PT PRIMA KIMIA SURYATAMA | APLIKASI PENJUALAN DAN PEMBELIAN ALKES 2022</strong>
		</footer>


	</div>
	<!-- ./wrapper -->

	<!-- jQuery -->
	<script src="plugins/jquery/jquery.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		$.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- ChartJS -->
	<script src="plugins/chart.js/Chart.min.js"></script>
	<!-- Sparkline -->
	<script src="plugins/sparklines/sparkline.js"></script>
	<!-- JQVMap -->
	<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
	<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
	<!-- jQuery Knob Chart -->
	<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
	<!-- daterangepicker -->
	<script src="plugins/moment/moment.min.js"></script>
	<script src="plugins/daterangepicker/daterangepicker.js"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
	<!-- Summernote -->
	<script src="plugins/summernote/summernote-bs4.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.js"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="dist/js/pages/dashboard.js"></script>
	<!-- DataTables  & Plugins -->
	<script src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="plugins/jszip/jszip.min.js"></script>
	<script src="plugins/pdfmake/pdfmake.min.js"></script>
	<script src="plugins/pdfmake/vfs_fonts.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<!-- select2 -->
	<script src="plugins/select2/js/select2.full.min.js"></script>
	<script>
		// ready 
		$(document).ready(function() {
			$('.dataTable').DataTable();
			$('.select2').select2({
				width: '100%'
			});
		});
	</script>
</body>

</html>