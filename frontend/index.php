<?php
session_start();
require_once 'plugins/api.php';

$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? 'index';

switch ($page) {
    case 'login':
        require_once 'controllers/Auth.php';
        AuthController::login();
        break;

    case 'register_siswa':
    case 'register_admin':
    case 'logout':
        require_once 'controllers/Auth.php';
        if ($page === 'register_siswa')
            AuthController::registerSiswa();
        if ($page === 'register_admin')
            AuthController::registerAdmin();
        if ($page === 'logout')
            AuthController::logout();
        break;

    case 'aspirasi':
        require_once 'controllers/Aspirasi.php';

        if ($action === 'create') {
            AspirasiController::create();
        } elseif ($action === 'edit') {
            AspirasiController::edit();
        } elseif ($action === 'delete') {
            AspirasiController::delete();
        } else {
            AspirasiController::index();
        }
        break;

    case 'admin':
    case 'admin_review':
        if (!isset($_SESSION['admin'])) {
            header('Location: index.php?page=login');
            exit;
        }

        require_once 'controllers/AdminAspirasi.php';
        if ($page === 'admin') {
            AdminAspirasiController::index();
        } else {
            AdminAspirasiController::reviewAspirasi();
        }
        break;

    default:
        header('Location: index.php?page=login');
        exit;
}