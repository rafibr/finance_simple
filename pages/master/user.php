<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Data User</h1>
			</div>

		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table data user	 -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Data User</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i></button>
				</div>
			</div>

			<div class="card-body">
				<!-- button tambah data user modal -->
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

						<!-- id
						nama_user
						email
						password
						level -->
						<table class="table table-bordered table-striped dataTable">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama User</th>
									<th>Email</th>
									<th>Level</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$no = 1;
								$data = DataUserORM::find_many();

								foreach ($data as $key => $value) {
								?>
									<tr>
										<td><?= $no++ ?></td>
										<td><?= $value->nama_user ?></td>
										<td><?= $value->email ?></td>
										<td><?= $value->level ?></td>
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
														<h4 class="modal-title">Edit Data User</h4>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<!-- id
													nama_user
													email
													password
													level -->
													<div class="modal-body">
														<div class="form-group">
															<label for="kode_user">Nama User</label>
															<input type="text" name="nama_user" class="form-control" id="nama_user" value="<?= $value->nama_user; ?>">
														</div>
														<div class="form-group">
															<label for="email">Email</label>
															<input type="text" name="email" class="form-control" id="email" value="<?= $value->email; ?>">
														</div>
														<div class="form-group">
															<label for="password">Password</label>
															<input type="text" name="password" class="form-control" id="password" value="<?= $value->password; ?>">
														</div>
														<div class="form-group">
															<label for="level">Level</label>
															<input type="text" name="level" class="form-control" id="level" value="<?= $value->level; ?>">
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
													<h4 class="modal-title">Delete Data User</h4>
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
																<label for="nama_user">Nama User</label>
																<input type="text" class="form-control" id="nama_user" name="nama_user" value="<?= $value->nama_user; ?>" readonly>
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
										<h4 class="modal-title">Tambah Data User</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<!-- // id kode_user nama_user stok kode_user harga_beli harga_jual -->
									<form action="" method="post">
										<div class="modal-body">
											<!-- id
											nama_user
											email
											password
											level -->
											<div class="form-group">
												<label for="nama_user">Nama User</label>
												<input type="text" name="nama_user" class="form-control" id="nama_user" placeholder="Nama User">
											</div>
											<div class="form-group">
												<label for="email">Email</label>
												<input type="email" name="email" class="form-control" id="email" placeholder="Email">
											</div>
											<div class="form-group">
												<label for="password">Password</label>
												<input type="password" name="password" class="form-control" id="password" placeholder="Password">
											</div>
											<div class="form-group">
												<label for="level">Level</label>
												<select name="level" id="level" class="form-control">
													<option value="">-- Pilih Level --</option>
													<option value="admin">Admin</option>
													<option value="rasel">Rasel</option>
													<option value="gandi">Gandi</option>
													<option value="dea">Dea</option>

												</select>
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
// nama_user
// email
// password
// level 
if (isset($_POST['tambah'])) {
	$user = DataUserORM::create();
	$user->nama_user = $_POST['nama_user'];
	$user->email = $_POST['email'];
	$user->password = md5($_POST['password']);
	$user->level = $_POST['level'];
	$user->save();

	// header('Location: index.php?page=user');
	echo "<script>window.location.href='index.php?page=user';</script>";
}

if (isset($_POST['edit'])) {
	$user = DataUserORM::find_one($_POST['id']);
	$user->nama_user = $_POST['nama_user'];
	$user->email = $_POST['email'];
	$user->password = md5($_POST['password']);
	$user->level = $_POST['level'];
	$user->save();

	// header('Location: index.php?page=user');
	// reload 
	echo "<script>window.location.href='index.php?page=user';</script>";
}

if (isset($_POST['delete'])) {
	$user = DataUserORM::find_one($_POST['id']);
	$user->delete();

	// header('Location: index.php?page=user');
	// reload
	echo "<script>window.location.href='index.php?page=user';</script>";
}
?>