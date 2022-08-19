<?php
$biaya_gudang = 0;
if (isset($_GET['biaya_gudang'])) {
	$biaya_gudang = $_GET['biaya_gudang'];
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Dashboard</h1>
			</div><!-- /.col -->

		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-success">
					<div class="inner">
						<?php
						// penjualan this year
						$sumPenjualan = DataPenjualanORM::raw_query("SELECT SUM(sub_total_penjualan) AS total, COUNT(id) as banyak_penjualan FROM penjualan WHERE YEAR(tanggal_penjualan) = YEAR(NOW())")->find_one();
						?>
						<h4><?= rupiah($sumPenjualan->total) ?></h4>

						<p>Penjualan tahun ini</p>
					</div>
					<div class="icon">
						<i class="ion ion-pie-graph"></i>
					</div>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-danger">
					<div class="inner">

						<?php
						// pembelian this year
						$sumPembelian = DataPembelianORM::raw_query("SELECT SUM(sub_total_pembelian) AS total, COUNT(id) as banyak_pembelian FROM pembelian WHERE YEAR(tanggal_pembelian) = YEAR(NOW())")->find_one();
						?>
						<h4><?= rupiah($sumPembelian->total) ?></h4>

						<p>Pembelian tahun ini</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-warning">
					<div class="inner">

						<?php
						// stok barang
						$stokBarang = DataBarangORM::raw_query("SELECT SUM(stok) AS total_stok FROM data_barang")->find_one();
						?>
						<h4><?= $stokBarang->total_stok ?></h4>

						<p>Jumlah Barang</p>
					</div>
					<div class="icon">
						<i class="ion ion-bag"></i>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-info">
					<div class="inner">

						<?php
						// stok barang
						$saldo = SaldoORM::find_one();
						?>
						<h4><?= rupiah($saldo->saldo) ?></h4>

						<p>Sisa Saldo</p>
					</div>
					<div class="icon">
						<i class="ion ion-cash"></i>
					</div>
				</div>
			</div>
		</div>
		<!-- /.row -->

		<?php if ($_SESSION['level'] == 'gandi' || $_SESSION['level'] == 'admin') : ?>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">EOQ</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">

									<form action="<?= site_url('dashboard') ?>" method="get">
										<div class="row">
											<div class="col-md-6">
												<!-- biaya gudang -->
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>Biaya Gudang</label>
															<input type="number" class="form-control" id="biaya_gudang" name="biaya_gudang" placeholder="Biaya Gudang" value="<?= $biaya_gudang ?>">
														</div>
													</div>
												</div>

											</div>
										</div>

										<!-- Hitung -->
										<div class="row">
											<div class="col-md-12 text-right">
												<button type="submit" class="btn btn-primary" id="hitung">Hitung</button>
											</div>
										</div>
									</form>
								</div>
							</div>

							<!-- metode EOQ = root((2 * (jumlah_barang_dibeli) * (rata_rata_harga_barang)) / (biaya_gudang)) -->
							<!-- hasil -->
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
										<table class="table table-bordered table-striped" id="table-hasil">
											<thead>
												<tr>
													<th>Nama Barang</th>
													<th>Barang dibeli</th>
													<th>Rata-rata harga barang</th>
													<th>Rumus EOQ</th>
													<th>Unit EOQ</th>
												</tr>
											</thead>
											<tbody>
												<!-- list barang -->
												<?php
												// hanya pada tahun ini
												$dataTable = DataBarangORM::raw_query("SELECT *, SUM(jumlah_pembelian) total_beli, SUM(harga_beli_pembelian) total_harga_beli, COUNT(pembelian.id) as banyak_beli FROM data_barang JOIN pembelian ON data_barang.kode_barang = pembelian.kode_barang WHERE YEAR(pembelian.tanggal_pembelian) = YEAR(NOW()) GROUP BY data_barang.kode_barang")->find_many();



												foreach ($dataTable as $d) {
												?>
													<tr>
														<td><?= $d->nama_barang ?></td>
														<td><?= $d->total_beli ?></td>
														<td><?= rupiah(($d->total_harga_beli) / ($d->banyak_beli)) ?></td>
														<td>
															<i class="fas fa-square-root-alt"></i>
															(2 x <?= $d->total_beli ?> x <?= (($d->total_harga_beli) / ($d->banyak_beli)) ?>) / <?= $biaya_gudang ?>
														</td>

														<!-- EOQ METHOD = root((2 * (jumlah_barang_dibeli) * (rata_rata_harga_barang)) / (biaya_gudang)) -->
														<td><b>
																<?php
																$unitEoq = (sqrt((2 * ($d->total_beli) * (($d->total_harga_beli) / ($d->total_beli))) / ($biaya_gudang)));

																// buat angka bulat
																$unitEoqBulat = round($unitEoq);
																?>

																<?= $unitEoq ?>
																~
																<?= $unitEoqBulat ?>
																Unit</b></td>
													</tr>
												<?php
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php endif; ?>

	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->