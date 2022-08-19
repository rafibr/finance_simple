<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Rekap Keuangan</h1>
			</div>

		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table data penjualan	 -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Rekap Keuangan</h3>
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
						<!-- print nota pdf and xls  -->

						<button type="button" class="btn btn-success" onclick="print_nota_xls()">
							<i class="fas fa-file-excel"></i> Excel
						</button>
						<script>
							function print_nota_xls() {
								url = '<?= app_url() . 'pages/export/rekap-kas-xls.php' ?>';
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
				<br>
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered table-striped dataTable">
							<thead>
								<tr>
									<!-- id -->
									<!-- tanggal -->
									<!-- keterangan -->
									<!-- kas_masuk -->
									<!-- kas_keluar	 -->

									<th>No</th>
									<th>Tanggal</th>
									<th>Keterangan</th>
									<th>Kas Masuk</th>
									<th>Kas Keluar</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$no = 1;

								$data = DataPenerimaanKasORM::raw_query("SELECT id as id_rekap,
								kode_pengeluaran as kode_rekap,
								tanggal_pengeluaran as tanggal_rekap,
								keterangan_pengeluaran as keterangan_rekap,
								total_pengeluaran as total_rekap,
								kode_pembelian as kode_transaksi_rekap,
								'pengeluaran' as tipe_rekap
							from pengeluaran
							UNION all
							SELECT id as id_rekap,
								kode_penerimaan as kode_rekap,
								tanggal_penerimaan as tanggal_rekap,
								keterangan_penerimaan as keterangan_rekap,
								total_penerimaan as total_rekap,
								kode_penjualan as kode_transaksi_rekap,
								'penerimaan' as tipe_rekap
							from penerimaan
							ORDER BY tanggal_rekap DESC;")->find_many();

								foreach ($data as $key => $value) {
								?>
									<tr>
										<td><?= $no++; ?></td>
										<td><?= $value->tanggal_rekap; ?></td>
										<td><?= $value->keterangan_rekap; ?></td>
										<?php
										if ($value->tipe_rekap == 'penerimaan') {
										?>
											<td><?= rupiah($value->total_rekap); ?></td>
											<td><?= rupiah(0) ?></td>
										<?php
										} else {
										?>
											<td><?= rupiah(0); ?></td>
											<td><?= rupiah($value->total_rekap); ?></td>
										<?php
										}
										?>
									</tr>
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


	// header('Location: index.php?page=penjualan');
	echo "<script>window.location.href='index.php?page=penjualan&aksi=detail&kode_penjualan=$_POST[kode_penjualan]';</script>";
}

if (isset($_POST['edit'])) {
	$penjualan = DataPenjualanORM::find_one($_POST['id']);
	$penjualan->nama_penjualan = $_POST['nama_penjualan'];
	$penjualan->kode_supplier = $_POST['kode_supplier'];
	$penjualan->harga_beli = $_POST['harga_beli'];
	$penjualan->harga_jual = $_POST['harga_jual'];
	$penjualan->save();

	// header('Location: index.php?page=penjualan');
	// reload 
	echo "<script>window.location.href='index.php?page=penjualan';</script>";
}

if (isset($_POST['delete'])) {
	$penjualan = DataPenjualanORM::find_one($_POST['id']);
	$penjualan->delete();

	// header('Location: index.php?page=penjualan');
	// reload

	$url = "index.php?page=penjualan";
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