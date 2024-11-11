<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Surat Lamaran</title>
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
            transform: translateX(-250px);
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
        
        .form-container {
            margin-top: 50px;
            max-width: 500px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

    <div class="content" id="content">
        <div class="container mt-5">
            <div class="form-container">
                <h3 class="text-center mb-4">Tambah Data Raport</h3>
                <form action="<?= base_url('home/aksi_t_raport') ?>" method="POST" enctype="multipart/form-data">
                    
                    <!-- Input for NIS Siswa -->
                    <div class="form-group">
                        <label for="nis_siswa">NIS Siswa</label>
                        <input type="number" class="form-control" id="nis_siswa" name="nis_siswa" required>
                    </div>

                    <!-- Input for Kelas -->
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" required>
                    </div>

                    <!-- Input for Blok -->
                    <div class="form-group">
                        <label for="blok">Blok</label>
                        <input type="text" class="form-control" id="blok" name="blok" required>
                    </div>

                    <!-- Input for Semester -->
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <input type="text" class="form-control" id="semester" name="semester" required>
                    </div>

                    <!-- Input for Nilai Keseluruhan -->
                    <div class="form-group">
                        <label for="nilai_keseluruhan">Nilai Keseluruhan</label>
                        <input type="number" class="form-control" id="nilai_keseluruhan" name="nilai_keseluruhan" required>
                    </div>

                    <!-- Input for Nilai Ekstrakurikuler -->
                    <div class="form-group">
                        <label for="nilai_ekstrakurikuler">Nilai Ekstrakurikuler</label>
                        <input type="number" class="form-control" id="nilai_ekstrakurikuler" name="nilai_ekstrakurikuler" required>
                    </div>

                    <!-- File Upload -->
                    <div class="form-group">
                        <label for="file">File Surat Lamaran</label>
                        <input type="file" class="form-control-file" id="file" name="file">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
