<?php


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Kartu Persediaan.xls");
?>

<div class="content-header">
	<div class="container-fluid">

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