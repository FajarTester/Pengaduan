<?php
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/../models/Siswa.php';


class AuthController
{
    public static function login()
    {
        $role = $_GET['role'] ?? 'siswa';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($role === 'siswa') {
                // Siswa Login
                $nis = $_POST['nis'];
                $siswa = Siswa::getByNis($nis);
                if ($siswa) {
                    $_SESSION['user'] = $siswa;
                    header('Location: index.php?page=aspirasi');
                    exit;
                } else {
                    $error = "NIS tidak ditemukan";
                }
            } else {
                // Admin Login
                $username = $_POST['username'];
                $password = $_POST['password'];

                if (strlen($username) === 0 || strlen($password) === 0) {
                    $error = "Username atau password tidak boleh kosong";
                    require_once __DIR__ . '/../views/Login.php';
                    return;
                }

                if (strlen($password) < 8) {
                    $error = "Password minimal 8 karakter";
                    require_once __DIR__ . '/../views/Login.php';
                    return;
                }

                $admin = Auth::login($username, $password);
                if ($admin) {
                    $_SESSION['admin'] = $admin;
                    header('Location: index.php?page=admin');
                    exit;
                } else {
                    $error = "Username atau password salah";
                }
            }
        }

        if ($role === 'admin') {
            require_once __DIR__ . '/../views/Login.php';
        } else {
            require_once __DIR__ . '/../views/LoginSiswa.php';
        }
    }

    public static function registerSiswa()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nis = $_POST['nis'];
            $kelas = $_POST['kelas'];

            // Check if NIS already exists
            $existing = Siswa::getByNis($nis);
            if ($existing) {
                $error = "NIS sudah terdaftar";
                require_once __DIR__ . '/../views/RegisterSiswa.php';
                return;
            }

            if (strlen($nis) !== 10) {
                $error = "NIS harus 10 karakter";
                require_once __DIR__ . '/../views/RegisterSiswa.php';
                return;
            }

            // Create new siswa account
            $result = Siswa::create($nis, $kelas);
            if ($result) {
                $success = "Akun siswa berhasil dibuat! Silakan login.";
                require_once __DIR__ . '/../views/RegisterSiswa.php';
                // Auto redirect after 2 seconds
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'index.php?page=login&role=siswa';
                    }, 2000);
                </script>";
            } else {
                $error = "Gagal membuat akun siswa. Coba lagi.";
                require_once __DIR__ . '/../views/RegisterSiswa.php';
            }
        } else {
            require_once __DIR__ . '/../views/RegisterSiswa.php';
        }
    }

    public static function registerAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Validate password match
            if ($password !== $confirm_password) {
                $error = "Password tidak cocok";
                require_once __DIR__ . '/../views/Register.php';
                return;
            }

            if (strlen($password) < 8) {
                $error = "Password minimal 8 karakter";
                require_once __DIR__ . '/../views/Register.php';
                return;
            }

            // Check if username already exists
            $admin = Auth::login($username, $password);
            if ($admin) {
                $error = "Username sudah terdaftar";
                require_once __DIR__ . '/../views/Register.php';
                return;
            }

            // Register new admin
            $result = Auth::register($username, $password);
            if ($result) {
                $success = "Akun admin berhasil dibuat! Silakan login.";
                require_once __DIR__ . '/../views/Register.php';
                // Auto redirect after 2 seconds
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'index.php?page=login&role=admin';
                    }, 2000);
                </script>";
            } else {
                $error = "Gagal membuat akun admin. Coba lagi.";
                require_once __DIR__ . '/../views/Register.php';
            }
        } else {
            require_once __DIR__ . '/../views/Register.php';
        }
    }

    public static function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];



            Auth::register($username, $password);
            header('Location: index.php?page=login&role=admin');
            exit;
        } else {
            require_once __DIR__ . '/../views/Register.php';
        }
    }

    public static function logout()
    {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}
?>