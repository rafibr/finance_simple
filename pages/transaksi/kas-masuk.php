<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Data Kas Masuk</h1>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- saldo -->
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Saldo Kas</h3>
					</div>
					<div class="card-body">
						<form action="" method="POST">
							<?php
							$saldo = SaldoORM::find_one();
							$saldo = $saldo->saldo;
							?>
							<div class="form-group">
								<label for="saldo">Saldo</label>
								<input type="number" class="form-control" id="saldo" name="saldo" value="<?= $saldo; ?>">
							</div>
							<button type="submit" class="btn btn-primary" onclick="return confirm('Yakin ingin mengubah saldo?')" name="btn_saldo" value="btn_saldo">Ubah Saldo</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- table data penjualan -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Data Kas Masuk</h3>
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

							url = '<?= app_url() . 'pages/export/penerimaan-range.php?start_date=' ?>' + start_date + '&end_date=' + end_date;
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
				<?php
				$last_id = DataPenerimaanKasORM::order_by_desc('id')
					->find_one();

				// check if last_id is null
				if ($last_id == null) {
					$last_id = 1;
				} else {
					$last_id = $last_id->id + 1;
				}

				// kode penjualan  = BR-mmyy.idpenjualan
				$kode_penjualan = "PNK-" . date('my') . $last_id;

				?>
				<!-- Modal Tambah -->
				<div class="modal fade" id="modal-tambah">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Tambah Data Kas Masuk</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<div class="modal-body">
								<form action="" method="POST">
									<div class="form-group">
										<label>Kode Penerimaan</label>
										<input type="text" class="form-control" id="kode_penerimaan" name="kode_penerimaan" placeholder="Kode Penerimaan" value="<?= $kode_penjualan ?>" readonly>
									</div>
									<div class="form-group">
										<label>Tanggal Penerimaan</label>
										<input type="date" class="form-control" id="tanggal_penerimaan" name="tanggal_penerimaan" placeholder="Tanggal Penerimaan">
									</div>
									<div class="form-group">
										<label>Keterangan Penerimaan</label>
										<textarea class="form-control" id="keterangan_penerimaan" name="keterangan_penerimaan" placeholder="Keterangan Penerimaan" rows="5"></textarea>

									</div>
									<div class="form-group">
										<label>Total Penerimaan</label>
										<!-- prepend icon -->
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">Rp</span>
											</div>
											<input type="number" class="form-control" id="total_penerimaan" name="total_penerimaan" placeholder="Total Penerimaan">
										</div>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary" name="tambah" value="tambah">
											<i class="fas fa-save"></i> Simpan
										</button>
									</div>
								</form>
							</div>

						</div>
					</div>
				</div>


				<br>
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered table-striped dataTable">
							<thead>
								<tr>

									<th>No</th>
									<th>Kode Kas Masuk</th>
									<th>Invoice</th>
									<th>Tanggal</th>
									<th>Keterangan</th>
									<th>Sub Total</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$no = 1;

								$data = DataPenerimaanKasORM::raw_query("SELECT *, penerimaan.id as id_penerimaan FROM penerimaan left join penjualan on penerimaan.kode_penjualan = penjualan.kode_penjualan left join data_pelanggan on penjualan.kode_pelanggan = data_pelanggan.kode_pelanggan 
								group by penerimaan.kode_penerimaan order by penerimaan.tanggal_penerimaan desc")->find_many();

								foreach ($data as $key => $value) {
								?>
									<tr>
										<td><?= $no++; ?></td>
										<td><?= $value->kode_penerimaan; ?></td>
										<td><?= $value->kode_penjualan; ?></td>
										<td><?= $value->tanggal_penerimaan; ?></td>
										<td><?= $value->keterangan_penerimaan; ?></td>
										<td><?= rupiah($value->total_penerimaan); ?></td>
										<td>
											<!-- button group  -->
											<div class="btn-group btn-group-sm">

												<?php if ($value->kode_penjualan == null) : ?>
													<!-- edit -->
													<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $value->id_penerimaan; ?>">
														<i class="fas fa-edit"></i>
													</button>

													<!-- delete -->
													<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $value->id_penerimaan; ?>">
														<i class="fas fa-trash"></i>
													</button>
												<?php else : ?>
													<!-- Detail -->
													<a href="<?= site_url('penjualan') . '&aksi=detail&kode_penjualan=' . $value->kode_penjualan; ?>" class="btn btn-info">
														<i class="fas fa-info-circle"></i>
													</a>
												<?php endif; ?>
											</div>

										</td>
									</tr>

									<!-- Modal Delete -->
									<div class="modal fade" id="delete<?= $value->id_penerimaan; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<form action="" method="POST">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<input type="hidden" name="id" value="<?= $value->id_penerimaan; ?>">
														<p>Apakah anda yakin ingin menghapus data ini?</p>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
														<button type="submit" class="btn btn-danger" name="delete" value="delete">Hapus</button>
													</div>
												</div>
											</form>

										</div>
									</div>
									<!-- End Modal Delete -->

									<!-- Modal Edit -->
									<div class="modal fade" id="edit<?= $value->id_penerimaan; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<form action="" method="POST">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<input type="hidden" name="id" value="<?= $value->id_penerimaan; ?>">
														<div class="form-group">
															<label for="kode_penerimaan">Kode Penerimaan</label>
															<input type="text" class="form-control" id="kode_penerimaan" name="kode_penerimaan" value="<?= $value->kode_penerimaan; ?>" readonly>
														</div>
														<div class="form-group">
															<label for="tanggal_penerimaan">Tanggal Penerimaan</label>
															<input type="date" class="form-control" id="tanggal_penerimaan" name="tanggal_penerimaan" value="<?= $value->tanggal_penerimaan; ?>">
														</div>
														<div class="form-group">
															<label for="keterangan_penerimaan">Keterangan Penerimaan</label>
															<textarea class="form-control" id="keterangan_penerimaan" name="keterangan_penerimaan" rows="3"><?= $value->keterangan_penerimaan; ?></textarea>
														</div>
														<div class="form-group">
															<label for="total_penerimaan">Total Penerimaan</label>
															<input type="text" class="form-control" id="total_penerimaan" name="total_penerimaan" value="<?= $value->total_penerimaan; ?>">
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
														<button type="submit" class="btn btn-primary" name="edit" value="edit">Edit</button>
													</div>
												</div>
											</form>
										</div>
									</div>

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

	
	// id
	// kode_penerimaan
	// tanggal_penerimaan
	// keterangan_penerimaan
	// total_penerimaan

	$penerimaaan = DataPenerimaanKasORM::create();
	$penerimaaan->kode_penerimaan = $_POST['kode_penerimaan'];
	$penerimaaan->tanggal_penerimaan = $_POST['tanggal_penerimaan'];
	$penerimaaan->keterangan_penerimaan = $_POST['keterangan_penerimaan'];
	$penerimaaan->total_penerimaan = $_POST['total_penerimaan'];
	$penerimaaan->save();

	// check if saldo is enough
	$saldo = SaldoORM::find_one();
	$saldo->saldo = $saldo->saldo + $_POST['total_penerimaan'];
	$saldo->save();

	// header('Location: index.php?page=penjualan');
	echo "<script>window.location.href='index.php?page=kas-masuk';</script>";
}

if (isset($_POST['edit'])) {

	$total_penerimaan_baru = $_POST['total_penerimaan'];
	$total_penerimaan_lama = DataPenerimaanKasORM::find_one($_POST['id'])->total_penerimaan;

	// update saldo 
	$saldo = SaldoORM::find_one();
	$saldo->saldo = $saldo->saldo + $total_penerimaan_lama - $total_penerimaan_baru;
	$saldo->save();

	// id
	// kode_penerimaan
	// tanggal_penerimaan
	// keterangan_penerimaan
	// total_penerimaan
	$penerimaaan = DataPenerimaanKasORM::where('id', $_POST['id'])->find_one();
	$penerimaaan->kode_penerimaan = $_POST['kode_penerimaan'];
	$penerimaaan->tanggal_penerimaan = $_POST['tanggal_penerimaan'];
	$penerimaaan->keterangan_penerimaan = $_POST['keterangan_penerimaan'];
	$penerimaaan->total_penerimaan = $_POST['total_penerimaan'];
	$penerimaaan->save();


	// header('Location: index.php?page=penjualan');
	// reload 
	echo "<script>window.location.href='index.php?page=kas-masuk';</script>";
}

if (isset($_POST['delete'])) {
	$penerimaaan = DataPenerimaanKasORM::where('id', $_POST['id'])->find_one();

	$saldo = SaldoORM::find_one();
	$saldo->saldo = $saldo->saldo - $penerimaaan->total_penerimaan;
	$saldo->save();

	$penerimaaan->delete();

	// header('Location: index.php?page=penjualan');
	echo "<script>window.location.href='index.php?page=kas-masuk';</script>";
}

// btn_saldo
if (isset($_POST['btn_saldo'])) {
	$saldo = SaldoORM::find_one();
	$saldo->saldo = $_POST['saldo'];
	$saldo->save();
	echo "<script>window.location.href='index.php?page=kas-masuk';</script>";
}
?>

<script>

</script>

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