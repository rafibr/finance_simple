<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Data Barang</h1>
			</div>

		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table data barang	 -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Data Barang</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i></button>
				</div>
			</div>

			<div class="card-body">
				<!-- button tambah data barang modal -->
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
									<th>No</th>
									<th>Kode Barang</th>
									<th>Nama Barang</th>
									<th>Harga Jual</th>
									<th>Harga Beli</th>
									<th>Stok</th>
									<th>Supplier</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$no = 1;
								$data = DataBarangORM::find_many();

								// id kode_barang nama_barang stok kode_supplier harga_beli harga_jual						
								foreach ($data as $key => $value) {
								?>
									<tr>
										<td><?= $no++; ?></td>
										<td><?= $value->kode_barang; ?></td>
										<td><?= $value->nama_barang; ?></td>
										<td><?= rupiah($value->harga_jual); ?></td>
										<td><?= rupiah($value->harga_beli); ?></td>
										<td><?= $value->stok; ?></td>
										<td><?= $value->kode_supplier; ?></td>
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

									<!-- Modal Delete -->
									<div class="modal fade" id="modal-delete<?= $value->id; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Delete Data Barang</h4>
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
																<label for="kode_barang">Kode Barang</label>
																<input type="text" class="form-control" id="kode_barang" name="kode_barang" value="<?= $value->kode_barang; ?>" readonly>
															</div>
															<div class="col-md-6">
																<label for="nama_barang">Nama Barang</label>
																<input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= $value->nama_barang; ?>" readonly>
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
									<!-- Modal Edit -->
									<div class="modal fade" id="modal-edit<?= $value->id; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Edit Data Barang</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="" method="post">
													<div class="modal-body">
														<input type="hidden" name="id" value="<?= $value->id; ?>">
														<div class="form-group">
															<label for="kode_barang">Kode Barang</label>
															<input type="text" class="form-control" id="kode_barang" name="kode_barang" value="<?= $value->kode_barang; ?>" readonly>
														</div>
														<div class="form-group">
															<label for="nama_barang">Nama Barang</label>
															<input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= $value->nama_barang; ?>">
														</div>
														<div class="form-group">
															<label for="harga_jual">Harga Jual</label>
															<input type="number" class="form-control" id="harga_jual" name="harga_jual" value="<?= $value->harga_jual; ?>">
														</div>
														<div class="form-group">
															<label for="harga_beli">Harga Beli</label>
															<input type="number" class="form-control" id="harga_beli" name="harga_beli" value="<?= $value->harga_beli; ?>">
														</div>
														<div class="form-group">
															<label for="kode_supplier">Kode Supplier</label>
															<!-- get data from supplier -->
															<select class="form-control select2" id="kode_supplier<?= $value->id ?>" name="kode_supplier">
																<?php
																$supplier = DataSupplierORM::find_many();
																foreach ($supplier as $value) {
																?>
																	<option value="<?= $value->kode_supplier; ?>" <?= $value->kode_supplier == $value->kode_supplier ? 'selected' : ''; ?>><?= $value->kode_supplier; ?> | <?= $value->nama_supplier; ?></option>
																<?php
																}
																?>
															</select>
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
										<h4 class="modal-title">Tambah Data Barang</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<!-- // id kode_barang nama_barang stok kode_supplier harga_beli harga_jual -->
									<form action="" method="post">
										<div class="modal-body">
											<?php
											$last_id = DataBarangORM::order_by_desc('id')
												->limit(1)
												->find_one();

											// check if last_id is null
											if ($last_id == null) {
												$last_id = 1;
											} else {
												$last_id = $last_id->id + 1;
											}

											// kode barang  = BR-mmyy.idbarang
											$kode_barang = "BR-" . date('my') . $last_id;

											?>
											<div class="form-group">
												<label for="kode_barang">Kode Barang</label>
												<input type="text" class="form-control" id="kode_barang" name="kode_barang" readonly value="<?= $kode_barang; ?>">
											</div>
											<div class="form-group">
												<label for="nama_barang">Nama Barang</label>
												<input type="text" class="form-control" id="nama_barang" name="nama_barang">
											</div>
											<div class="form-group">
												<label for="kode_supplier">Kode Supplier</label>
												<!-- get data from supplier -->
												<select class="form-control select2" id="kode_supplier" name="kode_supplier">
													<?php
													$supplier = DataSupplierORM::find_many();
													foreach ($supplier as $value) {
													?>
														<option value="<?= $value->kode_supplier; ?>"><?= $value->kode_supplier; ?> | <?= $value->nama_supplier; ?></option>
													<?php
													}
													?>
												</select>
											</div>
											<div class="form-group">
												<label for="harga_beli">Harga Beli</label>
												<input type="number" class="form-control" id="harga_beli" name="harga_beli">
											</div>
											<div class="form-group">
												<label for="harga_jual">Harga Jual</label>
												<input type="number" class="form-control" id="harga_jual" name="harga_jual">
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

if (isset($_POST['tambah'])) {
	$barang = DataBarangORM::create();
	$barang->kode_barang = $_POST['kode_barang'];
	$barang->nama_barang = $_POST['nama_barang'];
	$barang->kode_supplier = $_POST['kode_supplier'];
	$barang->harga_beli = $_POST['harga_beli'];
	$barang->harga_jual = $_POST['harga_jual'];

	$barang->save();

	// header('Location: index.php?page=barang');
	echo "<script>window.location.href='index.php?page=barang';</script>";
}

if (isset($_POST['edit'])) {
	$barang = DataBarangORM::find_one($_POST['id']);
	$barang->nama_barang = $_POST['nama_barang'];
	$barang->kode_supplier = $_POST['kode_supplier'];
	$barang->harga_beli = $_POST['harga_beli'];
	$barang->harga_jual = $_POST['harga_jual'];
	$barang->save();

	// header('Location: index.php?page=barang');
	// reload 
	echo "<script>window.location.href='index.php?page=barang';</script>";
}

if (isset($_POST['delete'])) {
	$barang = DataBarangORM::find_one($_POST['id']);
	$barang->delete();

	// header('Location: index.php?page=barang');
	// reload
	echo "<script>window.location.href='index.php?page=barang';</script>";
}
?>