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
header("Content-Disposition: attachment; filename=Nota_penjualan (" . date('d-m-Y') . ").xls");
$query = "Select * from penjualan join data_pelanggan on penjualan.kode_pelanggan = data_pelanggan.kode_pelanggan join data_barang on penjualan.kode_barang = data_barang.kode_barang where tanggal_penjualan between '{$_GET['start_date']}' and '{$_GET['end_date']}'";
$dataPenjualan = DataPenjualanORM::raw_query($query)->find_many();
?>

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Detail Penjualan Dari <?= $_GET['start_date'] ?> Sampai <?= $_GET['end_date'] ?></h1>
			</div>

		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table data penjualan	 -->
		<div class="card">


			<div class="card-body">
				<!-- button tambah data penjualan modal -->

				<br>

				<br>
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered table-striped" border="1">
							<thead>
								<tr>
									<!-- // id
								// kode_penjualan
								// tanggal_penjualan
								// kode_pelanggan
								// kode_barang
								// harga_jual_penjualan
								// jumlah_penjualan
								// sub_total_penjualan -->
									<th>No</th>
									<th>Kode Penjualan</th>
									<th>Tanggal Penjualan</th>
									<th>Pelanggan</th>
									<th>Barang</th>
									<th>Harga Jual</th>
									<th>Jumlah</th>
									<th>Sub Total</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$no = 1;
								// $results = ORM::for_table('person')
								// 	->table_alias('p1')
								// 	->select('p1.*')
								// 	->select('p2.name', 'parent_name')
								// 	->join('person', array('p1.parent', '=', 'p2.id'), 'p2')
								// 	->find_many();

								foreach ($dataPenjualan as $key => $value) {
									$tanggal_penjualan = $value->tanggal_penjualan;
									$kode_pelanggan = $value->kode_pelanggan;

								?>
									<tr>
										<td><?= $no++;  ?></td>
										<td><?= $value->kode_penjualan; ?></td>
										<td><?= $value->tanggal_penjualan; ?></td>
										<td><?= $value->nama_pelanggan; ?></td>
										<td><?= $value->nama_barang; ?></td>
										<td><?= rupiah($value->harga_jual_penjualan); ?></td>
										<td><?php echo ($value->jumlah_penjualan);
											$total_jumlah += $value->jumlah_penjualan; ?></td>
										<td><?= rupiah($value->sub_total_penjualan);
											$total_sub_total += $value->sub_total_penjualan; ?></td>

									</tr>



								<?php
								}
								?>
								<tr>
									<td colspan="6" align="right">Total</td>
									<td><?= ($total_jumlah); ?></td>
									<td><?= rupiah($total_sub_total); ?></td>
								</tr>
								<!-- pajak 10% -->
								<tr>
									<td colspan="7" align="right">Pajak 10%</td>
									<td><?= rupiah(($total_sub_total * 10) / 100); ?></td>
								</tr>
								<!-- total + pajak -->
								<tr>
									<td colspan="7" align="right">Total + Pajak</td>
									<td><?= rupiah(($total_sub_total * 110) / 100); ?></td>
								</tr>
							</tbody>
						</table>


					</div>
				</div>
			</div>
		</div>
	</div>
</section>
