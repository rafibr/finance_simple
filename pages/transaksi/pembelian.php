<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Data Pembelian</h1>
			</div>

		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table data pembelian	 -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Data Pembelian</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i></button>
				</div>
			</div>

			<div class="card-body">
				<div class="row">
					<!-- search start date  -->
					<div class="col-md-5">
						<div class="form-group">
							<label>Start Date</label>
							<input type="date" class="form-control" id="start_date" name="start_date" placeholder="Start Date">
						</div>
					</div>

					<!-- search end date  -->
					<div class="col-md-5">
						<div class="form-group">
							<label>End Date</label>
							<input type="date" class="form-control" id="end_date" name="end_date" placeholder="End Date">
						</div>
					</div>

					<!-- search button  -->
					<div class="col-md-2">
						<div class="form-group">
							<label>Cari</label>
							<button type="button" class="btn btn-success btn-block" onclick="search()">
								<!-- icon export excel  -->
								<i class="fas fa-search"></i>
							</button>
						</div>
					</div>
					<script>
						function search() {
							var start_date = $('#start_date').val();
							var end_date = $('#end_date').val();

							// if start_date > end_date	then swap
							if (start_date > end_date) {
								var temp = start_date;
								start_date = end_date;
								end_date = temp;
							}

							url = '<?= app_url() . 'pages/export/pembelian-range.php?start_date=' ?>' + start_date + '&end_date=' + end_date;
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
				<br>
				<!-- button tambah data pembelian modal -->
				<div class="row text-right">
					<div class="col-md-12">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
							<i class="fas fa-plus"></i> Tambah Data
						</button>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered table-striped dataTable">
							<thead>
								<tr>
									<!-- // id
								// kode_pembelian
								// tanggal_pembelian
								// kode_pelanggan
								// kode_barang
								// harga_beli_pembelian
								// jumlah_pembelian
								// sub_total_pembelian -->
									<th>No</th>
									<th>Kode Pembelian</th>
									<th>Nomor Surat</th>
									<th>Tanggal Pembelian</th>
									<th>Supplier</th>
									<th>Jumlah</th>
									<th>Sub Total</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$no = 1;

								$query = "SELECT *,
								SUM(jumlah_pembelian) AS total_jumlah,
								SUM(sub_total_pembelian) AS total_sub_total,
								p1.id AS id_pembelian,
								p2.id AS id_barang,
								p3.id AS id_supplier
							FROM pembelian p1
								JOIN data_barang p2 ON p1.kode_barang = p2.kode_barang
								JOIN data_supplier p3 ON p1.kode_supplier = p3.kode_supplier
							GROUP BY p1.kode_pembelian";

								$data = DataPembelianORM::raw_query($query)->find_many();

								foreach ($data as $key => $value) {
								?>
									<tr>
										<td><?= $no++; ?></td>
										<td><?= $value->kode_pembelian; ?></td>
										<td><?= $value->nomor_surat; ?></td>
										<td><?= $value->tanggal_pembelian; ?></td>
										<td><?= $value->nama_supplier; ?></td>
										<td><?= ($value->total_jumlah); ?></td>
										<td><?= rupiah($value->total_sub_total); ?></td>
										<td>
											<!-- button group  -->
											<div class="btn-group btn-group-sm">
												<!-- Detail -->
												<a href="<?= site_url('pembelian') . '&aksi=detail&kode_pembelian=' . $value->kode_pembelian; ?>" class="btn btn-info">
													<i class="fas fa-info-circle"></i>
												</a>

											</div>

										</td>
									</tr>

									<!-- Modal Delete -->
									<div class="modal fade" id="modal-delete<?= $value->kode_pembelian; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Delete Data Pembelian</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="" method="post">
													<div class="modal-body">
														<input type="hidden" name="id" value="<?= $value->kode_pembelian; ?>">
														<p>Apakah anda yakin ingin menghapus data ini?</p>
														<div class="row">
															<div class="col-md-6">
																<label for="kode_pembelian">Kode Pembelian</label>
																<input type="text" class="form-control" id="kode_pembelian" name="kode_pembelian" value="<?= $value->kode_pembelian; ?>" readonly>
															</div>
															<div class="col-md-6">
																<label for="nama_pembelian">Nama Pembelian</label>
																<input type="text" class="form-control" id="nama_pembelian" name="nama_pembelian" value="<?= $value->nama_pembelian; ?>" readonly>
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
											<?php
											$last_id = DataPembelianORM::order_by_desc('id')
												->limit(1)
												->find_one();

											// check if last_id is null
											if ($last_id == null) {
												$last_id = 1;
											} else {
												$last_id = $last_id->id + 1;
											}

											// kode pembelian  = BR-mmyy.idpembelian
											$kode_pembelian = "PL-" . date('my') . $last_id;

											?>
											<div class="form-group">
												<label for="kode_pembelian">Kode Pembelian</label>
												<input type="text" class="form-control" id="kode_pembelian" name="kode_pembelian" readonly value="<?= $kode_pembelian; ?>" required>
											</div>

											<!-- Nomor surat -->
											<div class="form-group">
												<label for="nomor_surat">Nomor Surat</label>
												<input type="text" class="form-control" id="nomor_surat" name="nomor_surat">
											</div>

											<!-- tanggal -->
											<div class="form-group">
												<label for="tanggal">Tanggal</label>
												<input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d'); ?>" required>
											</div>

											<div class="form-group">
												<label for="kode_supplier">Nama Supplier</label>
												<select class="form-control" id="kode_supplier" name="kode_supplier" required>
													<option value="">Pilih Supplier</option>
													<?php
													$supplier = DataSupplierORM::find_many();
													foreach ($supplier as $value) {
													?>
														<option value="<?= $value->kode_supplier; ?>"><?= $value->nama_supplier; ?></option>
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
												<label for="harga_beli">Harga Beli</label>
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
// kode_pelanggan
// kode_barang
// harga_beli_pembelian
// jumlah_pembelian
// sub_total_pembelian	


if (isset($_POST['tambah'])) {

	$saldo = SaldoORM::find_one();
	if ($saldo->saldo < $_POST['total']) {
		echo "<script>
				alert('Saldo tidak cukup');
				window.location.href='index.php?page=pembelian';
			</script>";
		return;
	}

	$pembelian = DataPembelianORM::create();
	$pembelian->kode_pembelian = $_POST['kode_pembelian'];
	$pembelian->nomor_surat = $_POST['nomor_surat'];
	$pembelian->tanggal_pembelian = $_POST['tanggal'];
	$pembelian->kode_supplier = $_POST['kode_supplier'];

	// split kode barang dan harga jual
	$kode_barang = explode("|", $_POST['kode_barang']);
	$pembelian->kode_barang = $kode_barang[0];

	$pembelian->harga_beli_pembelian = $_POST['harga_beli'];
	$pembelian->jumlah_pembelian = $_POST['jumlah'];
	$pembelian->sub_total_pembelian = $_POST['total'];
	$pembelian->save();

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
	$pengeluaran_kas->tanggal_pengeluaran = date("Y-m-d");
	$pengeluaran_kas->keterangan_pengeluaran = "Pembelian dari " . $nama_supplier . ".";
	$pengeluaran_kas->total_pengeluaran = $_POST['total'];
	$pengeluaran_kas->kode_pembelian = $pembelian->kode_pembelian;
	$pengeluaran_kas->save();

	$saldo = SaldoORM::find_one();
	$saldo->saldo = $saldo->saldo - $_POST['total'];
	$saldo->save();

	// header('Location: index.php?page=pembelian');
	echo "<script>window.location.href='index.php?page=pembelian&aksi=detail&kode_pembelian=$_POST[kode_pembelian]';</script>";
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