<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Surat Masuk</title>
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
                <h3 class="text-center mb-4">Tambah Data Surat Keluar</h3>
                <form action="<?= base_url('home/aksi_t_sk') ?>" method="POST" enctype="multipart/form-data">
                    <!-- Asal Surat -->
                    <div class="form-group">
                        <label for="asal_surat">Nomor Surat</label>
                        <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" required>
                    </div>

                    <!-- Nomor Surat -->
                    <div class="form-group">
                        <label for="nomor_surat">Perihal</label>
                        <input type="text" class="form-control" id="perihal" name="perihal" required>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="nomor_surat">Email</label>
                        <input type="text" class="form-control" id="perihal" name="email" required>
                    </div>

                    <!-- Tanggal Surat -->
                    <div class="form-group">
                        <label for="tanggal_surat">Tujuan</label>
                        <input type="text" class="form-control" id="tujuan" name="tujuan" required>
                    </div>

                    <!-- Tanggal Terima -->
                    <div class="form-group">
                        <label for="tanggal_terima">Tanggal Kirim</label>
                        <input type="date" class="form-control" id="tanggal_kirim" name="tanggal_kirim" required>
                    </div>
                    
                    <!-- Status -->
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="diproses">Diproses</option>
                            <option value="dibaca">Dibaca</option>
                        </select>
                    </div>
                    
                    <!-- File Upload -->
                    <div class="form-group">
                        <label for="file">File</label>
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
