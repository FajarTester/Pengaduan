<?php

require_once __DIR__ . '/../models/InputAspirasi.php';
require_once __DIR__ . '/../models/Kategori.php';
require_once __DIR__ . '/../models/Aspirasi.php';

class AspirasiController
{
    public static function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        // Force no cache
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        $user_nis = $_SESSION['user']['nis'];
        $pengaduan = InputAspirasi::getByNis($user_nis);
        $kategori = Kategori::getAll();
        $aspirasi_list = Aspirasi::getAll();

        error_log('=== ASPIRASI CONTROLLER DEBUG ===');
        error_log('User NIS: ' . $user_nis);
        error_log('Pengaduan count dari API: ' . count($pengaduan));
        error_log('Pengaduan raw data: ' . json_encode($pengaduan, JSON_PRETTY_PRINT));

        $seen_ids = [];
        $pengaduan_unique = [];
        foreach ($pengaduan as $p) {
            $id = $p['id_pelaporan'];
            if (!isset($seen_ids[$id])) {
                $seen_ids[$id] = true;
                $pengaduan_unique[] = $p;
            }
        }
        $pengaduan = $pengaduan_unique;
        error_log('Pengaduan count setelah deduplicate by id: ' . count($pengaduan));

        // Create map for kategori
        $kategoriMap = [];
        foreach ($kategori as $k) {
            $kategoriMap[$k['id_kategori']] = $k['ket_kategori'];
        }

        // Merge pengaduan dengan aspirasi data (join pada id_pelaporan)
        foreach ($pengaduan as &$p) {
            $p['status'] = 'Menunggu';
            $p['feedback'] = '';
            foreach ($aspirasi_list as $asp) {
                if (isset($asp['id_pelaporan']) && $asp['id_pelaporan'] == $p['id_pelaporan']) {
                    $p['status'] = $asp['status'] ?? 'Menunggu';
                    $p['feedback'] = $asp['feedback'] ?? '';
                    break;
                }
            }
        }
        unset($p);
        require __DIR__ . '/../views/Aspirasi.php';
    }

    public static function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
            $nis = $_SESSION['user']['nis'];
            $id_kategori = $_POST['id_kategori'];
            $lokasi = $_POST['lokasi'];
            $ket = $_POST['ket'];

            $result = InputAspirasi::create($nis, $id_kategori, $lokasi, $ket);

            if ($result) {
                header('Location: index.php?page=aspirasi&success=1');
            } else {
                header('Location: index.php?page=aspirasi&error=1'); // ← redirect, jangan call index()
            }
            exit;
        }

        header('Location: index.php?page=aspirasi');
        exit;
    }

    public static function edit()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?page=aspirasi');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lokasi = $_POST['lokasi'];
            $ket = $_POST['ket'];

            $result = InputAspirasi::update($id, $lokasi, $ket);

            if ($result) {
                header('Location: index.php?page=aspirasi&success=1');
                exit;
            }
        }

        $aspirasi = InputAspirasi::getById($id);
        if (!$aspirasi || $aspirasi['nis'] != $_SESSION['user']['nis']) {
            header('Location: index.php?page=aspirasi');
            exit;
        }

        $kategori = Kategori::getAll();
        $kategoriMap = [];
        foreach ($kategori as $k) {
            $kategoriMap[$k['id_kategori']] = $k['ket_kategori'];
        }

        require_once __DIR__ . '/../views/EditAspirasi.php';
    }

    public static function delete()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $aspirasi = InputAspirasi::getById($id);
            if ($aspirasi && $aspirasi['nis'] == $_SESSION['user']['nis']) {
                InputAspirasi::delete($id);
                header('Location: index.php?page=aspirasi&success=1');
                exit;
            }
        }

        header('Location: index.php?page=aspirasi');
        exit;
    }
}
?>