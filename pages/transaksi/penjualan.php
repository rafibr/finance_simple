<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Data Penjualan</h1>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table data penjualan	 -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Data Penjualan</h3>
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

							url = '<?= app_url() . 'pages/export/penjualan-range.php?start_date=' ?>' + start_date + '&end_date=' + end_date;
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
				<!-- button tambah data penjualan modal -->
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
									<th>Jumlah</th>
									<th>Sub Total</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$no = 1;

								$data = DataPenjualanORM::raw_query("SELECT *, SUM(jumlah_penjualan) AS total_jumlah, SUM(sub_total_penjualan) AS total_sub_total, p1.id AS id_penjualan, p2.id AS id_barang, p3.id AS id_pelanggan FROM penjualan p1 JOIN data_barang p2 ON p1.kode_barang = p2.kode_barang JOIN data_pelanggan p3 ON p1.kode_pelanggan = p3.kode_pelanggan GROUP BY p1.kode_penjualan")->find_many();

								foreach ($data as $key => $value) {
								?>
									<tr>
										<td><?= $no++; ?></td>
										<td><?= $value->kode_penjualan; ?></td>
										<td><?= $value->tanggal_penjualan; ?></td>
										<td><?= $value->nama_pelanggan; ?></td>
										<td><?= ($value->total_jumlah); ?></td>
										<td><?= rupiah($value->total_sub_total); ?></td>
										<td>
											<!-- button group  -->
											<div class="btn-group btn-group-sm">
												<!-- Detail -->
												<a href="<?= site_url('penjualan') . '&aksi=detail&kode_penjualan=' . $value->kode_penjualan; ?>" class="btn btn-info">
													<i class="fas fa-info-circle"></i>
												</a>
												<!-- Modal Delete
												<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete</?= $value->kode_penjualan; ?>">
													<i class="fas fa-trash"></i>
												</button> -->
											</div>

										</td>
									</tr>

									<!-- Modal Delete -->
									<div class="modal fade" id="modal-delete<?= $value->kode_penjualan; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Delete Data Penjualan</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="<?= site_url('penjualan') ?>" method="post">
													<div class="modal-body">
														<input type="hidden" name="id" value="<?= $value->kode_penjualan; ?>">
														<p>Apakah anda yakin ingin menghapus data ini?</p>
														<div class="row">
															<div class="col-md-6">
																<label for="kode_penjualan">Kode Penjualan</label>
																<input type="text" class="form-control" id="kode_penjualan" name="kode_penjualan" value="<?= $value->kode_penjualan; ?>" readonly>
															</div>
															<div class="col-md-6">
																<label for="nama_penjualan">Nama Penjualan</label>
																<input type="text" class="form-control" id="nama_penjualan" name="nama_penjualan" value="<?= $value->nama_pelanggan; ?>" readonly>
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
										<h4 class="modal-title">Tambah Data Penjualan</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<!-- // id kode_penjualan nama_penjualan stok kode_supplier harga_beli harga_jual -->
									<form action="" method="post">
										<div class="modal-body">
											<?php
											$last_id = DataPenjualanORM::order_by_desc('id')
												->limit(1)
												->find_one();

											// check if last_id is null
											if ($last_id == null) {
												$last_id = 1;
											} else {
												$last_id = $last_id->id + 1;
											}

											// kode penjualan  = BR-mmyy.idpenjualan
											$kode_penjualan = "PJ-" . date('my') . $last_id;

											?>
											<div class="form-group">
												<label for="kode_penjualan">Kode Penjualan</label>
												<input type="text" class="form-control" id="kode_penjualan" name="kode_penjualan" readonly value="<?= $kode_penjualan; ?>" required>
											</div>

											<!-- tanggal -->
											<div class="form-group">
												<label for="tanggal">Tanggal</label>
												<input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d'); ?>" required>
											</div>

											<div class="form-group">
												<label for="kode_pelanggan">Nama Pelanggan</label>
												<select class="form-control select2" id="kode_pelanggan" name="kode_pelanggan" required>
													<option value="">Pilih Pelanggan</option>
													<?php
													$pelanggan = DataPelangganORM::find_many();
													foreach ($pelanggan as $value) {
													?>
														<option value="<?= $value->kode_pelanggan; ?>"><?= $value->nama_pelanggan; ?></option>
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
	$penjualan->tanggal_penjualan = $_POST['tanggal'];
	$penjualan->kode_pelanggan = $_POST['kode_pelanggan'];

	// split kode barang dan harga jual
	$kode_barang = explode("|", $_POST['kode_barang']);
	$penjualan->kode_barang = $kode_barang[0];

	$penjualan->harga_jual_penjualan = $_POST['harga_jual'];
	$penjualan->jumlah_penjualan = $_POST['jumlah'];
	$penjualan->sub_total_penjualan = $_POST['total'];
	$penjualan->save();


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
	$penerimaan_kas->tanggal_penerimaan = $_POST['tanggal'];
	$penerimaan_kas->keterangan_penerimaan = "Penjualan barang kepada " . $nama_pelanggan;
	$penerimaan_kas->total_penerimaan = $_POST['total'];
	$penerimaan_kas->kode_penjualan = $_POST['kode_penjualan'];
	$penerimaan_kas->save();

	
	$saldo = SaldoORM::find_one();
	$saldo->saldo = $saldo->saldo + $_POST['total'];
	$saldo->save();


	// header('Location: index.php?page=penjualan');
	echo "<script>window.location.href='index.php?page=penjualan&aksi=detail&kode_penjualan=$_POST[kode_penjualan]';</script>";
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