<?php
include('../../helper.php');

foreach (glob("../../orm/*.php") as $filename) {
	include $filename;
}
// get kode_pembelian
$kode_pembelian = 'PL-' . date('my') . '1';
if (isset($_GET['kode_pembelian'])) {
	$kode_pembelian = $_GET['kode_pembelian'];
}

$tanggal_pembelian = date('Y-m-d');
$kode_supplier = '';


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Nota_Pembelian (" . date('d-m-Y') . ").xls");
?>

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Invoice <?= $kode_pembelian ?></h1>
			</div>

		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table data pembelian	 -->
		<div class="card">
			<div class="card-header">
				<?php
				$data_invoice = DataPenjualanORM::raw_query("SELECT * FROM pembelian join data_supplier on pembelian.kode_supplier = data_supplier.kode_supplier join data_barang on pembelian.kode_barang = data_barang.kode_barang WHERE kode_pembelian = '$kode_pembelian'")->find_one();

				?>

				<h4>
					NPWP : <?= $data_invoice->npwp_supplier ?>
				</h4>

			</div>

			<div class="card-body">
				<!-- button tambah data pembelian modal -->
				<div class="row text-right">

				</div>
				<br>
				<div class="row text-right">
					<div class="col-md-12">

					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered table-striped" border="1">
							<thead>
								<tr>
									<!-- // id
								// kode_pembelian
								// tanggal_pembelian
								// kode_supplier
								// kode_barang
								// harga_beli_pembelian
								// jumlah_pembelian
								// sub_total_pembelian -->
									<th>No</th>
									<th>Kode Pembelian</th>
									<th>Tanggal Pembelian</th>
									<th>Supplier</th>
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


								$data = DataPembelianORM::table_alias('p1')
									->select('p1.*')
									->select('p1.id', 'id_pembelian')
									->select('p2.*')
									->select('p2.id', 'id_barang')
									->select('p3.*')
									->select('p3.id', 'id_pelanggan')
									->join('data_barang', array('p1.kode_barang', '=', 'p2.kode_barang'), 'p2')
									->join('data_supplier', array('p1.kode_supplier', '=', 'p3.kode_supplier'), 'p3')
									->where(array('kode_pembelian' => $kode_pembelian))
									->find_many();

								$total_jumlah = 0;
								$total_sub_total = 0;

								foreach ($data as $key => $value) {
									$tanggal_pembelian = $value->tanggal_pembelian;
									$kode_supplier = $value->kode_supplier;

								?>
									<tr>
										<td><?= $no++;  ?></td>
										<td><?= $value->kode_pembelian; ?></td>
										<td><?= $value->tanggal_pembelian; ?></td>
										<td><?= $value->nama_supplier; ?></td>
										<td><?= $value->nama_barang; ?></td>
										<td><?= rupiah($value->harga_beli_pembelian); ?></td>
										<td><?php echo ($value->jumlah_pembelian);
											$total_jumlah += $value->jumlah_pembelian; ?></td>
										<td><?= rupiah($value->sub_total_pembelian);
											$total_sub_total += $value->sub_total_pembelian; ?></td>

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