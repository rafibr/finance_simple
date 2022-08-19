<?php
include('../../helper.php');

// get kode_pembelian
$kode_pembelian = 'PL-' . date('my') . '1';
if (isset($_GET['kode_pembelian'])) {
	$kode_pembelian = $_GET['kode_pembelian'];
}

$tanggal_pembelian = date('Y-m-d');
$kode_supplier = '';

?>

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Detail Pembelian</h1>
			</div>

		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table data pembelian	 -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Detail Pembelian</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i></button>
				</div>
			</div>

			<div class="card-body">
				<!-- button tambah data pembelian modal -->
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
									url = '<?= app_url() . 'pages/export/pembelian-pdf.php?kode_pembelian=' . $kode_pembelian ?>';
									$.ajax({
										type: 'GET',
										url: url,
										success: function(data) {
											window.location.href = url;
										}
									});
								}

								function print_nota_digunggung_pdf() {
									url = '<?= app_url() . 'pages/export/pembelian-pdf-digunggung.php?kode_pembelian=' . $kode_pembelian ?>';
									$.ajax({
										type: 'GET',
										url: url,
										success: function(data) {
											window.location.href = url;
										}
									});
								}

								function print_nota_xls() {
									url = '<?= app_url() . 'pages/export/pembelian-xls.php?kode_pembelian=' . $kode_pembelian ?>';
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
									<th>No</th>
									<th>Kode Pembelian</th>
									<th>Tanggal Pembelian</th>
									<th>Supplier</th>
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


								$data = DataPembelianORM::table_alias('p1')
									->select('p1.*')
									->select('p1.id', 'id_pembelian')
									->select('p2.*')
									->select('p2.id', 'id_barang')
									->select('p3.*')
									->select('p3.id', 'id_pelanggan')
									->join('data_barang', array('p1.kode_barang', '=', 'p2.kode_barang'), 'p2')
									->join('data_supplier', array('p1.kode_supplier', '=', 'p3.kode_supplier'), 'p3')
									->where(array('kode_pembelian' => $kode_pembelian))
									->find_many();

								$total_jumlah = 0;
								$total_sub_total = 0;

								foreach ($data as $key => $value) {
									$tanggal_pembelian = $value->tanggal_pembelian;
									$kode_supplier = $value->kode_supplier;

								?>
									<tr>
										<td><?= $no++;  ?></td>
										<td><?= $value->kode_pembelian; ?></td>
										<td><?= $value->tanggal_pembelian; ?></td>
										<td><?= $value->nama_supplier; ?></td>
										<td><?= $value->nama_barang; ?></td>
										<td><?= rupiah($value->harga_beli_pembelian); ?></td>
										<td><?php echo ($value->jumlah_pembelian);
											$total_jumlah += $value->jumlah_pembelian; ?></td>
										<td><?= rupiah($value->sub_total_pembelian);
											$total_sub_total += $value->sub_total_pembelian; ?></td>
										<?php if (!($_SESSION['level'] == 'dea')) : ?>
											<td>
												<!-- open modal delete -->
												<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete<?= $value->id_pembelian; ?>">
													<i class="fa fa-trash"></i>
												</button>
											</td>
										<?php endif; ?>
									</tr>


									<!-- Modal Delete -->
									<div class="modal fade" id="modal-delete<?= $value->id_pembelian; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Delete Data Penjualan</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="<?= site_url('pembelian') . '&aksi=detail&kode_pembelian=' . $kode_pembelian; ?>" method="post">
													<div class="modal-body">
														<input type="hidden" name="id" value="<?= $value->id_pembelian; ?>">
														<p>Apakah anda yakin ingin menghapus data ini?</p>
														<div class="row">
															<div class="col-md-6">
																<label for="nama_barang">Nama Barang</label>
																<input type="text" name="nama_barang" class="form-control" value="<?= $value->nama_barang; ?>" readonly>
															</div>
															<div class="col-md-6">
																<label for="nama_supplier">Nama Supplier</label>
																<input type="text" name="nama_supplier" class="form-control" value="<?= $value->nama_supplier; ?>" readonly>
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
										<h4 class="modal-title">Tambah Data Pembelian</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<!-- // id kode_pembelian nama_pembelian stok kode_supplier harga_beli harga_beli -->
									<form action="" method="post">
										<div class="modal-body">
											<div class="form-group">
												<label for="kode_pembelian">Kode Pembelian</label>
												<input type="text" class="form-control" id="kode_pembelian" name="kode_pembelian" readonly value="<?= $kode_pembelian; ?>" required>
											</div>

											<!-- tanggal -->
											<div class="form-group">
												<label for="tanggal">Tanggal</label>
												<input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $tanggal_pembelian; ?>" required disabled>
											</div>

											<div class="form-group">
												<label for="kode_supplier">Nama Supplier</label>
												<select name="kode_supplier select2" id="kode_supplier" class="form-control" required disabled>
													<option value="">Pilih Nama Pelanggan</option>
													<?php
													$listSupplier = DataSupplierORM::find_many();
													foreach ($listSupplier as $value) {
													?>
														<option value="<?= $value->kode_supplier; ?>" <?= $value->kode_supplier == $kode_supplier ? 'selected' : ''; ?>><?= $value->nama_supplier; ?></option>
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
														<option value="<?= $value->kode_barang; ?>|<?= $value->harga_beli; ?>"><?= $value->nama_barang; ?></option>
													<?php
													}
													?>
												</select>
											</div>

											<div class="form-group">
												<label for="harga_beli">Harga Jual</label>
												<input type="number" class="form-control" id="harga_beli" name="harga_beli" onchange="get_harga_total()" onkeyup="get_harga_total()" required>
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
// kode_pembelian
// tanggal_pembelian
// kode_supplier
// kode_barang
// harga_beli_pembelian
// jumlah_pembelian
// sub_total_pembelian	


if (isset($_POST['tambah'])) {

	$saldo = SaldoORM::find_one();
	if ($saldo->saldo < $_POST['total']) {
		echo "<script>
				alert('Saldo tidak cukup');
			</script>";
		return;
	}

	$pembelian = DataPembelianORM::create();
	$pembelian->kode_pembelian = $_POST['kode_pembelian'];
	$pembelian->tanggal_pembelian = $tanggal_pembelian;
	$pembelian->kode_supplier = $kode_supplier;

	// split kode barang dan harga jual
	$kode_barang = explode("|", $_POST['kode_barang']);
	$pembelian->kode_barang = $kode_barang[0];

	$pembelian->harga_beli_pembelian = $_POST['harga_beli'];
	$pembelian->jumlah_pembelian = $_POST['jumlah'];
	$pembelian->sub_total_pembelian = $_POST['total'];
	$pembelian->save();

	// update saldo
	$saldo->saldo = $saldo->saldo - $_POST['total'];
	$saldo->save();

	// update stok barang dan harga beli
	$barang = DataBarangORM::where('kode_barang', $kode_barang[0])->find_one();
	$barang->stok = $barang->stok + $pembelian->jumlah_pembelian;
	$barang->harga_beli = $pembelian->harga_beli_pembelian;
	$barang->save();

	// get nama barang
	$nama_barang = DataBarangORM::where('kode_barang', $kode_barang[0])->find_one();
	$nama_barang = $nama_barang->nama_barang;

	// get nama pelanggan
	$nama_supplier = DataSupplierORM::where('kode_supplier', $_POST['kode_supplier'])->find_one();
	$nama_supplier = $nama_supplier->nama_supplier;


	// delete from DataPengeluaranKasORM
	$pengeluaran_kas = DataPengeluaranKasORM::where('kode_pembelian', $_POST['kode_pembelian'])->find_one();
	$pengeluaran_kas->delete();

	// get data penjualan
	$pembelian = DataPembelianORM::raw_query("SELECT * FROM pembelian join data_barang on pembelian.kode_barang = data_barang.kode_barang join data_supplier on pembelian.kode_supplier = data_supplier.kode_supplier WHERE pembelian.kode_pembelian = '$kode_pembelian'")->find_many();
	$total = 0;
	$nama_supplier = "";
	foreach ($pembelian as $value) {
		$total += $value->sub_total_pembelian;
		$nama_supplier = $value->nama_supplier;
	}

	// get last id penerimaan 
	$pengeluaran_kas = DataPengeluaranKasORM::order_by_desc('id')->find_many();
	$last_id = 0;
	// check if there is any penerimaan kas
	if (count($pengeluaran_kas) > 0) {
		$last_id = $pengeluaran_kas[0]->id;
	}

	// id
	// kode_pengeluaran
	// tanggal_pengeluaran
	// keterangan_pengeluaran
	// total_pengeluaran
	// kode_pembelia
	$kode_pengeluaran = "PLK-" . date("my") . ($last_id + 1);
	$pengeluaran_kas = DataPengeluaranKasORM::create();
	$pengeluaran_kas->kode_pengeluaran = $kode_pengeluaran;
	$pengeluaran_kas->tanggal_pengeluaran = $tanggal_pembelian;
	$pengeluaran_kas->keterangan_pengeluaran = "Pembelian barang dari $nama_supplier";
	$pengeluaran_kas->total_pengeluaran = $total;
	$pengeluaran_kas->kode_pembelian = $kode_pembelian;
	$pengeluaran_kas->save();

	// header('Location: index.php?page=pembelian');
	echo "<script>window.location.href='index.php?page=pembelian&aksi=detail&kode_pembelian=$_POST[kode_pembelian]';</script>";
}

if (isset($_POST['delete'])) {

	$kode_deleted_barang = '';
	$jumlah_deleted_barang = '';


	$pembelian = DataPembelianORM::find_one($_POST['id']);
	$kode_deleted_barang = $pembelian->kode_barang;
	$jumlah_deleted_barang = $pembelian->jumlah_pembelian;

	$barang = DataBarangORM::where('kode_barang', $kode_deleted_barang)->find_one();
	$barang->stok = $barang->stok - $jumlah_deleted_barang;
	$barang->save();

	// delete from DataPenerimaanKasORM
	$pengeluaran_kas = DataPengeluaranKasORM::where('kode_pembelian', $kode_pembelian)->find_one();
	$pengeluaran_kas->delete();

	// update saldo
	$saldo = SaldoORM::find_one();
	$saldo->saldo = $saldo->saldo + $pembelian->sub_total_pembelian;
	$saldo->save();

	$pembelian->delete();

	// get data pembelian
	$pembelian_temp = DataPembelianORM::raw_query("SELECT * FROM pembelian join data_barang on pembelian.kode_barang = data_barang.kode_barang join data_supplier on pembelian.kode_supplier = data_supplier.kode_supplier WHERE pembelian.kode_pembelian = '$kode_pembelian'")->find_many();

	$total = 0;
	$nama_supplier = "asds";
	foreach ($pembelian_temp as $pembelian) {
		$total += $pembelian->sub_total_pembelian;
		$nama_supplier = $pembelian->nama_supplier;
	}


	// get last id penerimaan 
	$pengeluaran_kas = DataPengeluaranKasORM::order_by_desc('id')->find_many();
	$last_id = 0;
	// check if there is any pengelaran kas
	if (count($pengeluaran_kas) > 0) {
		$last_id = $pengeluaran_kas[0]->id;
	}

	// id
	// kode_pengeluaran
	// tanggal_pengeluaran
	// keterangan_pengeluaran
	// total_pengeluaran
	// kode_pembelian

	$kode_pengeluaran = "PLK-" . date("my") . ($last_id + 1);
	$pengeluaran_kas = DataPengeluaranKasORM::create();
	$pengeluaran_kas->kode_pengeluaran = $kode_pengeluaran;
	$pengeluaran_kas->tanggal_pengeluaran = $tanggal_pembelian;
	$pengeluaran_kas->keterangan_pengeluaran = "Pembelian dari " . $nama_supplier . ".";
	$pengeluaran_kas->total_pengeluaran = $total;
	$pengeluaran_kas->kode_pembelian = $kode_pembelian;

	$pengeluaran_kas->save();

	// header('Location: index.php?page=pembelian');
	// refresh
	$url = "index.php?page=pembelian&aksi=detail&kode_pembelian=" . $kode_pembelian;
	echo "<script>window.location.href='$url';</script>";
}

?>

<script>
	function get_harga_barang() {
		var kode_barang = $('#kode_barang').val();
		var arr = kode_barang.split('|');
		var harga_beli = arr[1];
		$('#harga_beli').val(harga_beli);

		var jumlah = $('#jumlah').val();
		var total = harga_beli * jumlah;
		$('#total').val(total);
	}

	function get_harga_total() {
		var harga_beli = $('#harga_beli').val();
		var jumlah = $('#jumlah').val();
		var total = harga_beli * jumlah;
		$('#total').val(total);
	}
</script>