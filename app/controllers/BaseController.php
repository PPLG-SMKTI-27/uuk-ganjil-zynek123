<?php
class BaseController {
    protected function checkAuth($requiredRole = null) {
        // Cek jika session sudah started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Cek jika user sudah login
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }
        
        // Cek role jika diperlukan
        if ($requiredRole && $_SESSION['role'] !== $requiredRole) {
            $this->showAccessDenied();
            exit();
        }
        
        return true;
    }
    
    protected function showAccessDenied() {
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Akses Ditolak</title>
            <style>
                body { font-family: Arial; background: #f8d7da; margin: 0; padding: 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
                .error-box { background: white; padding: 40px; border-radius: 8px; text-align: center; border-left: 5px solid #dc3545; }
                h1 { color: #dc3545; }
                .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 10px; }
            </style>
        </head>
        <body>
            <div class="error-box">
                <h1>⚠️ Akses Ditolak</h1>
                <p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>
                <p>Role Anda: <strong>' . ($_SESSION['role'] ?? 'Tidak diketahui') . '</strong></p>
                <a href="index.php?page=alat&action=index" class="btn">Kembali ke Beranda</a>
                <a href="index.php?page=auth&action=logout" class="btn">Login sebagai User Lain</a>
            </div>
        </body>
        </html>
        ';
    }
    
    protected function getCurrentUser() {
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'username' => $_SESSION['username'] ?? null,
            'role' => $_SESSION['role'] ?? null,
            'nama_lengkap' => $_SESSION['nama_lengkap'] ?? null
        ];
    }
    
    protected function startSessionIfNotStarted() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}
?>