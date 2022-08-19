<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Data Pelanggan</h1>
			</div>

		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table data pelanggan	 -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Data Pelanggan</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i></button>
				</div>
			</div>

			<div class="card-body">
				<!-- button tambah data pelanggan modal -->
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
						<!-- // id
						// kode_pelanggan
						// nama_pelanggan
						// alamat_pelanggan
						// telp_pelanggan -->
						<table class="table table-bordered table-striped dataTable">
							<thead>
								<tr>
									<th>No</th>
									<th>Kode Pelanggan</th>
									<th>Nama Pelanggan</th>
									<th>Alamat Pelanggan</th>
									<th>Telp Pelanggan</th>
									<th>NPWP</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$no = 1;
								$data = DataPelangganORM::find_many();

								foreach ($data as $key => $value) {
								?>
									<tr>
										<td><?= $no++ ?></td>
										<td><?= $value->kode_pelanggan ?></td>
										<td><?= $value->nama_pelanggan ?></td>
										<td><?= $value->alamat_pelanggan ?></td>
										<td><?= $value->telp_pelanggan ?></td>
										<td><?= $value->npwp_pelanggan ?></td>
										<td>
											<!-- Modal Edit -->
											<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-edit<?= $value->id; ?>">
												<i class="fas fa-edit"></i>
											</button>
											<!-- Modal Delete -->
											<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete<?= $value->id; ?>">
												<i class="fas fa-trash"></i>
											</button>
										</td>
									</tr>

									<!-- Modal Edit -->
									<div class="modal fade" id="modal-edit<?= $value->id; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<form action="" method="post">
													<input type="hidden" name="id" value="<?= $value->id; ?>">

													<div class="modal-header">
														<h4 class="modal-title">Edit Data Pelanggan</h4>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<div class="form-group">
															<label for="kode_pelanggan">Kode Pelanggan</label>
															<input type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan" value="<?= $value->kode_pelanggan ?>" readonly>
														</div>
														<div class="form-group">
															<label for="nama_pelanggan">Nama Pelanggan</label>
															<input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="<?= $value->nama_pelanggan ?>">
														</div>
														<div class="form-group">
															<label for="alamat_pelanggan">Alamat Pelanggan</label>
															<textarea class="form-control" id="alamat_pelanggan" name="alamat_pelanggan" rows="3"><?= $value->alamat_pelanggan ?></textarea>
														</div>
														<div class="form-group">
															<label for="telp_pelanggan">Telp Pelanggan</label>
															<input type="number" class="form-control" id="telp_pelanggan" name="telp_pelanggan" value="<?= $value->telp_pelanggan ?>">
														</div>
														<div class="form-group">
															<label for="npwp_pelanggan">NPWP Pelanggan</label>
															<input type="text" class="form-control" id="npwp_pelanggan" name="npwp_pelanggan" value="<?= $value->npwp_pelanggan ?>">
														</div>
													</div>
													<div class="modal-footer justify-content-between">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-primary" name="edit" value="edit">Edit</button>
													</div>
												</form>

											</div>
										</div>
									</div>

									<!-- Modal Delete -->
									<div class="modal fade" id="modal-delete<?= $value->id; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Delete Data Pelanggan</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="" method="post">
													<div class="modal-body">
														<input type="hidden" name="id" value="<?= $value->id; ?>">
														<p>Apakah anda yakin ingin menghapus data ini?</p>
														<div class="row">
															<div class="col-md-6">
																<label for="kode_pelanggan">Kode Pelanggan</label>
																<input type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan" value="<?= $value->kode_pelanggan; ?>" readonly>
															</div>
															<div class="col-md-6">
																<label for="nama_pelanggan">Nama Pelanggan</label>
																<input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="<?= $value->nama_pelanggan; ?>" readonly>
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
										<h4 class="modal-title">Tambah Data Pelanggan</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<!-- // id kode_pelanggan nama_pelanggan stok kode_pelanggan harga_beli harga_jual -->
									<form action="" method="post">
										<div class="modal-body">
											<?php
											$last_id = DataPelangganORM::order_by_desc('id')
												->limit(1)
												->find_one();

											// check if last_id is null
											if ($last_id == null) {
												$last_id = 1;
											} else {
												$last_id = $last_id->id + 1;
											}

											// kode pelanggan  = BR-mmyy.idpelanggan
											$kode_pelanggan = "PL-" . date('my') . $last_id;
											?>
											<!-- id
											kode_pelanggan
											nama_pelanggan
											alamat_pelanggan
											telp_pelanggan 
											npwp_pelanggan -->
											<div class="form-group">
												<label for="kode_pelanggan">Kode Pelanggan</label>
												<input type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan" readonly value="<?= $kode_pelanggan; ?>">
											</div>
											<div class="form-group">
												<label for="nama_pelanggan">Nama Pelanggan</label>
												<input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
											</div>
											<div class="form-group">
												<label for="alamat_pelanggan">Alamat Pelanggan</label>
												<textarea class="form-control" id="alamat_pelanggan" name="alamat_pelanggan" required></textarea>
											</div>
											<div class="form-group">
												<label for="telp_pelanggan">Telp Pelanggan</label>
												<input type="number" class="form-control" id="telp_pelanggan" name="telp_pelanggan" required>
											</div>
											<div class="form-group">
												<label for="npwp_pelanggan">NPWP Pelanggan</label>
												<input type="number" class="form-control" id="npwp_pelanggan" name="npwp_pelanggan" required>
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
// kode_pelanggan
// nama_pelanggan
// alamat_pelanggan
// telp_pelanggan 
if (isset($_POST['tambah'])) {
	$pelanggan = DataPelangganORM::create();
	$pelanggan->kode_pelanggan = $_POST['kode_pelanggan'];
	$pelanggan->nama_pelanggan = $_POST['nama_pelanggan'];
	$pelanggan->alamat_pelanggan = $_POST['alamat_pelanggan'];
	$pelanggan->telp_pelanggan = $_POST['telp_pelanggan'];
	$pelanggan->npwp_pelanggan = $_POST['npwp_pelanggan'];

	$pelanggan->save();

	// header('Location: index.php?page=pelanggan');
	echo "<script>window.location.href='index.php?page=pelanggan';</script>";
}

if (isset($_POST['edit'])) {
	$pelanggan = DataPelangganORM::find_one($_POST['id']);
	$pelanggan->kode_pelanggan = $_POST['kode_pelanggan'];
	$pelanggan->nama_pelanggan = $_POST['nama_pelanggan'];
	$pelanggan->alamat_pelanggan = $_POST['alamat_pelanggan'];
	$pelanggan->telp_pelanggan = $_POST['telp_pelanggan'];
	$pelanggan->npwp_pelanggan = $_POST['npwp_pelanggan'];
	$pelanggan->save();

	// header('Location: index.php?page=pelanggan');
	// reload 
	echo "<script>window.location.href='index.php?page=pelanggan';</script>";
}

if (isset($_POST['delete'])) {
	$pelanggan = DataPelangganORM::find_one($_POST['id']);
	$pelanggan->delete();

	// header('Location: index.php?page=pelanggan');
	// reload
	echo "<script>window.location.href='index.php?page=pelanggan';</script>";
}
?>