<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Table</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        /* Sidebar styling */
        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #343a40;
            color: #fff;
            transition: transform 0.3s ease;
        }
        .sidebar.hidden {
            transform: translateX(-250px);
        }
        .content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }
        .content.shifted {
            margin-left: 0;
        }
        .table-responsive {
            margin-top: 30px;
        }
        .search-container {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <!-- Sidebar & Content -->
    <div class="content" id="content">
        <div class="container mt-4">
            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Actions</th>
                            <th scope="col">Nomor Surat</th>
                            <th scope="col">Tujuan</th>
                            <th scope="col">Tanggal Terima</th>
                            <th scope="col">Status</th>
                            <th scope="col">Perihal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($jel as $kin) { ?>
                        <tr>
                            <td>
                                <a href="<?= base_url('home/aksi_restore/' . $kin->id_sm) ?>" class="btn btn-danger btn-sm mt-2">
                                            <i class="fas fa-trash"></i> Restore
                                        </a>
                            </td>
                            <td><?= $kin->nomor_surat ?></td>
                            <td><?= $kin->tujuan ?></td>
                            <td><?= $kin->tanggal_terima ?></td>
                            <td><?= $kin->status ?></td>
                            <td><?= $kin->perihal ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    