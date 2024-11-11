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
            <button class="btn btn-primary mb-3" onclick="window.location.href='<?= base_url('home/t_sm') ?>'">Tambah Data Surat Masuk</button>

            <!-- Search Input -->
            <div class="search-container">
                <input type="text" id="searchInput" class="form-control" placeholder="Search..." onkeyup="filterTable()">
            </div>

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
                                <a href="javascript:void(0);" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal" onclick="editData('<?= $kin->id_sm ?>', '<?= $kin->nomor_surat ?>', '<?= $kin->tujuan ?>', '<?= $kin->tanggal_terima ?>', '<?= $kin->status ?>', '<?= $kin->perihal ?>', '<?= $kin->file ?>')">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= base_url('home/h_sm/' . $kin->id_sm) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <!-- View File Button -->
                                <?php if (!empty($kin->file)) { ?>
                                <a href="<?= base_url('img/' . $kin->file) ?>" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat File
                                </a>
                                <!-- Print Button -->
                                <a href="<?= base_url('home/printFile/' . $kin->id_sm) ?>" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-print"></i>
                                </a>
                                <?php } else { ?>
                                <span class="text-muted">No File</span>
                                <?php } ?>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Surat Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('home/aksi_e_sm') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id_sm">
                        <input type="hidden" id="existingFile" name="existing_file"> <!-- Hidden input for current file -->

                        <div class="form-group">
                            <label for="editNomorSurat">Nomor Surat</label>
                            <input type="text" class="form-control" id="editNomorSurat" name="nomor_surat">
                        </div>
                        <div class="form-group">
                            <label for="editTanggalSurat">Tujuan</label>
                            <input type="text" class="form-control" id="editTanggalSurat" name="tujuan">
                        </div>
                        <div class="form-group">
                            <label for="editTanggalTerima">Tanggal Terima</label>
                            <input type="date" class="form-control" id="editTanggalTerima" name="tanggal_terima">
                        </div>
                        <div class="form-group">
                            <label for="editPerihal">Perihal</label>
                            <input type="text" class="form-control" id="editPerihal" name="perihal">
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="dikirim">Dikirim</option>
                                <option value="dibaca">Dibaca</option>
                                <option value="belum_dibaca">Belum Dibaca</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editFile">Edit File</label>
                            <input type="file" class="form-control" id="editFile" name="file">
                            <small class="form-text text-muted">Leave blank if you do not want to change the file.</small>
                        </div>
                        <div id="currentFile" style="display:none;">
                            <label>Current File:</label>
                            <span id="currentFileName"></span>
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function editData(id, nomor_surat, tanggal_surat, tanggal_terima, status, perihal, asal_surat, file) {
            document.getElementById('editId').value = id;
            document.getElementById('editNomorSurat').value = nomor_surat;
            document.getElementById('editTanggalSurat').value = tanggal_surat;
            document.getElementById('editTanggalTerima').value = tanggal_terima;
            document.getElementById('editStatus').value = status;
            document.getElementById('editPerihal').value = perihal;
            document.getElementById('editAsalSurat').value = asal_surat;

    // Set the existing file name in the hidden input
    document.getElementById('existingFile').value = file;

    // Display the current file name if a file exists
    if (file) {
        document.getElementById('currentFile').style.display = 'block';
        document.getElementById('currentFileName').textContent = file;
    } else {
        document.getElementById('currentFile').style.display = 'none';
    }
}


        // Function to filter table based on search input
        function filterTable() {
            var input = document.getElementById('searchInput');
            var filter = input.value.toLowerCase();
            var table = document.getElementById('dataTable');
            var trs = table.getElementsByTagName('tr');
            
            for (var i = 1; i < trs.length; i++) {
                var tds = trs[i].getElementsByTagName('td');
                var found = false;
                for (var j = 0; j < tds.length; j++) {
                    if (tds[j].textContent.toLowerCase().includes(filter)) {
                        found = true;
                        break;
                    }
                }
                trs[i].style.display = found ? '' : 'none';
            }
        }
    </script>
</body>
</html>
