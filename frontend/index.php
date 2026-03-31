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
        require_once 'controllers/Auth.php';
        AuthController::registerSiswa();
        break;
    case 'register_admin':
        require_once 'controllers/Auth.php';
        AuthController::registerAdmin();
        break;
    case 'register':
        require_once 'controllers/Auth.php';
        AuthController::register();
        break;
    case 'logout':
        require_once 'controllers/Auth.php';
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
        require_once 'controllers/AdminAspirasi.php';
        AdminAspirasiController::index();
        break;
    case 'admin_review':
        require_once 'controllers/AdminAspirasi.php';
        AdminAspirasiController::reviewAspirasi();

        break;
    default:
        header('Location: index.php?page=login');
        exit;
        break;
}
?>