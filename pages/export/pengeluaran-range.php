<?php
include('../../helper.php');

foreach (glob("../../orm/*.php") as $filename) {
	include $filename;
}

$_GET['start_date'] = $_GET['start_date'] ? $_GET['start_date'] : date('Y-m-d');
$_GET['end_date'] = $_GET['end_date'] ? $_GET['end_date'] : date('Y-m-d');


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Nota_pembelian (" . date('d-m-Y') . ").xls");

// pengeluaran join pembelian join data_barang join data_supplier
$query = "Select * from pengeluaran left join pembelian on pengeluaran.kode_pembelian = pembelian.kode_pembelian left join data_barang on pembelian.kode_barang = data_barang.kode_barang left join data_supplier on pembelian.kode_supplier = data_supplier.kode_supplier where pengeluaran.tanggal_pengeluaran between '" . $_GET['start_date'] . "' and '" . $_GET['end_date'] . "' order by pengeluaran.tanggal_pengeluaran asc";
$datapembelian = DataPenerimaanKasORM::raw_query($query)->find_many();
?>

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h3 class="m-0">Detail Pengeluaran Dari <?= $_GET['start_date'] ?> Sampai <?= $_GET['end_date'] ?></h3>
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
						<table class="table table-bordered table-striped dataTable" border="1">
							<thead>
								<tr>

									<th>No</th>
									<th>Kode Kas Keluar</th>
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

								?>
									<tr>
										<td><?= $no++; ?></td>
										<td><?= $value->kode_pengeluaran; ?></td>
										<td><?= $value->kode_pembelian; ?></td>
										<td><?= $value->tanggal_pengeluaran; ?></td>
										<td><?= $value->keterangan_pengeluaran; ?></td>
										<td><?= rupiah($value->total_pengeluaran); ?></td>

									</tr>

								<?php
									$total += $value->total_pengeluaran;
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