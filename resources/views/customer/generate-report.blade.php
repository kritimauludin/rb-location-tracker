<html>

<head>
	<title>Report Customers</title>
</head>

<body>
	<style>
		.text-size-30 {
			font-size: 30px;
		}

		.users-label {
			padding: 5px;
			height: 30px;
			width: 200px;
			font-size: 25px;
		}

		.users-data {
			padding: 5px;
			height: 30px;
			width: 400px;
			font-size: 25px;
		}

		.users-data-head {
			padding: 5px;
			height: 30px;
			width: 300px;
			font-size: 25px;
			text-align: center;
		}

		table,
		th,
		td {
			border: 1px solid black;
			border-collapse: collapse;
		}
	</style>
	<div style="text-align: center;">
        <img src="assets/img/logo.png" height="50px" alt="">
		<h2 style="margin-top: 20px;">Report All Customers</h2>
	</div>
	<hr>

	<table width=100%; style="table-layout: auto; width: 100%; border-collapse: collapse; margin-top: 10px; margin-left: 10px;">
		<thead>
			<tr>
				<th style="font-size: 12px; text-align:center; paddding:5px">No</th>
				<th style="font-size: 12px; text-align:center; paddding:5px">Kode Pelanggan</th>
				<th style="font-size: 12px; text-align:center; paddding:5px">Nama Pelanggan</th>
				<th style="font-size: 12px; text-align:center; paddding:5px">Tgl. Join</th>
				<th style="font-size: 12px; text-align:center; paddding:5px">Tgl. Expire</th>
				<th style="font-size: 12px; text-align:center; paddding:5px">Total</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			<?php foreach ($customers as $customer) : ?>
				<tr style="font-size: 12px;">
					<td style="font-size: 12px; text-align:center; paddding:5px"><?= $i++ ?></td>
					<td style="font-size: 12px; text-align:center; paddding:5px"><?= $customer['customer_code'] ?></td>
					<td style="font-size: 12px; text-align:center; paddding:5px"><?= $customer['customer_name'] ?></td>
					<td style="font-size: 12px; text-align:center; paddding:5px"><?= $customer['join_date'] ?></td>
					<td style="font-size: 12px; text-align:center; paddding:5px"><?= $customer['expire_date'] ?></td>
					<td style="font-size: 12px; text-align:center; paddding:5px"><?= $customer['amount'] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<br>
	<br>
	<br>
	<br>
	<div>
<table class="TabelTandaTangan" style="text-align: center; font-size=15px; margin-left: 850px;">
	<?php
	echo '
		  <tr>
		  	<td>
			   <p>Mengetahui, </p>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
			  <p>_____________________________________</p>
			  <p><b>Ttd. Minimal Asst. Mgr.</b></p>
			</td>
		</tr>';
	?>
</table>
</div>

</body>

</html>
