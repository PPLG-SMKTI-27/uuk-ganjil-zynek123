<?php
require_once 'BaseController.php';

class UserController extends BaseController {
    public function index() {
        $this->checkAuth('admin');
        $user = $this->getCurrentUser();
        
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Kelola User - Sistem Lab</title>
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
                .btn-edit { background: #28a745; }
                .btn-delete { background: #dc3545; }
                .btn-tambah { background: #007bff; }
                .action-cell { white-space: nowrap; }
                .admin-only { border-left: 4px solid #dc3545; background: #fff5f5; padding: 10px; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Kelola User Sistem</h1>
                <div class="user-info">
                    Welcome, ' . $user['username'] . ' 
                    <span class="role-badge ' . $user['role'] . '">' . strtoupper($user['role']) . '</span>
                </div>
                <div style="clear: both;"></div>
            </div>

            <div class="container">
                <div class="nav-menu">
                    <a href="index.php?page=alat&action=index">📦 Data Alat</a>
                    <a href="index.php?page=peminjaman&action=index">📋 Data Peminjaman</a>
                    <a href="index.php?page=auth&action=logout" class="logout">🚪 Logout</a>
                </div>

                <div class="admin-only">
                    <strong>⚠️ Halaman Admin Only</strong> - Hanya administrator yang dapat mengakses fitur ini.
                </div>

                <div class="card">
                    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 20px;">
                        <h2>Daftar User</h2>
                        <a href="index.php?page=user&action=create" class="btn btn-tambah">➕ Tambah User</a>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>admin</td>
                                <td>Administrator System</td>
                                <td><span class="role-badge admin">ADMIN</span></td>
                                <td>Aktif</td>
                                <td class="action-cell">
                                    <a href="index.php?page=user&action=edit&id=1" class="btn btn-edit">Edit</a>
                                    <a href="index.php?page=user&action=delete&id=1" class="btn btn-delete" onclick="return confirm(\'Yakin hapus user admin?\')">Hapus</a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>guru</td>
                                <td>Guru Mata Pelajaran</td>
                                <td><span class="role-badge guru">GURU</span></td>
                                <td>Aktif</td>
                                <td class="action-cell">
                                    <a href="index.php?page=user&action=edit&id=2" class="btn btn-edit">Edit</a>
                                    <a href="index.php?page=user&action=delete&id=2" class="btn btn-delete" onclick="return confirm(\'Yakin hapus user?\')">Hapus</a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>siswa</td>
                                <td>Siswa Contoh</td>
                                <td><span class="role-badge siswa">SISWA</span></td>
                                <td>Aktif</td>
                                <td class="action-cell">
                                    <a href="index.php?page=user&action=edit&id=3" class="btn btn-edit">Edit</a>
                                    <a href="index.php?page=user&action=delete&id=3" class="btn btn-delete" onclick="return confirm(\'Yakin hapus user?\')">Hapus</a>
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
        $this->checkAuth('admin');
        
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Tambah User - Admin Only</title>
            <style>
                body { font-family: Arial; padding: 20px; background: #f5f5f5; }
                .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
                .form-group { margin-bottom: 20px; }
                label { display: block; margin-bottom: 5px; font-weight: bold; }
                input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
                .btn { padding: 10px 20px; margin: 5px; text-decoration: none; border-radius: 4px; }
                .btn-primary { background: #007bff; color: white; border: none; }
                .btn-secondary { background: #6c757d; color: white; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>➕ Tambah User Baru</h1>
                
                <form method="POST" action="index.php?page=user&action=store">
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Nama Lengkap:</label>
                        <input type="text" name="nama_lengkap" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Role:</label>
                        <select name="role" required>
                            <option value="admin">Administrator</option>
                            <option value="guru">Guru</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Status:</label>
                        <select name="status" required>
                            <option value="aktif" selected>Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan User</button>
                    <a href="index.php?page=user&action=index" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </body>
        </html>
        ';
    }

    public function store() {
        $this->checkAuth('admin');
        
        echo "
        <script>
            alert('User berhasil ditambahkan!');
            window.location.href = 'index.php?page=user&action=index';
        </script>
        ";
    }

    public function edit($id) {
        $this->checkAuth('admin');
        
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit User - Admin Only</title>
            <style>
                body { font-family: Arial; padding: 20px; background: #f5f5f5; }
                .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
                .form-group { margin-bottom: 20px; }
                label { display: block; margin-bottom: 5px; font-weight: bold; }
                input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
                .btn { padding: 10px 20px; margin: 5px; text-decoration: none; border-radius: 4px; }
                .btn-primary { background: #007bff; color: white; border: none; }
                .btn-secondary { background: #6c757d; color: white; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>✏️ Edit User #' . $id . '</h1>
                
                <form method="POST" action="index.php?page=user&action=update&id=' . $id . '">
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="username" value="user' . $id . '" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>
                    
                    <div class="form-group">
                        <label>Nama Lengkap:</label>
                        <input type="text" name="nama_lengkap" value="Nama User ' . $id . '" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Role:</label>
                        <select name="role" required>
                            <option value="admin">Administrator</option>
                            <option value="guru" selected>Guru</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Status:</label>
                        <select name="status" required>
                            <option value="aktif" selected>Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="index.php?page=user&action=index" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </body>
        </html>
        ';
    }

    public function update($id) {
        $this->checkAuth('admin');
        
        echo "
        <script>
            alert('User #$id berhasil diupdate!');
            window.location.href = 'index.php?page=user&action=index';
        </script>
        ";
    }

    public function delete($id) {
        $this->checkAuth('admin');
        
        echo "
        <script>
            alert('User #$id berhasil dihapus!');
            window.location.href = 'index.php?page=user&action=index';
        </script>
        ";
    }
}
?>