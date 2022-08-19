<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Data Kas Keluar</h1>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table data pembelian	 -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Data Kas Keluar</h3>
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

							url = '<?= app_url() . 'pages/export/pengeluaran-range.php?start_date=' ?>' + start_date + '&end_date=' + end_date;
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
				<?php
				$last_id = DataPengeluaranKasORM::order_by_desc('id')
					->find_one();

				// check if last_id is null
				if ($last_id == null) {
					$last_id = 1;
				} else {
					$last_id = $last_id->id + 1;
				}

				// kode pembelian  = BR-mmyy.idpembelian
				$kode_pembelian = "PLK-" . date('my') . $last_id;

				?>
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

							<div class="modal-body">
								<form action="" method="POST">
									<div class="form-group">
										<label>Kode Pengeluaran</label>
										<input type="text" class="form-control" id="kode_pengeluaran" name="kode_pengeluaran" placeholder="Kode Pengeluaran" value="<?= $kode_pembelian ?>" readonly>
									</div>
									<div class="form-group">
										<label>Tanggal Pengeluaran</label>
										<input type="date" class="form-control" id="tanggal_pengeluaran" name="tanggal_pengeluaran" placeholder="Tanggal Pengeluaran">
									</div>
									<div class="form-group">
										<label>Keterangan Pengeluaran</label>
										<textarea class="form-control" id="keterangan_pengeluaran" name="keterangan_pengeluaran" placeholder="Keterangan Pengeluaran" rows="5"></textarea>

									</div>
									<div class="form-group">
										<label>Total Pengeluaran</label>
										<!-- prepend icon -->
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">Rp</span>
											</div>
											<input type="number" class="form-control" id="total_pengeluaran" name="total_pengeluaran" placeholder="Total Pengeluaran">
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
									<th>Kode Kas Keluar</th>
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

								$data = DataPenjualanORM::raw_query("SELECT *, pengeluaran.id as id_pengeluaran FROM pengeluaran left join pembelian on pengeluaran.kode_pembelian = pembelian.kode_pembelian left join data_supplier on pembelian.kode_supplier = data_supplier.kode_supplier group by pengeluaran.kode_pengeluaran order by pengeluaran.tanggal_pengeluaran desc")->find_many();

								foreach ($data as $key => $value) {
								?>
									<tr>
										<td><?= $no++; ?></td>
										<td><?= $value->kode_pengeluaran; ?></td>
										<td><?= $value->kode_pembelian; ?></td>
										<td><?= $value->tanggal_pengeluaran; ?></td>
										<td><?= $value->keterangan_pengeluaran; ?></td>
										<td><?= rupiah($value->total_pengeluaran); ?></td>
										<td>
											<!-- button group  -->
											<div class="btn-group btn-group-sm">

												<?php if ($value->kode_pembelian == null) : ?>
													<!-- edit -->
													<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $value->id_pengeluaran; ?>">
														<i class="fas fa-edit"></i>
													</button>

													<!-- delete -->
													<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $value->id_pengeluaran; ?>">
														<i class="fas fa-trash"></i>
													</button>
												<?php else : ?>
													<!-- Detail -->
													<a href="<?= site_url('pembelian') . '&aksi=detail&kode_pembelian=' . $value->kode_pembelian; ?>" class="btn btn-info">
														<i class="fas fa-info-circle"></i>
													</a>
												<?php endif; ?>
											</div>

										</td>
									</tr>

									<!-- Modal Delete -->
									<div class="modal fade" id="delete<?= $value->id_pengeluaran; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
														<input type="hidden" name="id" value="<?= $value->id_pengeluaran; ?>">
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
									<div class="modal fade" id="edit<?= $value->id_pengeluaran; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
														<input type="hidden" name="id" value="<?= $value->id_pengeluaran; ?>">
														<div class="form-group">
															<label for="kode_pengeluaran">Kode Pengeluaran</label>
															<input type="text" class="form-control" id="kode_pengeluaran" name="kode_pengeluaran" value="<?= $value->kode_pengeluaran; ?>" readonly>
														</div>
														<div class="form-group">
															<label for="tanggal_pengeluaran">Tanggal Pengeluaran</label>
															<input type="date" class="form-control" id="tanggal_pengeluaran" name="tanggal_pengeluaran" value="<?= $value->tanggal_pengeluaran; ?>">
														</div>
														<div class="form-group">
															<label for="keterangan_pengeluaran">Keterangan Pengeluaran</label>
															<textarea class="form-control" id="keterangan_pengeluaran" name="keterangan_pengeluaran" rows="3"><?= $value->keterangan_pengeluaran; ?></textarea>
														</div>
														<div class="form-group">
															<label for="total_pengeluaran">Total Pengeluaran</label>
															<input type="text" class="form-control" id="total_pengeluaran" name="total_pengeluaran" value="<?= $value->total_pengeluaran; ?>">
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
// kode_pembelian
// tanggal_pembelian
// kode_pelanggan
// kode_barang
// harga_jual_pembelian
// jumlah_pembelian
// sub_total_pembelian	


if (isset($_POST['tambah'])) {
	// check if saldo is enough
	$saldo = SaldoORM::find_one();
	$saldo = $saldo->saldo;
	$total = $_POST['total_pengeluaran'];
	if ($saldo < $total) {
		echo "<script>alert('Saldo tidak cukup');</script>";
		return;
	}


	// id
	// kode_pengeluaran
	// tanggal_pengeluaran
	// keterangan_pengeluaran
	// total_pengeluaran

	$penerimaaan = DataPengeluaranKasORM::create();
	$penerimaaan->kode_pengeluaran = $_POST['kode_pengeluaran'];
	$penerimaaan->tanggal_pengeluaran = $_POST['tanggal_pengeluaran'];
	$penerimaaan->keterangan_pengeluaran = $_POST['keterangan_pengeluaran'];
	$penerimaaan->total_pengeluaran = $_POST['total_pengeluaran'];
	$penerimaaan->save();

	// update saldo
	$saldo = SaldoORM::find_one();
	$saldo->saldo = $saldo->saldo - $_POST['total_pengeluaran'];
	$saldo->save();

	// header('Location: index.php?page=pembelian');
	echo "<script>window.location.href='index.php?page=kas-keluar';</script>";
}

if (isset($_POST['edit'])) {


	$total_pengeluaran_baru = $_POST['total_pengeluaran'];
	$total_pengeluaran_lama = DataPengeluaranKasORM::find_one($_POST['id'])->total_pengeluaran;

	// update saldo 
	$saldo = SaldoORM::find_one();
	$saldo->saldo = $saldo->saldo + $total_pengeluaran_lama - $total_pengeluaran_baru;
	$saldo->save();

	// id
	// kode_pengeluaran
	// tanggal_pengeluaran
	// keterangan_pengeluaran
	// total_pengeluaran
	$penerimaaan = DataPengeluaranKasORM::where('id', $_POST['id'])->find_one();
	$penerimaaan->kode_pengeluaran = $_POST['kode_pengeluaran'];
	$penerimaaan->tanggal_pengeluaran = $_POST['tanggal_pengeluaran'];
	$penerimaaan->keterangan_pengeluaran = $_POST['keterangan_pengeluaran'];
	$penerimaaan->total_pengeluaran = $_POST['total_pengeluaran'];
	$penerimaaan->save();


	// header('Location: index.php?page=pembelian');
	// reload 
	echo "<script>window.location.href='index.php?page=kas-keluar';</script>";
}

if (isset($_POST['delete'])) {
	$penerimaaan = DataPengeluaranKasORM::where('id', $_POST['id'])->find_one();

	// update saldo
	$saldo = SaldoORM::find_one();
	$saldo->saldo = $saldo->saldo + $penerimaaan->total_pengeluaran;
	$saldo->save();

	$penerimaaan->delete();

	// header('Location: index.php?page=pembelian');
	echo "<script>window.location.href='index.php?page=kas-keluar';</script>";
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