<?php include 'views/layouts/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'views/layouts/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="mt-4">

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit"></i> Edit Data User
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control" id="nama" name="nama" 
                                           value="<?php echo htmlspecialchars($user['nama']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Role *</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                        <option value="guru" <?php echo $user['role'] == 'guru' ? 'selected' : ''; ?>>Guru</option>
                                        <option value="siswa" <?php echo $user['role'] == 'siswa' ? 'selected' : ''; ?>>Siswa</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                                </div>

                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                </div>

                                <div class="mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title"><i class="fas fa-info-circle"></i> Informasi User</h6>
                                            <p class="card-text mb-1">
                                                <strong>Terdaftar:</strong> <?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?>
                                            </p>
                                            <p class="card-text mb-1">
                                                <strong>Status:</strong> 
                                                <span class="badge bg-<?php 
                                                    echo $user['role'] == 'admin' ? 'danger' : 
                                                        ($user['role'] == 'guru' ? 'warning' : 'info'); 
                                                ?>">
                                                    <?php echo ucfirst($user['role']); ?>
                                                </span>
                                            </p>
                                            <p class="card-text mb-0">
                                                <strong>ID User:</strong> <?php echo $user['id']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update User
                                </button>
                                <a href="index.php?page=user&action=index" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <a href="index.php?page=user&action=delete&id=<?php echo $user['id']; ?>" 
                                   class="btn btn-danger" 
                                   onclick="return confirm('Yakin ingin menghapus user <?php echo htmlspecialchars($user['nama']); ?>?')">
                                    <i class="fas fa-trash"></i> Hapus User
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validasi konfirmasi password
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    
    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Password tidak cocok');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.addEventListener('input', validatePassword);
    confirmPassword.addEventListener('input', validatePassword);
});
</script>

            </div>
        </main>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>