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
            <!-- Button to Add New Surat Masuk -->
            <button class="btn btn-primary mb-3" onclick="window.location.href='<?= base_url('home/t_sk') ?>'">Tambah Data Surat Keluar</button>

            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nomor Surat</th>
                            <th scope="col">Email</th>
                            <th scope="col">Perihal</th>
                            <th scope="col">Tujuan</th>
                            <th scope="col">Tanggal Kirim</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($jel as $kin) { ?>
                        <tr>
                            <td><?= $kin->nomor_surat ?></td>
                            <td><?= $kin->email ?></td>
                            <td><?= $kin->perihal ?></td>
                            <td><?= $kin->tujuan ?></td>
                            <td><?= $kin->tanggal_kirim ?></td>
                            <td><?= $kin->status ?></td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal<?= $kin->id_sk ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="<?= base_url('home/h_sk/' . $kin->id_sk) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <!-- Print Button -->
                                <a href="<?= base_url('home/printFileKeluar/' . $kin->id_sk) ?>" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-print"></i>
                                </a>
                                <!-- Gmail Link Button -->
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?=  $kin->email ?>" target="_blank" class="btn btn-sm btn-success">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                <?php if (!empty($kin->file)) { ?>
                                <a href="<?= base_url('img/' . $kin->file) ?>" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat File
                                </a>
                                <?php } ?>

                            </td>

                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $kin->id_sk ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $kin->id_sk ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel<?= $kin->id_sk ?>">Edit Surat Keluar</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="<?= base_url('home/aksi_e_sk/' . $kin->id_sk) ?>" method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nomor Surat</label>
                                                <input type="text" class="form-control" name="nomor_surat" value="<?= $kin->nomor_surat ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email" value="<?= $kin->email ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Perihal</label>
                                                <input type="text" class="form-control" name="perihal" value="<?= $kin->perihal ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Tujuan</label>
                                                <input type="text" class="form-control" name="tujuan" value="<?= $kin->tujuan ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Kirim</label>
                                                <input type="date" class="form-control" name="tanggal_kirim" value="<?= $kin->tanggal_kirim ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" name="status" required>
                                                    <option value="diproses" <?= $kin->status == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                                                    <option value="dibaca" <?= $kin->status == 'dibaca' ? 'selected' : '' ?>>Dibaca</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Upload File (optional)</label>
                                                <input type="file" class="form-control" name="file">
                                                <input type="hidden" name="existing_file" value="<?= $kin->file ?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Search Functionality Script -->
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#dataTable tbody tr');

            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
