<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan PDF</title>
    <style>
        /* Tambahkan gaya CSS sesuai kebutuhan */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Laporan PDF</h2>
    <table>
        <thead>
            <tr>
             <th>No</th>
             <th>Tanggal Kirim</th>
             <th>Nomor Surat</th>
             <th>Status</th>
             <th>Perihal</th>
             <th>Tujuan</th>
             <th>Email</th>
         </tr>
     </thead>
     <tbody>
        <?php foreach ($laporan as $key => $row) : ?>
        <tr>
            <td><?= $key + 1 ?></td>
            <td><?= $row->tanggal_terima ?></td>
            <td><?= $row->nomor_surat ?></td>
            <td><?= $row->status ?></td>
            <td><?= $row->perihal ?></td>
            <td><?= $row->tujuan ?></td>
            <td><?= $row->email ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
