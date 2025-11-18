<?php
require_once __DIR__ . "/../models/UserModel.php";

class AuthController {

    private $model;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->model = new UserModel();
    }

    public function login() {
        include "app/views/auth/login.php";
    }

    public function prosesLogin() {

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Ambil user berdasarkan username
        $result = $this->model->getByUsername($username);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Cek password (bcrypt)
            if (password_verify($password, $user['password'])) {

                // Simpan session
                $_SESSION['login'] = true;
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'];

                // Arahkan berdasarkan role
                if ($user['role'] === "admin") {
                    header("Location: index.php?page=admin_dashboard");
                } 
                elseif ($user['role'] === "guru") {
                    header("Location: index.php?page=guru_dashboard");
                } 
                elseif ($user['role'] === "siswa") {
                    header("Location: index.php?page=siswa_dashboard");
                }

                exit;
            }
        }

        // Jika gagal login
        echo "<script>alert('Username atau password salah!'); window.location='index.php?page=login';</script>";
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
    }
}
?>