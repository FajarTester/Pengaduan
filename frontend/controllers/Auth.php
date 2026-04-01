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

                $nis = $_POST['nis'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                if (strlen($nis) === 0) {
                    $error = "NIS tidak boleh kosong";
                } elseif (strlen($nis) !== 10) {
                    $error = "NIS harus 10 karakter";
                } elseif (strlen($email) === 0) {
                    $error = "Email tidak boleh kosong";
                } elseif (strlen($password) < 8) {
                    $error = "Password minimal 8 karakter";
                } else {
                    $siswa = Siswa::getByNisAndEmailAndPass($nis, $email, $password);
                    if ($siswa) {
                        $_SESSION['user'] = $siswa;
                        header('Location: index.php?page=aspirasi');
                        exit;
                    } else {
                        $error = "NIS tidak ditemukan";
                    }
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
            $nis = $_POST['nis'] ?? '';
            $kelas = $_POST['kelas'] ?? '';
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $email = $_POST['email'] ?? '';


            if (strlen($nis) === 0) {
                $error = "NIS tidak boleh kosong";
            } elseif (strlen($nis) !== 10) {
                $error = "NIS harus 10 karakter";
            } elseif (strlen($username) === 0) {
                $error = "Username tidak boleh kosong";
            } elseif (strlen($email) === 0) {
                $error = "Email tidak boleh kosong";
            } elseif (strlen($password) === 0) {
                $error = "Password tidak boleh kosong";
            } elseif (strlen($password) < 8) {
                $error = "Password minimal 8 karakter"; // ✅ tambahan validasi
            } else {

                $existing = Siswa::getByNis($nis);
                if ($existing) {
                    $error = "NIS sudah terdaftar";
                } else {
                    $result = Siswa::create($nis, $kelas, $username, $password, $email);
                    if ($result) {
                        $success = "Akun siswa berhasil dibuat! Silakan login.";
                        require_once __DIR__ . '/../views/RegisterSiswa.php';
                        echo "<script>
                        setTimeout(function() {
                            window.location.href = 'index.php?page=login&role=siswa';
                        }, 2000);
                    </script>";
                        return;
                    } else {
                        $error = "Gagal membuat akun siswa. Coba lagi.";
                    }
                }
            }

            require_once __DIR__ . '/../views/RegisterSiswa.php';
        } else {
            require_once __DIR__ . '/../views/RegisterSiswa.php';
        }
    }

    public static function registerAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $email = $_POST['email'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (strlen($username) === 0) {
                $error = "Username tidak boleh kosong";
            } elseif (strlen($email) === 0) {
                $error = "Email tidak boleh kosong";
            } elseif (strlen($password) < 8) {
                $error = "Password minimal 8 karakter";
            } elseif ($password !== $confirm_password) {
                $error = "Password tidak cocok";
            } else {
                $existing = Auth::getByEmail($email);
                if ($existing) {
                    $error = "Email sudah terdaftar";
                } else {
                    $result = Auth::register($username, $password, $email);
                    if ($result) {
                        $success = "Akun admin berhasil dibuat! Silakan login.";
                        require_once __DIR__ . '/../views/Register.php';
                        echo "<script>
                        setTimeout(function() {
                            window.location.href = 'index.php?page=login&role=admin';
                        }, 2000);
                    </script>";
                        return;
                    } else {
                        $error = "Gagal membuat akun admin. Coba lagi.";
                    }
                }
            }
            require_once __DIR__ . '/../views/Register.php';
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