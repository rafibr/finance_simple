<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Kartu Persediaan</h1>
			</div>

		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<!-- table Kartu Persediaan	 -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Kartu Persediaan</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i></button>
				</div>
			</div>

			<div class="card-body">
				<div class="row">
					<div class="col-md-4">
						<!-- berapa kali loop -->
						<div class="form-group">
							<input type="number" class="form-control" id="loop" name="loop" placeholder="Masukkan jumlah loop">
						</div>
					</div>
					<div class="col-md-2">
						<!-- Button submit -->
						<div class="form-group">
							<button type="button" class="btn btn-primary" onclick="reload()">Submit</button>
							<!-- print -->
							<button type="button" class="btn btn-primary" onclick="print()">Print</button>
						</div>
					</div>

					<script>
						function reload() {
							var loop = document.getElementById('loop').value;
							window.location.href = "?page=kartu-persediaan&loop=" + loop;
						}

						function print() {
							var loop = document.getElementById('loop').value;

							url = '<?= app_url() . 'pages/export/kartu-persediaan.php?loop=' ?>' + loop;
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

				<div class="row">
					<table border="1" width="100%">
						<tr>
							<td colspan="10" style="text-align: center;">
								<h2>
									Kartu Persediaan
								</h2>
							</td>
						</tr>
						<tr>
							<td colspan="5">
								PT. PRIMA KIMIA SURYATAMA
							</td>
							<td colspan="5" align="right">
							</td>
						</tr>
						<tr>
							<td colspan="5">
							</td>
							<td colspan="5" align="right">
								&nbsp;
							</td>
						</tr>
						<tr>
							<td rowspan="2">
								Tanggal
							</td>
							<td colspan="3" align="center">
								Masuk
							</td>
							<td colspan="3" align="center">
								Keluar
							</td>
							<td colspan="3" align="center">
								Saldo
							</td>
						</tr>
						<tr>
							<td>
								Unit
							</td>
							<td>
								Harga Satuan (Rp)
							</td>
							<td>
								Jumlah Biaya (Rp)
							</td>
							<td>
								Unit
							</td>
							<td>
								Harga Satuan (Rp)
							</td>
							<td>
								Jumlah Biaya (Rp)
							</td>
							<td>
								Unit
							</td>
							<td>
								Harga Satuan (Rp)
							</td>
							<td>
								Jumlah Biaya (Rp)
							</td>
						</tr>
						<?php
						$jumlahLoop = 1;
						if (isset($_GET['loop'])) {
							$jumlahLoop = $_GET['loop'] == '' ? 1 : $_GET['loop'];
						}
						for ($i = 0; $i < $jumlahLoop; $i++) :
						?>
							<tr>
								<td>&nbsp;<br>&nbsp;<br>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						<?php endfor; ?>

						<!-- total -->
						<tr>
							<td align="center"><b>Total</b></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</table>
				</div>

			</div>
		</div>
	</div>
</section>