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
                if(session()->get('level')=='1' || session()->get('level')=='2'){
                  ?>
            <!-- Button to Add New Data -->
            <button class="btn btn-primary mb-3" onclick="window.location.href='<?= base_url('home/t_raport') ?>'">Tambah Data Dokumen Raport</button>
            <?php } ?>

            <!-- Search Bar for Table 1 -->
            <div class="search-container">
                <input type="text" id="searchInput" class="form-control" placeholder="Search..." onkeyup="searchTable('dataTable')">
            </div>

            <!-- Table 1 -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">NIS Siswa</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Blok</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Nilai Keseluruhan</th>
                            <th scope="col">Nilai Ekstrakurikuler</th>
                            <?php
                if(session()->get('level')=='1' || session()->get('level')=='2'){
                  ?>
                            <th scope="col">Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            foreach ($jel as $data) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data->nis_siswa ?></td>
                                <td><?= $data->kelas ?></td>
                                <td><?= $data->blok ?></td>
                                <td><?= $data->semester ?></td>
                                <td><?= $data->nilai_keseluruhan ?></td>
                                <td><?= $data->nilai_ekstrakurikuler ?></td>
                                <?php
                if(session()->get('level')=='1' || session()->get('level')=='2'){
                  ?>
                                <td>
                                    <?php if (!empty($data->file)) { ?>
                                    <a href="<?= base_url('img/' . $data->file) ?>" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View File
                                    </a>
                                    <?php } else { ?>
                                    <span class="text-muted">No File</span>
                                    <?php } ?>
                                    <?php if (!empty($data->file)) { ?>
                                <a href="<?= base_url('home/printFileRaport/' . $data->id_raport) ?>" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-print"></i>
                                </a>
                                <?php } ?>
                                    <button class="btn btn-sm btn-warning" onclick="openEditModal(<?= htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8') ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="<?= base_url('home/h_raport/' . $data->id_raport) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Space Between Tables -->
                <div class="mt-5"></div>

                <?php
                if(session()->get('level')=='1' || session()->get('level')=='2'){
                  ?>
                <!-- Button to Add New Data -->
                <button class="btn btn-primary mb-3" onclick="window.location.href='<?= base_url('home/t_alumni') ?>'">Tambah Data Dokumen Alumni</button>
                <?php } ?>

                <!-- Search Bar for Table 2 -->
                <div class="search-container">
                    <input type="text" id="searchInput2" class="form-control" placeholder="Search..." onkeyup="searchTable('dataTable2')">
                </div>

                <!-- Table 2 (Identical to the First Table) -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable2">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">NIS Alumni</th>
                                <th scope="col">Tahun Lulus</th>
                                <th scope="col">Jurusan</th>
                                <th scope="col">IPK</th>
                                <?php
                if(session()->get('level')=='1' || session()->get('level')=='2'){
                  ?>
                                <th scope="col">Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach ($jel2 as $pudding) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $pudding->nis_alumni ?></td>
                                    <td><?= $pudding->tahun_lulus ?></td>
                                    <td><?= $pudding->jurusan ?></td>
                                    <td><?= $pudding->ipk ?></td>
                                    <?php
                if(session()->get('level')=='1' || session()->get('level')=='2'){
                  ?>
                                    <td>
                                        <?php if (!empty($pudding->file)) { ?>
                                        <a href="<?= base_url('img/' . $pudding->file) ?>" target="_blank" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View File
                                        </a>
                                        <?php } else { ?>
                                        <span class="text-muted">No File</span>
                                        <?php } ?>
                                        <button class="btn btn-sm btn-warning" onclick="openEditModalAlumni(<?= htmlspecialchars(json_encode($pudding), ENT_QUOTES, 'UTF-8') ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <a href="<?= base_url('home/h_alumni/' . $pudding->id_alumni) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                         <?php if (!empty($pudding->file)) { ?>
                                <a href="<?= base_url('home/printFileAlumni/' . $pudding->id_alumni) ?>" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-print"></i>
                                </a>
                                <?php } ?>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <script>
            function openEditModalAlumni(data) {
                $('#edit_id_alumni').val(data.id_alumni);
                $('#edit_nis_alumni').val(data.nis_alumni);
                $('#edit_tahun_lulus').val(data.tahun_lulus);
                $('#edit_jurusan').val(data.jurusan);
                $('#edit_ipk').val(data.ipk);
                $('#existing_file_alumni').val(data.file); // Populate with existing file
                $('#editModalAlumni').modal('show');
            }

            function openEditModal(data) {
                $('#edit_id_raport').val(data.id_raport);
                $('#edit_nis_siswa').val(data.nis_siswa);
                $('#edit_kelas').val(data.kelas);
                $('#edit_blok').val(data.blok);
                $('#edit_semester').val(data.semester);
                $('#edit_nilai_keseluruhan').val(data.nilai_keseluruhan);
                $('#edit_nilai_ekstrakurikuler').val(data.nilai_ekstrakurikuler);
                $('#existing_file').val(data.file); // Populate with existing file
                $('#editModal').modal('show');
            }

            function searchTable(tableId) {
                const input = document.getElementById(tableId === 'dataTable' ? 'searchInput' : 'searchInput2');
                const filter = input.value.toUpperCase();
                const table = document.getElementById(tableId);
                const rows = table.getElementsByTagName('tr');

                for (let i = 1; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let found = false;
                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j] && cells[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                    rows[i].style.display = found ? "" : "none";
                }
            }
        </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
