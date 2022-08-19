<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Data Supplier</h1>
			</div>

		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table data supplier	 -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Data Supplier</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i></button>
				</div>
			</div>

			<div class="card-body">
				<!-- button tambah data supplier modal -->
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
						// kode_supplier
						// nama_supplier
						// alamat_supplier
						// telp_supplier -->
						<table class="table table-bordered table-striped dataTable">
							<thead>
								<tr>
									<th>No</th>
									<th>Kode Supplier</th>
									<th>Nama Supplier</th>
									<th>Alamat Supplier</th>
									<th>Telp Supplier</th>
									<th>NPWP</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$no = 1;
								$data = DataSupplierORM::find_many();

								foreach ($data as $key => $value) {
								?>
									<tr>
										<td><?= $no++ ?></td>
										<td><?= $value->kode_supplier ?></td>
										<td><?= $value->nama_supplier ?></td>
										<td><?= $value->alamat_supplier ?></td>
										<td><?= $value->telp_supplier ?></td>
										<td><?= $value->npwp_supplier ?></td>
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
														<h4 class="modal-title">Edit Data Supplier</h4>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<div class="form-group">
															<label for="kode_supplier">Kode Supplier</label>
															<input type="text" class="form-control" id="kode_supplier" name="kode_supplier" value="<?= $value->kode_supplier ?>" readonly>
														</div>
														<div class="form-group">
															<label for="nama_supplier">Nama Supplier</label>
															<input type="text" class="form-control" id="nama_supplier" name="nama_supplier" value="<?= $value->nama_supplier ?>">
														</div>
														<div class="form-group">
															<label for="alamat_supplier">Alamat Supplier</label>
															<textarea class="form-control" id="alamat_supplier" name="alamat_supplier" rows="3"><?= $value->alamat_supplier ?></textarea>
														</div>
														<div class="form-group">
															<label for="telp_supplier">Telp Supplier</label>
															<input type="number" class="form-control" id="telp_supplier" name="telp_supplier" value="<?= $value->telp_supplier ?>">
														</div>
														<div class="form-group">
															<label for="npwp_supplier">NPWP Supplier</label>
															<input type="text" class="form-control" id="npwp_supplier" name="npwp_supplier" value="<?= $value->npwp_supplier ?>">
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
													<h4 class="modal-title">Delete Data Supplier</h4>
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
																<label for="kode_supplier">Kode Supplier</label>
																<input type="text" class="form-control" id="kode_supplier" name="kode_supplier" value="<?= $value->kode_supplier; ?>" readonly>
															</div>
															<div class="col-md-6">
																<label for="nama_supplier">Nama Supplier</label>
																<input type="text" class="form-control" id="nama_supplier" name="nama_supplier" value="<?= $value->nama_supplier; ?>" readonly>
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
										<h4 class="modal-title">Tambah Data Supplier</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<!-- // id kode_supplier nama_supplier stok kode_supplier harga_beli harga_jual -->
									<form action="" method="post">
										<div class="modal-body">
											<?php
											$last_id = DataSupplierORM::order_by_desc('id')
												->limit(1)
												->find_one();

											// check if last_id is null
											if ($last_id == null) {
												$last_id = 1;
											} else {
												$last_id = $last_id->id + 1;
											}

											// kode supplier  = BR-mmyy.idsupplier
											$kode_supplier = "SP-" . date('my') . $last_id;
											?>
											<!-- id
											kode_supplier
											nama_supplier
											alamat_supplier
											telp_supplier 
											npwp_supplier -->
											<div class="form-group">
												<label for="kode_supplier">Kode Supplier</label>
												<input type="text" class="form-control" id="kode_supplier" name="kode_supplier" readonly value="<?= $kode_supplier; ?>">
											</div>
											<div class="form-group">
												<label for="nama_supplier">Nama Supplier</label>
												<input type="text" class="form-control" id="nama_supplier" name="nama_supplier" required>
											</div>
											<div class="form-group">
												<label for="alamat_supplier">Alamat Supplier</label>
												<textarea class="form-control" id="alamat_supplier" name="alamat_supplier" required></textarea>
											</div>
											<div class="form-group">
												<label for="telp_supplier">Telp Supplier</label>
												<input type="number" class="form-control" id="telp_supplier" name="telp_supplier" required>
											</div>
											<div class="form-group">
												<label for="npwp_supplier">NPWP Supplier</label>
												<input type="number" class="form-control" id="npwp_supplier" name="npwp_supplier" required>
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
// kode_supplier
// nama_supplier
// alamat_supplier
// telp_supplier 
if (isset($_POST['tambah'])) {
	$supplier = DataSupplierORM::create();
	$supplier->kode_supplier = $_POST['kode_supplier'];
	$supplier->nama_supplier = $_POST['nama_supplier'];
	$supplier->alamat_supplier = $_POST['alamat_supplier'];
	$supplier->telp_supplier = $_POST['telp_supplier'];
	$supplier->npwp_supplier = $_POST['npwp_supplier'];

	$supplier->save();

	// header('Location: index.php?page=supplier');
	echo "<script>window.location.href='index.php?page=supplier';</script>";
}

if (isset($_POST['edit'])) {
	$supplier = DataSupplierORM::find_one($_POST['id']);
	$supplier->kode_supplier = $_POST['kode_supplier'];
	$supplier->nama_supplier = $_POST['nama_supplier'];
	$supplier->alamat_supplier = $_POST['alamat_supplier'];
	$supplier->telp_supplier = $_POST['telp_supplier'];
	$supplier->npwp_supplier = $_POST['npwp_supplier'];
	$supplier->save();

	// header('Location: index.php?page=supplier');
	// reload 
	echo "<script>window.location.href='index.php?page=supplier';</script>";
}

if (isset($_POST['delete'])) {
	$supplier = DataSupplierORM::find_one($_POST['id']);
	$supplier->delete();

	// header('Location: index.php?page=supplier');
	// reload
	echo "<script>window.location.href='index.php?page=supplier';</script>";
}
?>