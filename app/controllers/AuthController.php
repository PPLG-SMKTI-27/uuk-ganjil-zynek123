<?php
class AuthController {
    public function login() {
        // Tampilkan form login (sama seperti sebelumnya)
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Login - Sistem Lab</title>
            <style>
                body { font-family: Arial; background: #f0f2f5; margin: 0; padding: 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
                .login-box { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 400px; }
                h2 { color: #333; text-align: center; margin-bottom: 30px; }
                .form-group { margin-bottom: 20px; }
                label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
                input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
                button { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
                .demo { margin-top: 20px; padding: 15px; background: #e9ecef; border-radius: 4px; }
                .role-badge { display: inline-block; padding: 2px 8px; border-radius: 3px; font-size: 12px; margin-left: 10px; }
                .admin { background: #dc3545; color: white; }
                .guru { background: #28a745; color: white; }
                .siswa { background: #17a2b8; color: white; }
            </style>
        </head>
        <body>
            <div class="login-box">
                <h2>Login ke Sistem Lab</h2>
                <form method="POST" action="index.php?page=auth&action=prosesLogin">
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" name="password" required>
                    </div>
                    <button type="submit">Login</button>
                </form>
                <div class="demo">
                    <h3>Akun Demo:</h3>
                    <p>
                        <strong>Admin</strong> <span class="role-badge admin">Admin</span><br>
                        Username: <strong>admin</strong> | Password: <strong>admin</strong><br>
                        <em>Akses penuh ke semua fitur</em>
                    </p>
                    <p>
                        <strong>Guru</strong> <span class="role-badge guru">Guru</span><br>
                        Username: <strong>guru</strong> | Password: <strong>guru</strong><br>
                        <em>Bisa meminjam dan melihat data</em>
                    </p>
                    <p>
                        <strong>Siswa</strong> <span class="role-badge siswa">Siswa</span><br>
                        Username: <strong>siswa</strong> | Password: <strong>siswa</strong><br>
                        <em>Hanya bisa meminjam alat</em>
                    </p>
                </div>
            </div>
        </body>
        </html>
        ';
    }    public function prosesLogin() {
        // Hanya start session sekali di sini
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Login credentials
        if ($username === 'admin' && $password === 'admin') {
            $_SESSION['user_id'] = 1;
            $_SESSION['username'] = 'admin';
            $_SESSION['role'] = 'admin';
            $_SESSION['nama_lengkap'] = 'Administrator System';
            header("Location: index.php?page=alat&action=index");
            exit();
        } elseif ($username === 'guru' && $password === 'guru') {
            $_SESSION['user_id'] = 2;
            $_SESSION['username'] = 'guru';
            $_SESSION['role'] = 'guru';
            $_SESSION['nama_lengkap'] = 'Guru Mata Pelajaran';
            header("Location: index.php?page=alat&action=index");
            exit();
        } elseif ($username === 'siswa' && $password === 'siswa') {
            $_SESSION['user_id'] = 3;
            $_SESSION['username'] = 'siswa';
            $_SESSION['role'] = 'siswa';
            $_SESSION['nama_lengkap'] = 'Siswa Contoh';
            header("Location: index.php?page=alat&action=index");
            exit();
        } else {
            echo "<script>alert('Login gagal! Username/password salah.'); window.location.href = 'index.php?page=auth&action=login';</script>";
        }
    }
    
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: index.php?page=auth&action=login");
        exit();
    }
}
?>
