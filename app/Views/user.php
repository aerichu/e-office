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

        /* Styling for when the sidebar is hidden */
        .sidebar.hidden {
            transform: translateX(-250px); /* Geser sidebar ke kiri */
        }

        /* Content styling to shift right when sidebar is visible */
        .content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        /* Styling when sidebar is hidden */
        .content.shifted {
            margin-left: 0;
        }
        
        .table-responsive {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="content" id="content">
        <div class="container mt-4">
            <?php
                if(session()->get('level')=='1' ){
                ?>
                <!-- Button to Add New User -->
                <button class="btn btn-primary mb-3" onclick="window.location.href='<?= base_url('home/t_user') ?>'">Tambah Data User</button>
                <?php } ?>
                
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                                <th scope="col">Level</th>
                                <?php
                                    if(session()->get('level')=='1' || session()->get('level')=='4' ){
                                    ?>
                                    <th scope="col">Actions</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($jel as $kin) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $kin->username ?></td>
                                    <td><?= $kin->pw ?></td>
                                    <td>
                                        <?php
                                            if ($kin->level == 1) {
                                                echo "Admin";
                                            } elseif ($kin->level == 2) {
                                                echo "Kesiswaan";
                                            } elseif ($kin->level == 3) {
                                                echo "Kepala Sekolah";
                                            } elseif ($kin->level == 4) {
                                                echo "Administrasi";
                                            } elseif ($kin->level == 5) {
                                                echo "HRD";
                                            } else {
                                                echo "Unknown Level"; // Optional fallback
                                            }
                                        ?>

                                    </td>
                                    <?php
                                        if(session()->get('level')=='1' || session()->get('level')=='4' ){
                                        ?>
                                        <td>
                                            <!-- Action Buttons -->
                                            <button class="btn btn-warning btn-sm" onclick="openEditModal('<?= $kin->id_user ?>', '<?= $kin->username ?>', '<?= $kin->pw ?>', '<?= $kin->level ?>')">Edit</button>
                                            <a href="<?= base_url('home/h_user/' . $kin->id_user) ?>" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                            <a href="<?= base_url('home/aksi_reset/' . $kin->id_user) ?>" class="btn btn-warning btn-sm">
                                                <i class="fa fa-redo"></i>
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

                <!-- Modal for Editing User -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('home/aksi_e_user') ?>" method="POST">
                                <div class="modal-body">
                                    <input type="hidden" id="editUserId" name="id_user">
                                    <div class="form-group">
                                        <label for="editUsername">Username</label>
                                        <input type="text" class="form-control" id="editUsername" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editPassword">Password</label>
                                        <input type="password" class="form-control" id="editPassword" name="pw" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="level">Level</label>
                                        <select class="form-control" id="level" name="level" required>
                                            <option value="1">Admin</option>
                                            <option value="2">Kesiswaan</option>
                                            <option value="3">Kepala Sekolah</option>
                                            <option value="4">Administrasi</option>
                                            <option value="5">HRD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
                <script>
        // Function to confirm deletion
        function confirmDelete(id) {
            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                // Redirect to delete script with the user ID
                window.location.href = 'h_user.php?id_user=' + id;
            }
        }

        // Function to reset password
        function resetPassword(id) {
            if (confirm("Apakah Anda yakin ingin mereset password pengguna ini?")) {
                // Redirect to reset password script with the user ID
                window.location.href = 'reset_password.php?id_user=' + id;
            }
        }

        function openEditModal(id, username, password, level) {
            $('#editUserId').val(id);
            $('#editUsername').val(username);
            $('#editPassword').val(password);
            $('#level').val(level);
            $('#editModal').modal('show');
        }

    </script>
</body>
</html>
