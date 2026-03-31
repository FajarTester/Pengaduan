<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Aspirasi - Aplikasi Aspirasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px;
            font-weight: 600;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-lg">
            <a class="navbar-brand fw-bold" href="#">📝 Aplikasi Aspirasi</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3 text-white">
                    <?php echo $_SESSION['user']['nis'] . " (" . $_SESSION['user']['kelas'] . ")"; ?>
                </span>
                <a class="nav-link" href="index.php?page=logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-lg my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">✏️ Edit Aspirasi</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="id_kategori" class="form-label">Kategori</label>
                                <input type="text" class="form-control"
                                    value="<?php echo $kategoriMap[$aspirasi['id_kategori']] ?? 'N/A'; ?>" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi"
                                    value="<?php echo htmlspecialchars($aspirasi['lokasi']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="ket" class="form-label">Keterangan <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="ket" name="ket" rows="5"
                                    required><?php echo htmlspecialchars($aspirasi['ket']); ?></textarea>
                            </div>

                            <div class="d-grid gap-2 d-sm-flex">
                                <a href="index.php?page=aspirasi" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>