<?php
include('../../helper.php');

foreach (glob("../../orm/*.php") as $filename) {
	include $filename;
}


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekap_keuangan (" . date('d-m-Y') . ").xls");
?>

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

			</div>

			<div class="card-body">
				<!-- button tambah data penjualan modal -->

				<br>
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered table-striped dataTable" border="1">
							<thead>
								<tr>
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

								$total_kas_masuk = 0;
								$total_kas_keluar = 0;

								foreach ($data as $key => $value) {
								?>
									<tr>
										<td><?= $no++; ?></td>
										<td><?= $value->tanggal_rekap; ?></td>
										<td><?= $value->keterangan_rekap; ?></td>
										<?php
										if ($value->tipe_rekap == 'penerimaan') {
											$total_kas_masuk += $value->total_rekap;
										?>
											<td><?= rupiah($value->total_rekap); ?></td>
											<td><?= rupiah(0) ?></td>
										<?php
										} else {
											$total_kas_keluar += $value->total_rekap;
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
								<tr>
									<td colspan="3">Total</td>
									<td><?= rupiah($total_kas_masuk); ?></td>
									<td><?= rupiah($total_kas_keluar); ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
