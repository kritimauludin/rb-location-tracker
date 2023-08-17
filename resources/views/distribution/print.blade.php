<html>
<head>
	<title><?= $title ?></title>
	<style>
		.text-bold {
			font-weight: bold;
			display: inline;
		}
		.text-center {
			text-align: center;
		}
	</style>
</head>
<body>
<div style="text-align: center;">
	<h5 style="margin-top: 0px;">Alokasi Distribusi - {{ $distribution->distribution_code }}</h5>
</div>

<div style="text-align: center;">
	<h5 style="margin: 0px;">Data Distribusi</h5>
</div>
<hr>

<table width="100%" style="font-size: 12px;">
	<tr>
		<td><p>Kode Distribusi : <?= $distribution->distribution_code;?></p></td>
		<td><p>Tgl. Distribusi : <?= $distribution->created_at;?></p></td>
		<td><p>Koran Dibawa : <?= $distribution->total_newspaper;?></p></td>
	</tr>
</table>
<hr>

<div style="text-align: center;">
	<h5 style="margin: 0px;">Data Pengirim/Kurir</h5>
</div>
<hr>

<table width="100%" style="font-size: 12px;">
	<tr>
		<td><p>Kode Kurir : <?= $distribution->courier->user_code;?></p></td>
		<td><p>Tgl. Distribusi : <?= $distribution->courier->name;?></p></td>
		<td><p>No. Telpon : <?= $distribution->courier->phone_number;?></p></td>
		<td><p>Email : <?= $distribution->courier->email;?></p></td>
	</tr>
</table>
<hr>


<div style="text-align: center;">
	<h5 style="margin: 0px;">List Pelanggan</h5>
</div>
<hr>

<div>
<table id="TabelTampilData" style="table-layout: auto; width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px;">
	<thead align="center">
		<tr style="text-align: center; font-size: 15px;">
			<th style="background-color: #F5F5F5; color: black; padding: 5px; border-bottom: 1px solid #ddd; height: 30px; width=10px;">No</th>
			<th style="background-color: #F5F5F5; color: black; padding: 5px; border-bottom: 1px solid #ddd; height: 30px; width=150px;">Kode Pelanggan</th>
			<th style="background-color: #F5F5F5; color: black; padding: 5px; border-bottom: 1px solid #ddd; height: 30px; width=150px;">Nama Pelanggan</th>
			<th style="background-color: #F5F5F5; color: black; padding: 5px; border-bottom: 1px solid #ddd; height: 30px; width=100px;">No Hp</th>
			<th style="background-color: #F5F5F5; color: black; padding: 5px; border-bottom: 1px solid #ddd; height: 30px; width=200px;">Email</th>
			<th style="background-color: #F5F5F5; color: black; padding: 5px; border-bottom: 1px solid #ddd; height: 30px; width=100px;">Total</th>
		</tr>
	</thead>
	<tbody style="font-size:10px;">
	<?php $Nomor	= 1;?>
	<?php foreach($distribution->user_distribution as $user_distribution) : ?>
				<tr>
					<td style="padding: 5px; border-bottom: 1px solid #ddd; text-align: center; width=10px;"><?=$Nomor++;?></td>
					<td style="padding: 5px; border-bottom: 1px solid #ddd; text-align: center; width=250px;"><?= $user_distribution->customer_code; ?></td>
					<td style="padding: 5px; border-bottom: 1px solid #ddd; width=100px;"><?= $user_distribution->customer->customer_name; ?></td>
					<td style="padding: 5px; border-bottom: 1px solid #ddd; text-align: center; width=185px;"><?= $user_distribution->customer->phone_number;?></td>
					<td style="padding: 5px; border-bottom: 1px solid #ddd; text-align: center; width=180px;"><?= $user_distribution->customer->email;?></td>
					<td style="padding: 5px; border-bottom: 1px solid #ddd; text-align: center; width=180px;"><?= $user_distribution->total;?></td>
				</tr>
	<?php endforeach;?>
	</tbody>
</table>
</div>

<hr>
<div style="text-align: center;">
	<h5 style="margin: 0px;">Dept. Penerbit & Mgt Dev.</h5>
</div>
<hr>

<table width="100%" style="font-size: 12px;">
  <tr>
	<th style="background-color: #F5F5F5; color: black; padding: 3px;"  align="left"><p>(4) Keterangan Verifikasi : Lampiran : Ada / Tidak, Tanggal : ______ /______ /_____________ </p></th>
  </tr>
</table>

</body>
</html>
