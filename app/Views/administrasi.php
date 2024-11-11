<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrasi Table</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
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
            <?php
                if(session()->get('level')=='1' || session()->get('level')=='4' ){
                ?>
                <!-- Button to Add New Data -->
                <button class="btn btn-primary mb-3" onclick="window.location.href='<?= base_url('home/t_admin') ?>'">Tambah Data Dokumen Pembayaran</button>
                <?php } ?>

                <!-- Search Bar -->
                <div class="search-container">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search..." onkeyup="searchTable()">
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Asal Surat</th>
                                <th scope="col">Tanggal Surat</th>
                                <th scope="col">Tujuan</th>
                                <th scope="col">File</th>
                                <?php
                                    if(session()->get('level')=='1' || session()->get('level')=='4' ){
                                    ?>
                                    <th scope="col">Actions</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; // Initialize the counter ?>
                                <?php foreach ($jel as $data) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data->asal_surat ?></td>
                                    <td><?= $data->tanggal_surat ?></td>
                                    <td><?= $data->tujuan ?></td>
                                    <?php
                                        if(session()->get('level')=='1' || session()->get('level')=='4' ){
                                        ?>
                                        <td>
                                            <?php if (!empty($data->file)) { ?>
                                            <a href="<?= base_url('img/' . $data->file) ?>" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> View File
                                            </a>
                                            <?php } else { ?>
                                            <span class="text-muted">No File</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" onclick="openEditModal(<?= htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8') ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="<?= base_url('home/h_admin/' . $data->id_admin) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="<?= base_url('home/aksi_e_admin') ?>" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Data Administrasi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_admin" id="edit_id_admin">
                                    <div class="form-group">
                                        <label for="edit_asal_surat">Asal Surat</label>
                                        <input type="text" class="form-control" name="asal_surat" id="edit_asal_surat" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_tanggal_surat">Tanggal Surat</label>
                                        <input type="date" class="form-control" name="tanggal_surat" id="edit_tanggal_surat" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_tujuan">Tujuan</label>
                                        <input type="text" class="form-control" name="tujuan" id="edit_tujuan" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_file">File</label>
                                        <input type="file" class="form-control-file" name="file" id="edit_file">
                                        <small class="text-muted">Current file: <span id="current_file"></span></small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
                <script>
                    function openEditModal(data) {
                        $('#edit_id_admin').val(data.id_admin);
                        $('#edit_asal_surat').val(data.asal_surat);
                        $('#edit_tanggal_surat').val(data.tanggal_surat);
                        $('#edit_tujuan').val(data.tujuan);
                        $('#current_file').text(data.file ? data.file : 'No file uploaded');
                        $('#editModal').modal('show');
                    }

                    function searchTable() {
                        var input, filter, table, tr, td, i, j, txtValue;
                        input = document.getElementById('searchInput');
                        filter = input.value.toUpperCase();
                        table = document.getElementById('dataTable');
                        tr = table.getElementsByTagName('tr');

            // Loop through all table rows
            for (i = 1; i < tr.length; i++) {  // start from 1 to skip the header row
                let matchFound = false;
                td = tr[i].getElementsByTagName('td');

                // Check if any td contains the search query
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            matchFound = true;
                        }
                    }
                }
                
                // Display the row if a match is found
                if (matchFound) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
