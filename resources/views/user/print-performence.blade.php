<html>

<head>
    <title>Print Performence</title>
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
        <h2 style="margin-top: 20px;">Performence Review - <?= $_GET['courier_code'] ?></h2>
    </div>
    <hr>

    <table width=100%;
        style="table-layout: auto; width: 100%; border-collapse: collapse; margin-top: 10px; margin-left: 10px;">
        <thead>
            <tr>
                <th style="font-size: 12px; text-align:center; paddding:5px">No</th>
                <th style="font-size: 12px; text-align:center; paddding:5px">Tanggal</th>
                <th style="font-size: 12px; text-align:center; paddding:5px">Kode Pelanggan</th>
                <th style="font-size: 12px; text-align:center; paddding:5px">Jam Antar</th>
                <th style="font-size: 12px; text-align:center; paddding:5px">Jam Sampai</th>
                <th style="font-size: 12px; text-align:center; paddding:5px">Durasi Pengiriman</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $noUrut = 1;
                $nowDate = \Carbon\Carbon::now();
            ?>
            <?php for ($i = 0; $i < count($courierPerformence); $i++) : ?>
            <?php foreach ($courierPerformence[$i]['user_distribution'] as $distribution) : ?>
            <?php
            if (is_null($distribution['process_at']) || is_null($distribution['received_at']) && $nowDate->gt($distribution['created_at'])) {
                $startTime = 'Gagal Kirim';
                $finishTime = 'Gagal Kirim';
                $totalDuration = 'Gagal Kirim';
            } elseif (is_null($distribution['process_at']) || is_null($distribution['received_at'])) {
                $startTime = 'Waiting Data';
                $finishTime = 'Waiting Data';
                $totalDuration = 'Waiting Data';
            } else {
                $startTime = \Carbon\Carbon::parse($distribution['process_at']);
                $finishTime = \Carbon\Carbon::parse($distribution['received_at']);
                $totalDuration = $finishTime->diffInSeconds($startTime);
            }
            ?>
            <tr style="font-size: 12px;">
                <td style="font-size: 12px; text-align:center; paddding:5px"><?= $noUrut++ ?></td>
                <td style="font-size: 12px; text-align:center; paddding:5px">
                    <?= date('d-m-Y', strtotime($distribution['created_at'])) ?></td>
                <td style="font-size: 12px; text-align:center; paddding:5px"><?= $distribution['customer_code'] ?></td>
                <?php if (is_null($distribution['process_at']) || is_null($distribution['received_at'])) : ?>
                    <td style="font-size: 12px; text-align:center; paddding:5px">{{ $startTime }}</td>
                    <td style="font-size: 12px; text-align:center; paddding:5px">{{ $finishTime }}</td>
                    <td style="font-size: 12px; text-align:center; paddding:5px">{{ $totalDuration }}</td>
                <?php else : ?>
                    <td style="font-size: 12px; text-align:center; paddding:5px">{{ date('H:i:s', strtotime($startTime)) }}
                    </td>
                    <td style="font-size: 12px; text-align:center; paddding:5px">{{ date('H:i:s', strtotime($finishTime)) }}
                    </td>
                    <td style="font-size: 12px; text-align:center; paddding:5px">{{ gmdate('H:i:s', $totalDuration) }}</td>
                <?php endif;?>
            </tr>
            <?php endforeach; ?>
            <?php endfor;?>
        </tbody>
    </table>

    <br>
    <br>
    <br>
    <br>

</body>

</html>
