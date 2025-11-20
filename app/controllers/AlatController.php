<?php
require_once 'BaseController.php';

class AlatController extends BaseController {
    public function index() {
        $this->checkAuth(); // Cek login saja, semua role bisa akses
        
        $user = $this->getCurrentUser();
        
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Data Alat - Sistem Lab</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
                body { background: #f5f5f5; }
                .header { background: white; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
                .user-info { float: right; color: #666; }
                .role-badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 12px; margin-left: 10px; color: white; font-weight: bold; }
                .admin { background: #dc3545; }
                .guru { background: #28a745; }
                .siswa { background: #17a2b8; }
                .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
                .nav-menu { background: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap; }
                .nav-menu a { padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; }
                .nav-menu a.logout { background: #dc3545; }
                .card { background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; border: 1px solid #ddd; }
                th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; }
                th { background: #f8f9fa; font-weight: bold; border-bottom: 2px solid #ddd; }
                th:last-child, td:last-child { border-right: none; }
                .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 12px; margin: 2px; color: white; display: inline-block; border: none; cursor: pointer; }
                .btn-show { background: #17a2b8; }
                .btn-edit { background: #28a745; }
                .btn-delete { background: #dc3545; }
                .btn-pinjam { background: #ffc107; color: black; }
                .action-cell { white-space: nowrap; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Data Alat Laboratorium</h1>
                <div class="user-info">
                    Welcome, ' . $user['username'] . ' 
                    <span class="role-badge ' . $user['role'] . '">' . strtoupper($user['role']) . '</span>
                </div>
                <div style="clear: both;"></div>
            </div>

            <div class="container">
                <div class="nav-menu">
                    ' . ($user['role'] === 'admin' ? '<a href="index.php?page=alat&action=create">➕ Tambah Alat</a>' : '') . '
                    ' . ($user['role'] === 'admin' ? '<a href="index.php?page=user&action=index">👥 Kelola User</a>' : '') . '
                    <a href="index.php?page=peminjaman&action=index">📋 Data Peminjaman</a>
                    <a href="index.php?page=auth&action=logout" class="logout">🚪 Logout</a>
                </div>

                <div class="card">
                    <h2>Daftar Alat Laboratorium</h2>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Alat</th>
                                <th>Jumlah</th>
                                <th>Kondisi</th>
                                <th>Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Mikroskop Binokuler</td>
                                <td>15</td>
                                <td>Baik</td>
                                <td>Rak A1</td>
                                <td class="action-cell">
                                    <a href="index.php?page=alat&action=show&id=1" class="btn btn-show">Lihat</a>
                                    ' . ($user['role'] === 'admin' ? '<a href="index.php?page=alat&action=edit&id=1" class="btn btn-edit">Edit</a>' : '') . '
                                    ' . ($user['role'] === 'admin' ? '<a href="index.php?page=alat&action=delete&id=1" class="btn btn-delete" onclick="return confirm(\'Yakin hapus alat ini?\')">Hapus</a>' : '') . '
                                    ' . (in_array($user['role'], ['guru', 'siswa']) ? '<a href="index.php?page=peminjaman&action=create&alat_id=1" class="btn btn-pinjam">Pinjam</a>' : '') . '
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Laptop ASUS</td>
                                <td>20</td>
                                <td>Baik</td>
                                <td>Lemari Elektronik</td>
                                <td class="action-cell">
                                    <a href="index.php?page=alat&action=show&id=2" class="btn btn-show">Lihat</a>
                                    ' . ($user['role'] === 'admin' ? '<a href="index.php?page=alat&action=edit&id=2" class="btn btn-edit">Edit</a>' : '') . '
                                    ' . ($user['role'] === 'admin' ? '<a href="index.php?page=alat&action=delete&id=2" class="btn btn-delete" onclick="return confirm(\'Yakin hapus alat ini?\')">Hapus</a>' : '') . '
                                    ' . (in_array($user['role'], ['guru', 'siswa']) ? '<a href="index.php?page=peminjaman&action=create&alat_id=2" class="btn btn-pinjam">Pinjam</a>' : '') . '
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Tabung Reaksi</td>
                                <td>50</td>
                                <td>Baik</td>
                                <td>Rak Kimia</td>
                                <td class="action-cell">
                                    <a href="index.php?page=alat&action=show&id=3" class="btn btn-show">Lihat</a>
                                    ' . ($user['role'] === 'admin' ? '<a href="index.php?page=alat&action=edit&id=3" class="btn btn-edit">Edit</a>' : '') . '
                                    ' . ($user['role'] === 'admin' ? '<a href="index.php?page=alat&action=delete&id=3" class="btn btn-delete" onclick="return confirm(\'Yakin hapus alat ini?\')">Hapus</a>' : '') . '
                                    ' . (in_array($user['role'], ['guru', 'siswa']) ? '<a href="index.php?page=peminjaman&action=create&alat_id=3" class="btn btn-pinjam">Pinjam</a>' : '') . '
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

    public function create() {
        $this->checkAuth('admin'); // Hanya admin yang bisa akses
        
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Tambah Alat - Admin Only</title>
            <style>
                body { font-family: Arial; padding: 20px; }
                .form-group { margin-bottom: 15px; }
                label { display: block; margin-bottom: 5px; }
                input, select { padding: 8px; width: 300px; }
                .btn { padding: 10px 15px; margin: 5px; text-decoration: none; border-radius: 4px; }
                .btn-primary { background: #007bff; color: white; }
                .btn-secondary { background: #6c757d; color: white; }
            </style>
        </head>
        <body>
            <h1>➕ Tambah Alat Baru (Admin Only)</h1>
            <form method="POST" action="index.php?page=alat&action=store">
                <div class="form-group">
                    <label>Nama Alat:</label>
                    <input type="text" name="nama_alat" required>
                </div>
                <div class="form-group">
                    <label>Jumlah:</label>
                    <input type="number" name="jumlah" required>
                </div>
                <div class="form-group">
                    <label>Kondisi:</label>
                    <select name="kondisi" required>
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Lokasi:</label>
                    <input type="text" name="lokasi" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="index.php?page=alat&action=index" class="btn btn-secondary">Batal</a>
            </form>
        </body>
        </html>
        ';
    }

    public function store() {
        $this->checkAuth('admin');
        
        echo "
        <script>
            alert('Alat berhasil ditambahkan!');
            window.location.href = 'index.php?page=alat&action=index';
        </script>
        ";
    }

    public function show($id) {
        $this->checkAuth();
        
        $user = $this->getCurrentUser();
        
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Detail Alat</title>
            <style>
                body { font-family: Arial; padding: 20px; }
                .btn { padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; }
            </style>
        </head>
        <body>
            <h1>Detail Alat #' . $id . '</h1>
            <p><strong>Nama Alat:</strong> Alat Contoh ' . $id . '</p>
            <p><strong>Jumlah:</strong> 10</p>
            <p><strong>Kondisi:</strong> Baik</p>
            <p><strong>Lokasi:</strong> Rak ' . $id . '</p>
            <p><strong>Keterangan:</strong> Alat dalam kondisi baik dan siap digunakan</p>
            <br>
            <a href="index.php?page=alat&action=index" class="btn">Kembali ke Data Alat</a>
        </body>
        </html>
        ';
    }

    public function edit($id) {
        $this->checkAuth('admin');
        
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Alat</title>
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
                <h1>✏️ Edit Alat #' . $id . '</h1>
                
                <form method="POST" action="index.php?page=alat&action=update&id=' . $id . '">
                    <div class="form-group">
                        <label>Nama Alat:</label>
                        <input type="text" name="nama_alat" value="Mikroskop Binokuler" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Jumlah:</label>
                        <input type="number" name="jumlah" value="15" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Kondisi:</label>
                        <select name="kondisi" required>
                            <option value="Baik" selected>Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Lokasi:</label>
                        <input type="text" name="lokasi" value="Rak A1" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Keterangan:</label>
                        <textarea name="keterangan">Alat untuk praktikum biologi</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Alat</button>
                    <a href="index.php?page=alat&action=index" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </body>
        </html>
        ';
    }

    // METHOD BARU UNTUK PROSES UPDATE
    public function update($id) {
        $this->checkAuth('admin');
        
        // Simulasi update data
        echo "
        <script>
            alert('Alat #$id berhasil diupdate!');
            window.location.href = 'index.php?page=alat&action=index';
        </script>
        ";
    }

    public function delete($id) {
        $this->checkAuth('admin');
        
        echo "
        <script>
            alert('Alat #$id berhasil dihapus!');
            window.location.href = 'index.php?page=alat&action=index';
        </script>
        ";
    }
}
?>