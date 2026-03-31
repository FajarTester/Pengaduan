# Aplikasi Pengaduan - Frontend PHP

Frontend web untuk aplikasi sistem pengaduan siswa, dibangun dengan PHP dan Bootstrap 5.

## Setup & Installation

### Prerequisites

- PHP 7.4 atau lebih tinggi
- Composer
- Go Backend API running di `http://localhost:8080`

### Install Dependencies

```bash
cd frontend
composer install
```

### Environment Setup

Buat/update file `.env` di folder frontend:

```
SUPABASE_URL="https://your-supabase-url"
SUPABASE_ANON_KEY="your-anon-key"
API_BASE_URL="http://localhost:8080"
```

**Note**: ENV variables sudah disediakan, update hanya jika diperlukan.

### Run Development Server

```bash
php -S localhost:8000
```

Buka browser di `http://localhost:8000`

## Project Structure

```
frontend/
├── index.php           # Entry point / Router
├── .env                # Environment variables
├── controllers/
│   ├── Auth.php        # Auth logic
│   └── Pengaduan.php   # Report logic
├── models/
│   ├── Auth.php        # Auth model
│   ├── Siswa.php       # Student model
│   ├── Kategori.php    # Category model
│   ├── Aspirasi.php    # Aspiration model
│   ├── InputAspirasi.php # Report model
│   └── Pengaduan.php   # Pengaduan alias
├── views/
│   ├── Login.php       # Login view
│   ├── Register.php    # Register view
│   ├── Pengaduan.php   # Report view
│   └── AdminPengaduan.php # Admin dashboard
├── plugins/
│   └── supabase.php    # API client (cURL)
└── vendor/             # Composer dependencies
```

## Features

### User Roles

1. **Admin** - Login dengan username/password
2. **Siswa (Student)** - Login dengan NIS

### Siswa Features

- Login dengan NIS
- Lihat daftar pengaduan mereka
- Buat pengaduan baru
- Kategori pengaduan

### Admin Features

- Login dengan username & password
- Lihat semua pengaduan dari siswa
- Update status pengaduan (Menunggu, Proses, Selesai)
- Berikan feedback/komentar

## How It Works

### Flow Diagram

```
PHP Frontend (cURL)
       ↓
Go API Server (HTTP)
       ↓
PostgreSQL Database (Supabase)
```

### Request Flow

1. **Frontend** mengirim HTTP request menggunakan cURL
2. **Go API** memproses request dan berinteraksi dengan database
3. **Response** dikembalikan dalam format JSON
4. **Frontend** menampilkan data ke view

## API Client Usage

Semua komunikasi dengan API dilakukan melalui `plugins/supabase.php`:

```php
// Simple GET request
$response = api_request('GET', 'siswa/123456789');

// POST request dengan payload
$payload = ['nis' => 123456789, 'kelas' => 'X-A'];
$response = api_request('POST', 'siswa', $payload);
```

## Pages

### Public Pages

- `/` atau `?page=login` - Login page (both admin & siswa)
- `?page=register` - Admin registration page

### Protected Pages (Require Login)

- `?page=pengaduan` - Siswa dashboard & report form
- `?page=admin` - Admin dashboard

### Actions

- `?page=login&action=...` - Various auth actions
- `?page=pengaduan&action=create` - Create new report
- `?page=admin&action=update` - Update report status

## Usage Guide

### Siswa Login

1. Go to login page
2. Enter your NIS (only numbers)
3. Click Login
4. View and create pengaduan

### Admin Login

1. Go to login page
2. Enter username
3. Enter password
4. Click Login
5. View all pengaduan and manage status

### Admin Register

1. Go to register page
2. Enter username & password
3. Click Register
4. Login dengan credentials baru

## Response Format from API

All responses follow this format:

```json
{
    "success": true|false,
    "message": "Description",
    "data": {} or []
}
```

## Error Handling

- Network errors are caught and displayed
- Database errors return appropriate HTTP status codes
- Invalid requests return 400 Bad Request
- Not found returns 404 Not Found
