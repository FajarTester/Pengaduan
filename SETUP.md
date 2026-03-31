# Aplikasi Pengaduan - Setup Lengkap

Dokumentasi lengkap untuk setup dan menjalankan aplikasi Pengaduan dengan Go backend dan PHP frontend.

## Architecture Overview

```
┌─────────────────────────────────────────────────────────┐
│                   PHP Frontend (Port 8000)              │
│                                                           │
│  - Login/Register Interface                             │
│  - Siswa Dashboard                                       │
│  - Admin Dashboard                                       │
│  - Report Management                                     │
└─────────────────────────────────────────────────────────┘
                         ↓ (HTTP cURL)
┌─────────────────────────────────────────────────────────┐
│                    Go API (Port 8080)                    │
│                                                           │
│  - Auth Endpoints                                        │
│  - CRUD Operations                                       │
│  - Business Logic                                        │
│  - Request Validation                                    │
└─────────────────────────────────────────────────────────┘
                         ↓ (PostgreSQL)
┌─────────────────────────────────────────────────────────┐
│         PostgreSQL Database (Supabase)                   │
│                                                           │
│  - admin table                                           │
│  - siswa table                                           │
│  - kategori table                                        │
│  - aspirasi table                                        │
│  - input_aspirasi table                                  │
└─────────────────────────────────────────────────────────┘
```

## Step-by-Step Setup

### 1. Database Setup

**Buat database di Supabase atau PostgreSQL lokal:**

```sql
-- Connect ke database PostgreSQL Anda
-- Jalankan query di bawah:

-- 1. Tabel Admin
CREATE TABLE admin (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255) NOT NULL
);

-- 2. Tabel Siswa
CREATE TABLE siswa (
    nis BIGINT PRIMARY KEY,
    kelas VARCHAR(10) NOT NULL
);

-- 3. Tabel Kategori
CREATE TABLE kategori (
    id_kategori SERIAL PRIMARY KEY,
    ket_kategori VARCHAR(30) NOT NULL
);

-- 4. Tabel Aspirasi
CREATE TABLE aspirasi (
    id_aspirasi SERIAL PRIMARY KEY,
    status TEXT CHECK (status IN ('Menunggu', 'Proses', 'Selesai')) DEFAULT 'Menunggu',
    id_kategori INT REFERENCES kategori(id_kategori),
    feedback TEXT
);

-- 5. Tabel Input_Aspirasi
CREATE TABLE input_aspirasi (
    id_pelaporan SERIAL PRIMARY KEY,
    nis BIGINT REFERENCES siswa(nis),
    id_kategori INT REFERENCES kategori(id_kategori),
    lokasi VARCHAR(50),
    ket VARCHAR(50)
);

-- Insert sample data
INSERT INTO admin (username, password) VALUES
('admin', '$2y$10$...'); -- hashed password

INSERT INTO siswa (nis, kelas) VALUES
(123456789, 'X-A'),
(987654321, 'X-B');

INSERT INTO kategori (ket_kategori) VALUES
('Fasilitas'),
('Akademik'),
('Kedisiplinan'),
('Lainnya');
```

### 2. Backend Go Setup

**Pastikan Go 1.25.0+ sudah terinstall:**

```bash
# Verifikasi Go version
go version

# Navigate ke backend folder
cd backend

# Download dependencies
go mod tidy

# Update .env dengan database credentials
# Edit backend/.env:
# DB_HOST=your-host
# DB_PORT=5432
# DB_USER=postgres
# DB_PASSWORD=your_password
# DB_NAME=pengaduan
# API_PORT=8080

# Run API server
go run main.go

# Jika ingin build binary
go build -o pengaduan-api
./pengaduan-api
```

**Output yang diharapkan:**

```
API Server running on port 8080
```

### 3. Frontend PHP Setup

**Pastikan PHP 7.4+ dan Composer sudah terinstall:**

```bash
# Navigate ke frontend folder
cd frontend

# Install dependencies
composer install

# Update .env jika diperlukan
# API_BASE_URL="http://localhost:8080"

# Run development server
php -S localhost:8000

# Atau gunakan built-in server pada folder tertentu:
php -S localhost:8000 -t .
```

**Output yang diharapkan:**

```
Development Server (http://localhost:8000)
Listening on http://localhost:8000
Press Ctrl-C to quit
```

### 4. Akses Aplikasi

Buka browser dan akses:

- **Frontend**: http://localhost:8000
- **API**: http://localhost:8080/api/

## User Login Credentials

### Admin Login

- **Username**: admin
- **Password**: (sesuai yang didaftarkan)

### Siswa Login

- **NIS**: 123456789 (dari database)
- **Password**: (tidak diperlukan, cukup NIS)

## Testing API Endpoints

### Dengan cURL Command (Windows - cmd atau PowerShell)

```powershell
# Test Login Admin
curl -X POST http://localhost:8080/api/auth/login `
  -H "Content-Type: application/json" `
  -d '{\"username\":\"admin\",\"password\":\"password123\"}'

# Get All Kategori
curl http://localhost:8080/api/kategori

# Get Student by NIS
curl http://localhost:8080/api/siswa/123456789

# Create Report
curl -X POST http://localhost:8080/api/pengaduan `
  -H "Content-Type: application/json" `
  -d '{\"nis\":123456789,\"id_kategori\":1,\"lokasi\":\"Ruang Kelas\",\"ket\":\"Masalah AC\"}'
```

### Dengan Postman

1. Buka Postman
2. Create new request
3. Set method ke POST
4. URL: `http://localhost:8080/api/auth/login`
5. Set header `Content-Type: application/json`
6. Body (raw JSON):

```json
{
    "username": "admin",
    "password": "password123"
}
```

7. Click Send

## Troubleshooting

### Problem: API tidak connect ke database

**Solution:**

- Verifikasi database credentials di `.env`
- Pastikan database server running (Supabase/PostgreSQL)
- Check firewall settings
- Pastikan sslmode=require jika menggunakan Supabase

### Problem: PHP tidak bisa connect ke API

**Solution:**

- Pastikan Go API running di port 8080
- Check `API_BASE_URL` di `.env`
- Enable cURL extension di PHP: `php -m | grep curl`
- Disable SSL verification untuk development (sudah dikonfigurasi di code)

### Problem: Session tidak tersimpan

**Solution:**

- Pastikan folder `frontend` writable
- Check session path di php.ini
- Restart PHP server

### Problem: "CSRF" atau session issues

**Solution:**

- Pastikan session dimulai di awal script (di controllers)
- Clear browser cookies jika ada masalah

## Production Deployment

### Go Backend

```bash
# Build untuk production
go build -o pengaduan-api
./pengaduan-api

# Atau gunakan systemd service (Linux):
# Create pengaduan.service file
# [Unit]
# Description=Pengaduan API
# After=network.target
#
# [Service]
# User=www-data
# WorkingDirectory=/path/to/backend
# ExecStart=/path/to/backend/pengaduan-api
# Restart=on-failure
#
# systemctl enable pengaduan.service
# systemctl start pengaduan.service
```

### PHP Frontend

```bash
# Copy ke production server
# Set proper permissions:
chmod -R 755 frontend/

# Use production server like Nginx + PHP-FPM:
# nginx config untuk PHP
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/frontend;
    index index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

## Contributing

1. Buat feature branch
2. Commit changes
3. Push ke repository
4. Submit pull request

## License

Proprietary - Education Purpose

## Contact

For issues or questions, contact the development team.
