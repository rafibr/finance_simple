<?php
include('../../helper.php');

foreach (glob("../../orm/*.php") as $filename) {
	include $filename;
}

$_GET['start_date'] = $_GET['start_date'] ? $_GET['start_date'] : date('Y-m-d');
$_GET['end_date'] = $_GET['end_date'] ? $_GET['end_date'] : date('Y-m-d');

// $account = UserORM::where(array(
// 	'email' => $email,
// 	'password' => hash('sha256', $password)
// ))->find_one();

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Nota_pembelian (" . date('d-m-Y') . ").xls");
$query = "Select * from penerimaan left join penjualan on penerimaan.kode_penjualan = penjualan.kode_penjualan left join data_barang on penjualan.kode_barang = data_barang.kode_barang left join data_pelanggan on penjualan.kode_pelanggan = data_pelanggan.kode_pelanggan where penerimaan.tanggal_penerimaan between '" . $_GET['start_date'] . "' and '" . $_GET['end_date'] . "' order by penerimaan.tanggal_penerimaan asc";

$datapembelian = DataPenerimaanKasORM::raw_query($query)->find_many();
?>

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h3 class="m-0">Detail Penerimaan Dari <?= $_GET['start_date'] ?> Sampai <?= $_GET['end_date'] ?></h3>
			</div>

		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table data pembelian	 -->
		<div class="card">


			<div class="card-body">
				<!-- button tambah data pembelian modal -->

				<br>

				<br>
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered table-striped" border="1">
							<thead>
								<tr>
									<th>No</th>
									<th>Kode Kas Masuk</th>
									<th>Invoice</th>
									<th>Tanggal</th>
									<th>Keterangan</th>
									<th>Sub Total</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$no = 1;

								$data = $datapembelian;
								$total = 0;
								foreach ($data as $key => $value) {
									$total += $value->total_penerimaan;
								?>
									<tr>
										<td><?= $no++; ?></td>
										<td><?= $value->kode_penerimaan; ?></td>
										<td><?= $value->kode_penjualan; ?></td>
										<td><?= $value->tanggal_penerimaan; ?></td>
										<td><?= $value->keterangan_penerimaan; ?></td>
										<td><?= rupiah($value->total_penerimaan); ?></td>

									</tr>
								<?php
								}
								?>
								<tr>
									<td colspan="5" align="right">Total</td>
									<td><?= rupiah($total); ?></td>
								</tr>
							</tbody>
						</table>


					</div>
				</div>
			</div>
		</div>
	</div>
</section>