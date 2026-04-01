<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa - Aplikasi Aspirasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 450px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .register-header h2 {
            color: #333;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .register-header p {
            color: #999;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .info-box {
            background: #f0f5ff;
            border-left: 4px solid #667eea;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-header">
            <h2>📝 Daftar Siswa</h2>
            <p>Buat akun baru untuk menggunakan aplikasi aspirasi</p>
        </div>

        <div class="info-box">
            📌 <strong>Info:</strong> Pastikan NIS dan Kelas Anda sesuai dengan data di sekolah
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
                <br><small>Anda akan diarahkan ke halaman login...</small>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=register_siswa">
            <div class="form-group">
                <label for="nis" class="form-label">Nomor Induk Siswa (NIS) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nis" name="nis" placeholder="Masukkan NIS Anda" required>
                <small class="form-text text-muted">Contoh: 1234567890</small>
            </div>

            <div class="form-group">
                <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                <select class="form-select" id="kelas" name="kelas" required>
                    <option value="">-- Pilih Kelas --</option>
                    <option value="10A">10A</option>
                    <option value="10B">10B</option>
                    <option value="10C">10C</option>
                    <option value="11A">11A</option>
                    <option value="11B">11B</option>
                    <option value="11C">11C</option>
                    <option value="12A">12A</option>
                    <option value="12B">12B</option>
                    <option value="12C">12C</option>
                </select>
            </div>

            <div class="form-group">
                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username"
                    required>
                <small class="form-text text-muted">Contoh: Nomeri Uno</small>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                <small class="form-text text-muted">Contoh: example@example.com</small>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Masukkan password" required>
                <small class="form-text text-muted">Contoh: NumeriUno2332</small>
            </div>

            <button type="submit" class="btn btn-register">Daftar Akun</button>
        </form>

        <div class="register-link">
            Sudah punya akun? <a href="index.php?page=login&role=siswa">Login di sini</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>