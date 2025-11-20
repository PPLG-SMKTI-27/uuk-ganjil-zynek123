<?php
require_once 'BaseController.php';

class PeminjamanController extends BaseController {
    public function index() {
        $this->checkAuth(); // Gunakan checkAuth dari BaseController
        $user = $this->getCurrentUser();
        
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Data Peminjaman - Sistem Lab</title>
            <style>
                body { font-family: Arial; background: #f5f5f5; margin: 0; padding: 20px; }
                .header { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
                .user-info { float: right; color: #666; }
                .role-badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 12px; margin-left: 10px; color: white; font-weight: bold; }
                .admin { background: #dc3545; }
                .guru { background: #28a745; }
                .siswa { background: #17a2b8; }
                .container { max-width: 1200px; margin: 0 auto; }
                .nav-menu { background: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap; }
                .nav-menu a { padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; }
                .nav-menu a.logout { background: #dc3545; }
                .card { background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; border: 1px solid #ddd; }
                th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; }
                th { background: #f8f9fa; font-weight: bold; border-bottom: 2px solid #ddd; }
                th:last-child, td:last-child { border-right: none; }
                .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 12px; margin: 2px; color: white; display: inline-block; }
                .btn-kembalikan { background: #28a745; }
                .btn-hapus { background: #dc3545; }
                .btn-detail { background: #17a2b8; }
                .action-cell { white-space: nowrap; }
                .status-dipinjam { color: #dc3545; font-weight: bold; }
                .status-dikembalikan { color: #28a745; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Data Peminjaman Alat</h1>
                <div class="user-info">
                    Welcome, ' . $user['username'] . ' 
                    <span class="role-badge ' . $user['role'] . '">' . strtoupper($user['role']) . '</span>
                </div>
                <div style="clear: both;"></div>
            </div>

            <div class="container">
                <div class="nav-menu">
                    <a href="index.php?page=alat&action=index">📦 Data Alat</a>
                    ' . ($user['role'] === 'admin' ? '<a href="index.php?page=user&action=index">👥 Kelola User</a>' : '') . '
                    <a href="index.php?page=auth&action=logout" class="logout">🚪 Logout</a>
                </div>

                <div class="card">
                    <h2>Daftar Peminjaman Alat</h2>
                    
                    ' . ($user['role'] !== 'admin' ? '<p style="background: #e7f3ff; padding: 10px; border-radius: 5px;">Anda hanya dapat melihat peminjaman yang Anda lakukan.</p>' : '') . '
                    
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Alat</th>
                                <th>Peminjam</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Mikroskop Binokuler</td>
                                <td>' . ($user['role'] === 'admin' ? 'Budi Santoso' : $user['nama_lengkap']) . '</td>
                                <td>2024-01-15</td>
                                <td>2024-01-20</td>
                                <td class="status-dipinjam">Dipinjam</td>
                                <td class="action-cell">
                                    <a href="index.php?page=peminjaman&action=show&id=1" class="btn btn-detail">Detail</a>
                                    ' . ($user['role'] === 'admin' ? '<a href="index.php?page=peminjaman&action=kembalikan&id=1" class="btn btn-kembalikan">Kembalikan</a>' : '') . '
                                    ' . ($user['role'] === 'admin' ? '<a href="index.php?page=peminjaman&action=delete&id=1" class="btn btn-hapus">Hapus</a>' : '') . '
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Laptop ASUS</td>
                                <td>' . ($user['role'] === 'admin' ? 'Siti Rahayu' : $user['nama_lengkap']) . '</td>
                                <td>2024-01-10</td>
                                <td>2024-01-12</td>
                                <td class="status-dikembalikan">Dikembalikan</td>
                                <td class="action-cell">
                                    <a href="index.php?page=peminjaman&action=show&id=2" class="btn btn-detail">Detail</a>
                                    ' . ($user['role'] === 'admin' ? '<a href="index.php?page=peminjaman&action=delete&id=2" class="btn btn-hapus">Hapus</a>' : '') . '
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </body>
        </html>
        ';
    }

    public function show($id) {
        $this->checkAuth();
        $user = $this->getCurrentUser();
        
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Detail Peminjaman</title>
            <style>
                body { font-family: Arial; padding: 20px; background: #f5f5f5; }
                .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
                .btn { padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Detail Peminjaman #' . $id . '</h1>
                <p><strong>Nama Alat:</strong> Mikroskop Binokuler</p>
                <p><strong>Peminjam:</strong> ' . $user['nama_lengkap'] . '</p>
                <p><strong>Tanggal Pinjam:</strong> 2024-01-15</p>
                <p><strong>Tanggal Kembali:</strong> 2024-01-20</p>
                <p><strong>Status:</strong> Dipinjam</p>
                <p><strong>Keterangan:</strong> Untuk praktikum biologi kelas X</p>
                <br>
                <a href="index.php?page=peminjaman&action=index" class="btn">Kembali ke Data Peminjaman</a>
            </div>
        </body>
        </html>
        ';
    }

    public function kembalikan($id) {
        $this->checkAuth('admin');
        
        echo "
        <script>
            alert('Alat #$id berhasil dikembalikan!');
            window.location.href = 'index.php?page=peminjaman&action=index';
        </script>
        ";
    }

    public function delete($id) {
        $this->checkAuth('admin');
        
        echo "
        <script>
            alert('Data peminjaman #$id berhasil dihapus!');
            window.location.href = 'index.php?page=peminjaman&action=index';
        </script>
        ";
    }

    public function create() {
        $this->checkAuth();
        $user = $this->getCurrentUser();
        
        $alat_id = $_GET['alat_id'] ?? '';
        
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Pinjam Alat</title>
            <style>
                body { font-family: Arial; padding: 20px; background: #f5f5f5; }
                .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
                .form-group { margin-bottom: 20px; }
                label { display: block; margin-bottom: 5px; font-weight: bold; }
                input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
                .btn { padding: 10px 20px; margin: 5px; text-decoration: none; border-radius: 4px; }
                .btn-primary { background: #007bff; color: white; border: none; }
                .btn-secondary { background: #6c757d; color: white; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>📋 Form Peminjaman Alat</h1>
                <p><strong>Peminjam:</strong> ' . $user['nama_lengkap'] . ' (' . $user['role'] . ')</p>
                
                <form method="POST" action="index.php?page=peminjaman&action=store">
                    <div class="form-group">
                        <label>Nama Alat:</label>
                        <input type="text" value="Mikroskop Binokuler" readonly>
                        <input type="hidden" name="alat_id" value="' . $alat_id . '">
                    </div>
                    
                    <div class="form-group">
                        <label>Tanggal Pinjam:</label>
                        <input type="date" name="tanggal_pinjam" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Tanggal Kembali:</label>
                        <input type="date" name="tanggal_kembali" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Keperluan:</label>
                        <textarea name="keperluan" placeholder="Tujuan peminjaman alat..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
                    <a href="index.php?page=alat&action=index" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </body>
        </html>
        ';
    }

    public function store() {
        $this->checkAuth();
        
        echo "
        <script>
            alert('Peminjaman berhasil diajukan!');
            window.location.href = 'index.php?page=peminjaman&action=index';
        </script>
        ";
    }
}
?>