<?php
require_once __DIR__ . '/../models/AdminAspirasi.php';
require_once __DIR__ . '/../models/InputAspirasi.php';
require_once __DIR__ . '/../models/Kategori.php';

class AdminAspirasiController
{
    /**
     * Halaman utama admin — tampilkan semua pengaduan siswa + status review
     */
    public static function index(): void
    {
        // Ambil semua input pengaduan dari siswa
        $pengaduan = InputAspirasi::getAll();

        // Ambil semua data aspirasi (status + feedback dari admin)
        $aspirasi_list = AdminAspirasi::getAll();

        // Ambil kategori untuk mapping nama
        $kategori = Kategori::getAll();
        $kategoriMap = [];
        foreach ($kategori as $k) {
            $kategoriMap[$k['id_kategori']] = $k['ket_kategori'] ?? $k['nama_kategori'] ?? 'N/A';
        }

        // Index aspirasi_list by id_pelaporan agar pencarian O(1)
        $aspirasisByPelaporan = [];
        foreach ($aspirasi_list as $asp) {
            if (isset($asp['id_pelaporan'])) {
                $aspirasisByPelaporan[(int) $asp['id_pelaporan']] = $asp;
            }
        }

        // Gabungkan status & feedback ke tiap pengaduan
        foreach ($pengaduan as &$p) {
            // Default dulu
            $p['status'] = 'Menunggu';
            $p['feedback'] = '';
            $p['id_aspirasi'] = null;

            // Cari match, kalau ketemu override default
            $id = (int) $p['id_pelaporan'];
            if (isset($aspirasisByPelaporan[$id])) {
                $asp = $aspirasisByPelaporan[$id];
                $p['status'] = $asp['status'];
                $p['feedback'] = $asp['feedback'];
                $p['id_aspirasi'] = $asp['id_aspirasi'];
            }
        }
        unset($p);

        // Filter status jika ada query param ?filter_status=
        if (!empty($_GET['filter_status'])) {
            $filter = $_GET['filter_status'];
            $pengaduan = array_values(array_filter(
                $pengaduan,
                fn($item) => $item['status'] === $filter
            ));
        }

        require_once __DIR__ . '/../views/AdminAspirasi.php';
    }

    /**
     * Handler AJAX review — dipanggil dari JS fetch() di view
     * Menerima JSON body, mengembalikan JSON response
     */
    public static function reviewAspirasi(): void
    {
        header('Content-Type: application/json');

        // Baca JSON body dari fetch()
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        // Validasi field wajib
        $required = ['id_pelaporan', 'status', 'feedback', 'id_kategori'];
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                http_response_code(400);
                echo json_encode(['error' => "Field '{$field}' wajib diisi"]);
                exit;
            }
        }

        $allowedStatus = ['Menunggu', 'Proses', 'Selesai', 'Ditolak'];
        if (!in_array($data['status'], $allowedStatus)) {
            http_response_code(400);
            echo json_encode(['error' => 'Status tidak valid: ' . $data['status']]);
            exit;
        }

        $ok = AdminAspirasi::review(
            (int) $data['id_pelaporan'],
            $data['status'],
            $data['feedback'],
            (int) $data['id_kategori']
        );

        if ($ok) {
            echo json_encode(['success' => true, 'message' => 'Review berhasil disimpan']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Gagal menyimpan ke API. Cek koneksi backend.']);
        }
        exit;
    }
}