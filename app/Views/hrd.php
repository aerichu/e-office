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
        .second-table {
            margin-top: 40px; /* Adjust this value if needed */
        }
    </style>
</head>
<body>

    <div class="content" id="content">
        <div class="container mt-4">

            <?php
                if(session()->get('level')=='1' || session()->get('level')=='5' ){
                  ?>
            <!-- Button to Add New User -->
            <button class="btn btn-primary mb-3" onclick="window.location.href='<?= base_url('home/t_cuti') ?>'">Tambah Data Surat Cuti</button>
            <?php } ?>

            <!-- Search Bar for First Table -->
            <input type="text" id="searchInputFirstTable" class="form-control mb-3" placeholder="Search...">

            <!-- First Table -->
            <div class="table-responsive">
                <table class="table table-bordered" id="firstTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">File Pengajuan Cuti</th>
                            <th scope="col">Nama Pengaju</th>
                            <th scope="col">Tanggal Pengajuan</th>
                            <?php
                if(session()->get('level')=='1' || session()->get('level')=='5' ){
                  ?>
                            <th scope="col">Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($jel as $kin) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $kin->file ?></td>
                            <td><?= $kin->nama ?></td>
                            <td><?= $kin->tanggal ?></td>
                            <?php
                if(session()->get('level')=='1' || session()->get('level')=='5' ){
                  ?>
                            <td>
                                <a href="<?= base_url('home/h_cuti/' . $kin->id_cuti) ?>" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $kin->id_cuti ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <?php if (!empty($kin->file)) { ?>
                                <a href="<?= base_url('home/printFileCuti/' . $kin->id_cuti) ?>" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-print"></i>
                                </a>
                                <a href="<?= base_url('img/' . $kin->file) ?>" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat File
                                </a>
                                <?php } else { ?>
                                <span class="text-muted">No File</span>
                                <?php } ?>
                            </td>
                            <?php } ?>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $kin->id_cuti ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $kin->id_cuti ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel<?= $kin->id_cuti ?>">Edit Data Surat Cuti</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="<?= base_url('home/aksi_e_cuti/' . $kin->id_cuti) ?>" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="nama" class="form-control-file" id="nama" name="nama">
                                            </div>
                                            <div class="form-group">
                                                <label for="file">File</label>
                                                <input type="file" class="form-control-file" id="file" name="file">
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

            <?php
                if(session()->get('level')=='1' || session()->get('level')=='5' ){
                  ?>
            <!-- Button to Add New User -->
            <button class="btn btn-primary mb-3" onclick="window.location.href='<?= base_url('home/t_lamar') ?>'">Tambah Data Surat Lamaran</button>
            <?php } ?>

            <!-- Search Bar for Second Table -->
            <input type="text" id="searchInputSecondTable" class="form-control mb-3" placeholder="Search...">

            <!-- Second Table -->
            <div class="table-responsive second-table">
                <table class="table table-bordered" id="secondTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Pelamar</th>
                            <th scope="col">Posisi</th>
                            <th scope="col">Pendidikan Terakhir</th>
                            <th scope="col">Pengalaman Kerja</th>
                            <th scope="col">Tanggal Melamar</th>
                            <?php
                if(session()->get('level')=='1' || session()->get('level')=='5' ){
                  ?>
                            <th scope="col">Actions</th>
                            <?php } ?>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($aria as $savana) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $savana->nama_pelamar ?></td>
                            <td><?= $savana->posisi ?></td>
                            <td><?= $savana->pendidikan ?></td>
                            <td><?= $savana->pengalaman_kerja ?></td>
                            <td><?= $savana->tanggal_melamar ?></td>
                            <?php
                if(session()->get('level')=='1' || session()->get('level')=='5' ){
                  ?>
                            <td>
                                <a href="<?= base_url('home/h_lamar/' . $savana->id_lamar) ?>" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>

                                <!-- Edit Button -->
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal" 
                                data-id="<?= $savana->id_lamar ?>" 
                                data-nama="<?= $savana->nama_pelamar ?>" 
                                data-posisi="<?= $savana->posisi ?>" 
                                data-pendidikan="<?= $savana->pendidikan ?>" 
                                data-pengalaman="<?= $savana->pengalaman_kerja ?>" 
                                data-tanggal="<?= $savana->tanggal_melamar ?>"
                                data-status="<?= $savana->status ?>"
                                data-file="<?= $savana->file ?>">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- View File Button -->
                            <?php if (!empty($savana->file)) { ?>
                            <a href="<?= base_url('img/' . $savana->file) ?>" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> View File
                            </a>
                            <?php } else { ?>
                            <span class="text-muted">No File</span>
                            <?php } ?>
                        </td>
                        <?php } ?>
                        <td><?= $savana->status ?></td>
                    </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Lamaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('home/aksi_e_lamar') ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <!-- Hidden ID -->
                            <input type="hidden" name="id_lamar" id="edit-id_lamar">

                            <div class="form-group">
                                <label for="edit-nama_pelamar">Nama Pelamar</label>
                                <input type="text" class="form-control" id="edit-nama_pelamar" name="nama_pelamar">
                            </div>

                            <div class="form-group">
                                <label for="edit-posisi">Posisi</label>
                                <input type="text" class="form-control" id="edit-posisi" name="posisi">
                            </div>

                            <div class="form-group">
                                <label for="edit-pendidikan">Pendidikan Terakhir</label>
                                <input type="text" class="form-control" id="edit-pendidikan" name="pendidikan">
                            </div>

                            <div class="form-group">
                                <label for="edit-pengalaman">Pengalaman Kerja</label>
                                <input type="text" class="form-control" id="edit-pengalaman" name="pengalaman_kerja">
                            </div>

                            <div class="form-group">
                                <label for="edit-tanggal">Tanggal Melamar</label>
                                <input type="date" class="form-control" id="edit-tanggal" name="tanggal_melamar">
                            </div>

                            <div class="form-group">
                                <label for="edit-status">Status</label>
                                <input type="text" class="form-control" id="edit-status" name="status">
                            </div>

                            <!-- File Upload -->
                            <div class="form-group">
                                <label for="edit-file">Upload File (Optional)</label>
                                <input type="file" class="form-control" id="edit-file" name="file">
                                <!-- If there's an existing file, show it -->
                                <input type="hidden" name="existing_file" id="existing-file">
                                <div id="existing-file-display"></div>
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


        <script>
            $(document).ready(function() {
                // Search filter for the first table
                $('#searchInputFirstTable').on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    $('#firstTable tbody tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });

                // Search filter for the second table
                $('#searchInputSecondTable').on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    $('#secondTable tbody tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });
            });
        </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
