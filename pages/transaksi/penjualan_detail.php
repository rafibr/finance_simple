<?php
include('../../helper.php');

// get kode_penjualan
$kode_penjualan = 'PJ-' . date('my') . '1';
if (isset($_GET['kode_penjualan'])) {
	$kode_penjualan = $_GET['kode_penjualan'];
}

$tanggal_penjualan = date('Y-m-d');
$kode_pelanggan = '';

?>

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Detail Penjualan</h1>
			</div>

		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table data penjualan	 -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Detail Penjualan</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i></button>
				</div>
			</div>

			<div class="card-body">
				<!-- button tambah data penjualan modal -->
				<div class="row text-right">
					<div class="col-md-12">
						<?php if (!($_SESSION['level'] == 'dea')) : ?>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
								<i class="fas fa-plus"></i> Tambah Data
							</button>
						<?php endif; ?>
					</div>
				</div>
				<br>
				
				<div class="row text-right">
					<div class="col-md-12">
						<div class="btn-group btn-group-sm">
							<!-- print nota pdf and xls  -->
							<button type="button" class="btn btn-warning" onclick="print_nota_pdf()">
								<i class="fas fa-file-pdf"></i> Nota
							</button>
							<?php
							if (!($_SESSION['level'] == 'gandi')) {
							?>
								<button type="button" class="btn btn-info" onclick="print_nota_digunggung_pdf()">
									<i class="fas fa-file-pdf"></i> Nota Digunggung
								</button>
							<?php
							}
							?>
							<button type="button" class="btn btn-success" onclick="print_nota_xls()">
								<i class="fas fa-file-excel"></i> Excel
							</button>
							<script>
								function print_nota_pdf() {
									url = '<?= app_url() . 'pages/export/penjualan-pdf.php?kode_penjualan=' . $kode_penjualan ?>';
									$.ajax({
										type: 'GET',
										url: url,
										success: function(data) {
											window.location.href = url;
										}
									});
								}

								function print_nota_digunggung_pdf() {
									url = '<?= app_url() . 'pages/export/penjualan-pdf-digunggung.php?kode_penjualan=' . $kode_penjualan ?>';
									$.ajax({
										type: 'GET',
										url: url,
										success: function(data) {
											window.location.href = url;
										}
									});
								}

								function print_nota_xls() {
									url = '<?= app_url() . 'pages/export/penjualan-xls.php?kode_penjualan=' . $kode_penjualan ?>';
									$.ajax({
										type: 'GET',
										url: url,
										success: function(data) {
											window.location.href = url;
										}
									});
								}
							</script>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<!-- // id
								// kode_penjualan
								// tanggal_penjualan
								// kode_pelanggan
								// kode_barang
								// harga_jual_penjualan
								// jumlah_penjualan
								// sub_total_penjualan -->
									<th>No</th>
									<th>Kode Penjualan</th>
									<th>Tanggal Penjualan</th>
									<th>Pelanggan</th>
									<th>Barang</th>
									<th>Harga Jual</th>
									<th>Jumlah</th>
									<th>Sub Total</th>
									<?php if (!($_SESSION['level'] == 'dea')) : ?>
										<th>Aksi</th>
									<?php endif; ?>
								</tr>
							</thead>
							<tbody>

								<?php
								$no = 1;
								// $results = ORM::for_table('person')
								// 	->table_alias('p1')
								// 	->select('p1.*')
								// 	->select('p2.name', 'parent_name')
								// 	->join('person', array('p1.parent', '=', 'p2.id'), 'p2')
								// 	->find_many();


								$data = DataPenjualanORM::table_alias('p1')
									->select('p1.*')
									->select('p1.id', 'id_penjualan')
									->select('p2.*')
									->select('p2.id', 'id_barang')
									->select('p3.*')
									->select('p3.id', 'id_pelanggan')
									->join('data_barang', array('p1.kode_barang', '=', 'p2.kode_barang'), 'p2')
									->join('data_pelanggan', array('p1.kode_pelanggan', '=', 'p3.kode_pelanggan'), 'p3')
									->where(array('kode_penjualan' => $kode_penjualan))
									->find_many();

								$total_jumlah = 0;
								$total_sub_total = 0;

								foreach ($data as $key => $value) {
									$tanggal_penjualan = $value->tanggal_penjualan;
									$kode_pelanggan = $value->kode_pelanggan;

								?>
									<tr>
										<td><?= $no++;  ?></td>
										<td><?= $value->kode_penjualan; ?></td>
										<td><?= $value->tanggal_penjualan; ?></td>
										<td><?= $value->nama_pelanggan; ?></td>
										<td><?= $value->nama_barang; ?></td>
										<td><?= rupiah($value->harga_jual_penjualan); ?></td>
										<td><?php echo ($value->jumlah_penjualan);
											$total_jumlah += $value->jumlah_penjualan; ?></td>
										<td><?= rupiah($value->sub_total_penjualan);
											$total_sub_total += $value->sub_total_penjualan; ?></td>
										<?php if (!($_SESSION['level'] == 'dea')) : ?>
											<td>
												<!-- open modal delete -->
												<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete<?= $value->id_penjualan; ?>">
													<i class="fa fa-trash"></i>
												</button>
											</td>
										<?php endif; ?>
									</tr>

									<!-- Modal Delete -->
									<div class="modal fade" id="modal-delete<?= $value->id_penjualan; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Delete Data Penjualan</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="<?= site_url('penjualan') . '&aksi=detail&kode_penjualan=' . $kode_penjualan; ?>" method="post">
													<div class="modal-body">
														<input type="hidden" name="id" value="<?= $value->id_penjualan; ?>">
														<p>Apakah anda yakin ingin menghapus data ini?</p>
														<div class="row">
															<div class="col-md-6">
																<label for="nama_barang">Nama Barang</label>
																<input type="text" name="nama_barang" class="form-control" value="<?= $value->nama_barang; ?>" readonly>
															</div>
															<div class="col-md-6">
																<label for="nama_pelanggan">Nama Pelanggan</label>
																<input type="text" name="nama_pelanggan" class="form-control" value="<?= $value->nama_pelanggan; ?>" readonly>
															</div>
														</div>
													</div>
													<div class="modal-footer justify-content-between">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-danger" name="delete" value="delete">Delete</button>
													</div>
												</form>
											</div>
										</div>
									</div>

								<?php
								}
								?>
								<tr>
									<td colspan="6" align="right">Total</td>
									<td><?= ($total_jumlah); ?></td>
									<td><?= rupiah($total_sub_total); ?></td>
								</tr>
								<!-- pajak 10% -->
								<tr>
									<td colspan="7" align="right">Pajak 10%</td>
									<td><?= rupiah(($total_sub_total * 10) / 100); ?></td>
								</tr>
								<!-- total + pajak -->
								<tr>
									<td colspan="7" align="right">Total + Pajak</td>
									<td><?= rupiah(($total_sub_total * 110) / 100); ?></td>
								</tr>
							</tbody>
						</table>

						<!-- Modal Tambah -->
						<div class="modal fade" id="modal-tambah">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Tambah Data Penjualan</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<!-- // id kode_penjualan nama_penjualan stok kode_supplier harga_beli harga_jual -->
									<form action="" method="post">
										<div class="modal-body">
											<div class="form-group">
												<label for="kode_penjualan">Kode Penjualan</label>
												<input type="text" class="form-control" id="kode_penjualan" name="kode_penjualan" readonly value="<?= $kode_penjualan; ?>" required>
											</div>

											<!-- tanggal -->
											<div class="form-group">
												<label for="tanggal">Tanggal</label>
												<input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $tanggal_penjualan; ?>" required disabled>
											</div>

											<div class="form-group">
												<label for="kode_pelanggan">Nama Pelanggan</label>
												<select name="kode_pelanggan select2" id="kode_pelanggan" class="form-control" required disabled>
													<option value="">Pilih Nama Pelanggan</option>
													<?php
													$listPelanggan = DataPelangganORM::find_many();
													foreach ($listPelanggan as $value) {
													?>
														<option value="<?= $value->kode_pelanggan; ?>" <?= $value->kode_pelanggan == $kode_pelanggan ? 'selected' : ''; ?>><?= $value->nama_pelanggan; ?></option>
													<?php
													}
													?>
												</select>
											</div>

											<!-- Data Barang -->
											<div class="form-group">
												<label for="kode_barang">Nama Barang</label>
												<select class="form-control select2" id="kode_barang" name="kode_barang" onchange="get_harga_barang()" required>
													<option value="">Pilih Barang</option>
													<?php
													$barang = DataBarangORM::find_many();
													foreach ($barang as $value) {
													?>
														<option value="<?= $value->kode_barang; ?>|<?= $value->harga_jual; ?>"><?= $value->nama_barang; ?></option>
													<?php
													}
													?>
												</select>
											</div>

											<div class="form-group">
												<label for="harga_jual">Harga Jual</label>
												<input type="number" class="form-control" id="harga_jual" name="harga_jual" onchange="get_harga_total()" onkeyup="get_harga_total()" required>
											</div>

											<!-- Jumlah -->
											<div class="form-group">
												<label for="jumlah">Jumlah</label>
												<input type="number" class="form-control" id="jumlah" name="jumlah" onchange="get_harga_barang()" onkeyup="get_harga_barang()" required>
											</div>

											<!-- Total -->
											<div class="form-group">
												<label for="total">Total</label>
												<input type="number" class="form-control" id="total" name="total" readonly>
											</div>

										</div>
										<div class="modal-footer justify-content-between">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary" name="tambah" value="tambah">Tambah</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php

// id
// kode_penjualan
// tanggal_penjualan
// kode_pelanggan
// kode_barang
// harga_jual_penjualan
// jumlah_penjualan
// sub_total_penjualan	


if (isset($_POST['tambah'])) {
	$kode_barang = explode("|", $_POST['kode_barang']);

	// check if stok is enough
	$barang = DataBarangORM::where('kode_barang', $kode_barang[0])->find_one();
	if ($barang->stok < $_POST['jumlah']) {
		echo "<script>alert('Stok tidak mencukupi');</script>";
		return;
	}

	$penjualan = DataPenjualanORM::create();
	$penjualan->kode_penjualan = $_POST['kode_penjualan'];
	$penjualan->tanggal_penjualan = $tanggal_penjualan;
	$penjualan->kode_pelanggan = $kode_pelanggan;

	// split kode barang dan harga jual
	$penjualan->kode_barang = $kode_barang[0];

	$penjualan->harga_jual_penjualan = $_POST['harga_jual'];
	$penjualan->jumlah_penjualan = $_POST['jumlah'];
	$penjualan->sub_total_penjualan = $_POST['total'];
	$penjualan->save();

	// update saldo
	$saldo = SaldoORM::find_one();
	$saldo->saldo = $saldo->saldo + $_POST['total'];
	$saldo->save();

	// update stok barang dan harga beli
	$barang = DataBarangORM::where('kode_barang', $kode_barang[0])->find_one();
	$barang->stok = $barang->stok - $penjualan->jumlah_penjualan;
	$barang->harga_jual = $penjualan->harga_jual_penjualan;
	$barang->save();


	// get nama barang
	$nama_barang = DataBarangORM::where('kode_barang', $kode_barang[0])->find_one();
	$nama_barang = $nama_barang->nama_barang;

	// get nama pelanggan
	$nama_pelanggan = DataPelangganORM::where('kode_pelanggan', $_POST['kode_pelanggan'])->find_one();
	$nama_pelanggan = $nama_pelanggan->nama_pelanggan;


	// delete from DataPenerimaanKasORM
	$penerimaan_kas = DataPenerimaanKasORM::where('kode_penjualan', $_POST['kode_penjualan'])->find_one();
	$penerimaan_kas->delete();

	// get data penjualan
	$penjualan = DataPenjualanORM::raw_query("SELECT * FROM penjualan join data_pelanggan on penjualan.kode_pelanggan = data_pelanggan.kode_pelanggan join data_barang on penjualan.kode_barang = data_barang.kode_barang WHERE kode_penjualan = '" . $_POST['kode_penjualan'] . "'")->find_many();
	$total = 0;
	$nama_pelanggan = "asds";
	foreach ($penjualan as $penjualan) {
		$total += $penjualan->sub_total_penjualan;
		$nama_pelanggan = $penjualan->nama_pelanggan;
	}

	// get last id penerimaan 
	$penerimaan_kas = DataPenerimaanKasORM::order_by_desc('id')->find_many();
	$last_id = 0;
	// check if there is any penerimaan kas
	if (count($penerimaan_kas) > 0) {
		$last_id = $penerimaan_kas[0]->id;
	}
	$kode_penerimaan = "PNK-" . date("my") . ($last_id + 1);
	$penerimaan_kas = DataPenerimaanKasORM::create();
	$penerimaan_kas->kode_penerimaan = $kode_penerimaan;
	$penerimaan_kas->tanggal_penerimaan = $tanggal_penjualan;
	$penerimaan_kas->keterangan_penerimaan = "Penjualan barang kepada " . $nama_pelanggan;
	$penerimaan_kas->total_penerimaan = $total;
	$penerimaan_kas->kode_penjualan = $_POST['kode_penjualan'];
	$penerimaan_kas->save();



	// header('Location: index.php?page=penjualan');
	echo "<script>window.location.href='index.php?page=penjualan&aksi=detail&kode_penjualan=$_POST[kode_penjualan]';</script>";
}

if (isset($_POST['delete'])) {

	$kode_deleted_barang = '';
	$jumlah_deleted_barang = '';


	$penjualan = DataPenjualanORM::find_one($_POST['id']);
	$kode_deleted_barang = $penjualan->kode_barang;
	$jumlah_deleted_barang = $penjualan->jumlah_penjualan;

	$barang = DataBarangORM::where('kode_barang', $kode_deleted_barang)->find_one();
	$barang->stok = $barang->stok + $jumlah_deleted_barang;
	$barang->save();

	// delete from DataPenerimaanKasORM
	$penerimaan_kas = DataPenerimaanKasORM::where('kode_penjualan', $kode_penjualan)->find_one();
	$penerimaan_kas->delete();

	// update saldo
	$saldo = SaldoORM::find_one();
	$saldo->saldo = $saldo->saldo - $penjualan->sub_total_penjualan;
	$saldo->save();
	
	$penjualan->delete();


	// get data penjualan
	$penjualan_temp = DataPenjualanORM::raw_query("SELECT * FROM penjualan join data_pelanggan on penjualan.kode_pelanggan = data_pelanggan.kode_pelanggan join data_barang on penjualan.kode_barang = data_barang.kode_barang WHERE penjualan.kode_penjualan = '" . $kode_penjualan . "'")->find_many();
	$total = 0;
	$nama_pelanggan = "asds";
	foreach ($penjualan_temp as $penjualan) {
		$total += $penjualan->sub_total_penjualan;
		$nama_pelanggan = $penjualan->nama_pelanggan;
	}

	// get last id penerimaan 
	$penerimaan_kas = DataPenerimaanKasORM::order_by_desc('id')->find_many();
	$last_id = 0;
	// check if there is any penerimaan kas
	if (count($penerimaan_kas) > 0) {
		$last_id = $penerimaan_kas[0]->id;
	}
	$kode_penerimaan = "PNK-" . date("my") . ($last_id + 1);
	$penerimaan_kas = DataPenerimaanKasORM::create();
	$penerimaan_kas->kode_penerimaan = $kode_penerimaan;
	$penerimaan_kas->tanggal_penerimaan = $tanggal_penjualan;
	$penerimaan_kas->keterangan_penerimaan = "Penjualan barang kepada " . $nama_pelanggan;
	$penerimaan_kas->total_penerimaan = $total;
	$penerimaan_kas->kode_penjualan = $kode_penjualan;
	$penerimaan_kas->save();

	

	// header('Location: index.php?page=penjualan');
	// refresh
	$url = "index.php?page=penjualan&aksi=detail&kode_penjualan=" . $kode_penjualan;
	echo "<script>window.location.href='$url';</script>";
}

?>

<script>
	function get_harga_barang() {
		var kode_barang = $('#kode_barang').val();
		var arr = kode_barang.split('|');
		var harga_jual = arr[1];
		$('#harga_jual').val(harga_jual);

		var jumlah = $('#jumlah').val();
		var total = harga_jual * jumlah;
		$('#total').val(total);
	}

	function get_harga_total() {
		var harga_jual = $('#harga_jual').val();
		var jumlah = $('#jumlah').val();
		var total = harga_jual * jumlah;
		$('#total').val(total);
	}
</script>