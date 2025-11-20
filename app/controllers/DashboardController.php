<?php
class DashboardController {
    public function index() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }
        
        // Redirect berdasarkan role
        $role = $_SESSION['role'] ?? '';
        switch ($role) {
            case 'admin':
                $this->admin();
                break;
            case 'guru':
                $this->guru();
                break;
            case 'siswa':
                $this->siswa();
                break;
            default:
                header("Location: index.php?page=auth&action=login");
                exit();
        }
    }
    
    public function admin() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=auth&action=login");
            exit();
        }
        
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Dashboard Admin</title>
            <style>
                body { font-family: Arial; margin: 0; padding: 20px; background: #f5f5f5; }
                .header { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
                .menu { display: flex; gap: 15px; margin-bottom: 20px; }
                .menu a { padding: 15px 25px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
                .menu a.logout { background: #dc3545; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Dashboard Admin</h1>
                <p>Welcome, ' . $_SESSION['username'] . '</p>
            </div>
            <div class="menu">
                <a href="index.php?page=alat&action=index">Data Alat</a>
                <a href="index.php?page=user&action=index">Kelola User</a>
                <a href="index.php?page=peminjaman&action=index">Data Peminjaman</a>
                <a href="index.php?page=auth&action=logout" class="logout">Logout</a>
            </div>
            <p>Ini adalah dashboard untuk Administrator.</p>
        </body>
        </html>
        ';
    }
    
    public function guru() {
        // Implementasi dashboard guru
        echo '<h1>Dashboard Guru</h1>';
    }
    
    public function siswa() {
        // Implementasi dashboard siswa  
        echo '<h1>Dashboard Siswa</h1>';
    }
}
?>