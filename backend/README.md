# Aplikasi Pengaduan - Go Backend API

API backend untuk aplikasi sistei pengaduan siswa, dibangun dengan Go dan PostgreSQL.

## Setup & Installation

### Prerequisites

- Go 1.25.0 atau lebih tinggi
- PostgreSQL dengan database yang sudah dibuat
- Supabase account (atau PostgreSQL lainnya)

### Database Setup

Jalankan SQL queries berikut untuk membuat tabel:

```sql
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

-- 4. Tabel Aspirasi (Status & Feedback)
CREATE TABLE aspirasi (
    id_aspirasi SERIAL PRIMARY KEY,
    status TEXT CHECK (status IN ('Menunggu', 'Proses', 'Selesai')) DEFAULT 'Menunggu',
    id_kategori INT REFERENCES kategori(id_kategori),
    feedback TEXT
);

-- 5. Tabel Input_Aspirasi (Tabel Utama Laporan)
CREATE TABLE input_aspirasi (
    id_pelaporan SERIAL PRIMARY KEY,
    nis BIGINT REFERENCES siswa(nis),
    id_kategori INT REFERENCES kategori(id_kategori),
    lokasi VARCHAR(50),
    ket VARCHAR(50)
);
```

### Environment Setup

Buat file `.env` di folder backend:

```
DB_HOST=localhost
DB_PORT=5432
DB_USER=postgres
DB_PASSWORD=your_password
DB_NAME=pengaduan
API_PORT=8080
```

### Install Dependencies

```bash
cd backend
go mod tidy
```

### Run API Server

```bash
go run main.go
```

API akan berjalan di `http://localhost:8080`

## API Endpoints

### Authentication

- `POST /api/auth/login` - Admin login
- `POST /api/auth/register` - Admin registration

### Siswa (Students)

- `GET /api/siswa` - Get all students
- `GET /api/siswa/{nis}` - Get student by NIS
- `POST /api/siswa` - Create new student

### Kategori (Categories)

- `GET /api/kategori` - Get all categories
- `POST /api/kategori` - Create new category

### Aspirasi (Aspirations/Status)

- `GET /api/aspirasi` - Get all aspirations
- `GET /api/aspirasi/{id}` - Get aspiration by ID
- `POST /api/aspirasi` - Create new aspiration
- `PUT /api/aspirasi/{id}` - Update aspiration status and feedback

### Pengaduan (Reports)

- `GET /api/pengaduan` - Get all reports
- `GET /api/pengaduan/{id}` - Get report by ID
- `GET /api/pengaduan/siswa/{nis}` - Get reports by student NIS
- `POST /api/pengaduan` - Create new report
- `PUT /api/pengaduan/{id}` - Update report
- `DELETE /api/pengaduan/{id}` - Delete report

## Request/Response Format

### Login Request

```json
{
    "username": "admin",
    "password": "password123"
}
```

### Create Report Request

```json
{
    "nis": 123456789,
    "id_kategori": 1,
    "lokasi": "Ruang Kelas",
    "ket": "Deskripsi pengaduan"
}
```

### Response Format

```json
{
    "success": true,
    "message": "Operation successful",
    "data": {}
}
```

## Project Structure

```
backend/
├── main.go              # Entry point
├── go.mod              # Dependencies
├── .env                # Environment variables
├── database/
│   └── db.go           # Database connection
├── models/
│   └── models.go       # Data models
└── handlers/
    ├── auth.go         # Auth handlers
    ├── siswa.go        # Siswa handlers
    ├── kategori.go     # Kategori handlers
    ├── aspirasi.go     # Aspirasi handlers
    └── pengaduan.go    # Pengaduan handlers
```
