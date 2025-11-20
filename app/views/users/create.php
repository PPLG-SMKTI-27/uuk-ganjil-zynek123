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
                                    <i class="fas fa-user-plus"></i> Tambah User Baru
                                </h4>
                            </div>
                            <div class="card-body">
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" id="userForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Informasi Personal -->
                                            <div class="mb-4">
                                                <h5 class="text-primary mb-3">
                                                    <i class="fas fa-id-card"></i> Informasi Personal
                                                </h5>
                                                
                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama Lengkap *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                        <input type="text" class="form-control" id="nama" name="nama" 
                                                               value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>" 
                                                               placeholder="Masukkan nama lengkap" required>
                                                    </div>
                                                    <div class="form-text">Nama lengkap user (minimal 3 karakter)</div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                        <input type="email" class="form-control" id="email" name="email" 
                                                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                                                               placeholder="contoh@email.com" required>
                                                    </div>
                                                    <div class="form-text">Email yang valid dan belum terdaftar</div>
                                                </div>
                                            </div>

                                            <!-- Role Selection -->
                                            <div class="mb-4">
                                                <h5 class="text-primary mb-3">
                                                    <i class="fas fa-user-tag"></i> Role & Akses
                                                </h5>
                                                
                                                <div class="mb-3">
                                                    <label for="role" class="form-label">Role User *</label>
                                                    <select class="form-select" id="role" name="role" required>
                                                        <option value="">-- Pilih Role --</option>
                                                        <option value="admin" <?php echo (isset($_POST['role']) && $_POST['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                                        <option value="guru" <?php echo (isset($_POST['role']) && $_POST['role'] == 'guru') ? 'selected' : ''; ?>>Guru</option>
                                                        <option value="siswa" <?php echo (isset($_POST['role']) && $_POST['role'] == 'siswa') ? 'selected' : ''; ?>>Siswa</option>
                                                    </select>
                                                    <div class="form-text">Tentukan hak akses user dalam sistem</div>
                                                </div>

                                                <!-- Role Information -->
                                                <div id="roleInfo" class="card mt-3" style="display: none;">
                                                    <div class="card-body">
                                                        <h6 class="card-title" id="roleTitle">Informasi Role</h6>
                                                        <p class="card-text small" id="roleDescription">
                                                            Pilih role untuk melihat informasi detail
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- Password Section -->
                                            <div class="mb-4">
                                                <h5 class="text-primary mb-3">
                                                    <i class="fas fa-lock"></i> Keamanan Akun
                                                </h5>
                                                
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                        <input type="password" class="form-control" id="password" name="password" 
                                                               placeholder="Masukkan password" required minlength="6">
                                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    <div class="form-text">Password minimal 6 karakter</div>
                                                    <div class="progress mt-2" style="height: 5px;">
                                                        <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                    <small class="text-muted" id="passwordFeedback"></small>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="confirm_password" class="form-label">Konfirmasi Password *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                                               placeholder="Ulangi password" required>
                                                    </div>
                                                    <div class="form-text">Harus sama dengan password di atas</div>
                                                    <div class="invalid-feedback" id="confirmPasswordError">
                                                        Password tidak cocok
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Preview User Card -->
                                            <div class="mb-4">
                                                <h5 class="text-primary mb-3">
                                                    <i class="fas fa-eye"></i> Preview User
                                                </h5>
                                                
                                                <div class="card border-primary">
                                                    <div class="card-body text-center">
                                                        <div class="mb-3">
                                                            <i class="fas fa-user-circle fa-3x text-primary" id="previewIcon"></i>
                                                        </div>
                                                        <h6 id="previewName" class="card-title">Nama User</h6>
                                                        <span class="badge bg-secondary" id="previewRole">Pilih Role</span>
                                                        <p class="card-text small text-muted mt-2" id="previewEmail">email@contoh.com</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Informasi Penting -->
                                            <div class="alert alert-info">
                                                <h6 class="alert-heading">
                                                    <i class="fas fa-info-circle"></i> Informasi Penting
                                                </h6>
                                                <ul class="mb-0 small">
                                                    <li><strong>Admin:</strong> Akses penuh ke semua fitur sistem</li>
                                                    <li><strong>Guru:</strong> Dapat meminjam alat dan melihat riwayat</li>
                                                    <li><strong>Siswa:</strong> Dapat meminjam alat dengan persetujuan</li>
                                                    <li>Pastikan data yang dimasukkan sudah benar</li>
                                                    <li>Password akan dienkripsi dan aman</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between">
                                                <a href="index.php?page=user&action=index" class="btn btn-secondary">
                                                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                                </a>
                                                <div>
                                                    <button type="reset" class="btn btn-outline-secondary">
                                                        <i class="fas fa-redo"></i> Reset Form
                                                    </button>
                                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                                        <i class="fas fa-save"></i> Simpan User
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const namaInput = document.getElementById('nama');
    const emailInput = document.getElementById('email');
    const roleSelect = document.getElementById('role');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const passwordStrength = document.getElementById('passwordStrength');
    const passwordFeedback = document.getElementById('passwordFeedback');
    const confirmPasswordError = document.getElementById('confirmPasswordError');
    const roleInfo = document.getElementById('roleInfo');
    const roleTitle = document.getElementById('roleTitle');
    const roleDescription = document.getElementById('roleDescription');
    const previewName = document.getElementById('previewName');
    const previewRole = document.getElementById('previewRole');
    const previewEmail = document.getElementById('previewEmail');
    const previewIcon = document.getElementById('previewIcon');
    const submitBtn = document.getElementById('submitBtn');

    // Role information
    const roleInfoData = {
        'admin': {
            title: 'Role Admin',
            description: 'Akses penuh ke semua fitur sistem termasuk manajemen user, alat, dan persetujuan peminjaman.',
            color: 'danger',
            icon: 'user-shield'
        },
        'guru': {
            title: 'Role Guru', 
            description: 'Dapat mengajukan peminjaman alat, melihat riwayat, dan mengelola peminjaman sendiri.',
            color: 'warning',
            icon: 'chalkboard-teacher'
        },
        'siswa': {
            title: 'Role Siswa',
            description: 'Dapat mengajukan peminjaman alat dan melihat riwayat peminjaman sendiri.',
            color: 'info', 
            icon: 'user-graduate'
        }
    };

    // Update role information
    function updateRoleInfo() {
        const role = roleSelect.value;
        
        if (role && roleInfoData[role]) {
            const info = roleInfoData[role];
            roleTitle.textContent = info.title;
            roleDescription.textContent = info.description;
            roleInfo.style.display = 'block';
            roleInfo.className = `card mt-3 border-${info.color}`;
        } else {
            roleInfo.style.display = 'none';
        }
    }

    // Update user preview
    function updateUserPreview() {
        const nama = namaInput.value || 'Nama User';
        const email = emailInput.value || 'email@contoh.com';
        const role = roleSelect.value || 'secondary';
        
        previewName.textContent = nama;
        previewEmail.textContent = email;
        
        if (role && roleInfoData[role]) {
            const info = roleInfoData[role];
            previewRole.textContent = info.title.replace('Role ', '');
            previewRole.className = `badge bg-${info.color}`;
            previewIcon.className = `fas fa-${info.icon} fa-3x text-${info.color}`;
        } else {
            previewRole.textContent = 'Pilih Role';
            previewRole.className = 'badge bg-secondary';
            previewIcon.className = 'fas fa-user-circle fa-3x text-primary';
        }
    }

    // Password strength checker
    function checkPasswordStrength(password) {
        let strength = 0;
        let feedback = '';
        
        if (password.length >= 6) strength += 25;
        if (password.length >= 8) strength += 25;
        if (/[A-Z]/.test(password)) strength += 25;
        if (/[0-9]/.test(password)) strength += 25;
        
        // Update progress bar
        passwordStrength.style.width = strength + '%';
        
        // Update color and feedback
        if (strength < 50) {
            passwordStrength.className = 'progress-bar bg-danger';
            feedback = 'Password lemah';
        } else if (strength < 75) {
            passwordStrength.className = 'progress-bar bg-warning';
            feedback = 'Password cukup';
        } else {
            passwordStrength.className = 'progress-bar bg-success';
            feedback = 'Password kuat';
        }
        
        passwordFeedback.textContent = feedback;
    }

    // Validate password confirmation
    function validatePasswordConfirmation() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (confirmPassword && password !== confirmPassword) {
            confirmPasswordInput.classList.add('is-invalid');
            confirmPasswordError.style.display = 'block';
            return false;
        } else {
            confirmPasswordInput.classList.remove('is-invalid');
            confirmPasswordError.style.display = 'none';
            return true;
        }
    }

    // Toggle password visibility
    function togglePasswordVisibility() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        confirmPasswordInput.setAttribute('type', type);
        
        const icon = togglePasswordBtn.querySelector('i');
        icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
    }

    // Form validation
    function validateForm() {
        const isPasswordValid = validatePasswordConfirmation();
        const isEmailValid = emailInput.checkValidity();
        const isNamaValid = namaInput.value.length >= 3;
        
        submitBtn.disabled = !(isPasswordValid && isEmailValid && isNamaValid && roleSelect.value);
    }

    // Event listeners
    namaInput.addEventListener('input', function() {
        updateUserPreview();
        validateForm();
    });

    emailInput.addEventListener('input', function() {
        updateUserPreview();
        validateForm();
    });

    roleSelect.addEventListener('change', function() {
        updateRoleInfo();
        updateUserPreview();
        validateForm();
    });

    passwordInput.addEventListener('input', function() {
        checkPasswordStrength(this.value);
        validatePasswordConfirmation();
        validateForm();
    });

    confirmPasswordInput.addEventListener('input', function() {
        validatePasswordConfirmation();
        validateForm();
    });

    togglePasswordBtn.addEventListener('click', togglePasswordVisibility);

    // Form submission
    document.getElementById('userForm').addEventListener('submit', function(e) {
        if (!validatePasswordConfirmation()) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak cocok!');
            return false;
        }

        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        submitBtn.disabled = true;
    });

    // Initialize
    updateRoleInfo();
    updateUserPreview();
    validateForm();

    // Real-time validation for nama
    namaInput.addEventListener('blur', function() {
        if (this.value.length < 3 && this.value.length > 0) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });

    // Real-time validation for email
    emailInput.addEventListener('blur', function() {
        if (!this.checkValidity() && this.value.length > 0) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
});
</script>

<style>
.card-header {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    color: white;
}

.input-group-text {
    background-color: #f8f9fa;
    border-right: none;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.form-control:focus + .input-group-text {
    border-color: #0d6efd;
}

.is-invalid {
    border-color: #dc3545 !important;
}

.is-invalid:focus {
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.progress {
    background-color: #e9ecef;
}

.alert-info {
    border-left: 4px solid #0dcaf0;
}

.btn-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    border: none;
}

.btn-primary:hover:not(:disabled) {
    background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
}

.btn-primary:disabled {
    background: #6c757d;
    border-color: #6c757d;
}

#roleInfo {
    transition: all 0.3s ease;
}

#previewIcon {
    transition: all 0.3s ease;
}

.badge {
    font-size: 0.8em;
    padding: 0.5em 0.75em;
}
</style>

         </div>
        </main>
    </div>
    </div>

<?php include 'views/layouts/footer.php'; ?>