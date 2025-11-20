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
                                    <i class="fas fa-plus"></i> Ajukan Peminjaman Alat
                                </h4>
                            </div>
                            <div class="card-body">
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" id="peminjamanForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Informasi Peminjam -->
                                            <div class="mb-4">
                                                <h5 class="text-primary mb-3">
                                                    <i class="fas fa-user"></i> Informasi Peminjam
                                                </h5>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Nama Peminjam</label>
                                                                <p class="form-control-plaintext"><?php echo $_SESSION['user_nama']; ?></p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Role</label>
                                                                <p>
                                                                    <span class="badge bg-<?php echo $_SESSION['user_role'] == 'guru' ? 'warning' : 'info'; ?>">
                                                                        <i class="fas fa-<?php echo $_SESSION['user_role'] == 'guru' ? 'chalkboard-teacher' : 'user-graduate'; ?>"></i>
                                                                        <?php echo ucfirst($_SESSION['user_role']); ?>
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Pilihan Alat -->
                                            <div class="mb-3">
                                                <label for="alat_id" class="form-label">Pilih Alat *</label>
                                                <select class="form-select" id="alat_id" name="alat_id" required>
                                                    <option value="">-- Pilih Alat --</option>
                                                    <?php foreach ($alat_list as $alat): ?>
                                                        <?php if ($alat['jumlah_tersedia'] > 0): ?>
                                                        <option value="<?php echo $alat['id']; ?>" 
                                                                data-tersedia="<?php echo $alat['jumlah_tersedia']; ?>"
                                                                data-kondisi="<?php echo $alat['kondisi']; ?>"
                                                                data-deskripsi="<?php echo htmlspecialchars($alat['deskripsi']); ?>"
                                                                <?php echo isset($_POST['alat_id']) && $_POST['alat_id'] == $alat['id'] ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($alat['nama_alat']); ?> 
                                                            (Kode: <?php echo $alat['kode_alat']; ?>)
                                                            - Tersedia: <?php echo $alat['jumlah_tersedia']; ?>
                                                        </option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="form-text">Pilih alat yang tersedia dari daftar</div>
                                            </div>

                                            <!-- Informasi Alat Terpilih -->
                                            <div id="alatInfo" class="card mb-3" style="display: none;">
                                                <div class="card-header bg-info text-white">
                                                    <h6 class="card-title mb-0">
                                                        <i class="fas fa-info-circle"></i> Informasi Alat Terpilih
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div id="alatDetail">
                                                        <!-- Detail alat akan diisi oleh JavaScript -->
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Jumlah Pinjam -->
                                            <div class="mb-3">
                                                <label for="jumlah" class="form-label">Jumlah yang Dipinjam *</label>
                                                <input type="number" class="form-control" id="jumlah" name="jumlah" 
                                                       value="<?php echo isset($_POST['jumlah']) ? $_POST['jumlah'] : '1'; ?>" 
                                                       min="1" max="1" required>
                                                <div class="form-text">
                                                    Stok tersedia: <span id="stokTersedia" class="fw-bold">0</span> unit
                                                    <span id="stokWarning" class="text-danger" style="display: none;">
                                                        <i class="fas fa-exclamation-triangle"></i> Jumlah melebihi stok tersedia
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- Tanggal Peminjaman -->
                                            <div class="mb-3">
                                                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam *</label>
                                                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" 
                                                       value="<?php echo isset($_POST['tanggal_pinjam']) ? $_POST['tanggal_pinjam'] : date('Y-m-d'); ?>" 
                                                       min="<?php echo date('Y-m-d'); ?>" required>
                                                <div class="form-text">Tanggal mulai peminjaman alat</div>
                                            </div>

                                            <!-- Tanggal Pengembalian -->
                                            <div class="mb-3">
                                                <label for="tanggal_kembali" class="form-label">Tanggal Kembali *</label>
                                                <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" 
                                                       value="<?php echo isset($_POST['tanggal_kembali']) ? $_POST['tanggal_kembali'] : date('Y-m-d', strtotime('+3 days')); ?>" 
                                                       min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                                                <div class="form-text">Tanggal pengembalian alat (minimal 1 hari setelah pinjam)</div>
                                                <div id="durasiInfo" class="mt-2">
                                                    <small class="text-muted">
                                                        Durasi: <span id="lamaPinjam">3</span> hari
                                                    </small>
                                                </div>
                                            </div>

                                            <!-- Keterangan -->
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan Penggunaan *</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan" 
                                                          rows="5" placeholder="Jelaskan tujuan penggunaan alat (untuk praktikum apa, mata pelajaran, dll)" 
                                                          required><?php echo isset($_POST['keterangan']) ? $_POST['keterangan'] : ''; ?></textarea>
                                                <div class="form-text">Berikan penjelasan detail tentang penggunaan alat</div>
                                            </div>

                                            <!-- Informasi Penting -->
                                            <div class="alert alert-warning">
                                                <h6 class="alert-heading">
                                                    <i class="fas fa-exclamation-circle"></i> Informasi Penting
                                                </h6>
                                                <ul class="mb-0 small">
                                                    <li>Peminjaman harus diajukan minimal 1 hari sebelum tanggal pinjam</li>
                                                    <li>Pastikan alat tersedia sebelum mengajukan peminjaman</li>
                                                    <li>Pengembalian alat harus tepat waktu dan dalam kondisi baik</li>
                                                    <li>Peminjaman akan diproses oleh admin lab</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between">
                                                <a href="index.php?page=peminjaman&action=index" class="btn btn-secondary">
                                                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                                </a>
                                                <div>
                                                    <button type="reset" class="btn btn-outline-secondary">
                                                        <i class="fas fa-redo"></i> Reset Form
                                                    </button>
                                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                                        <i class="fas fa-paper-plane"></i> Ajukan Peminjaman
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
    const alatSelect = document.getElementById('alat_id');
    const jumlahInput = document.getElementById('jumlah');
    const stokTersediaSpan = document.getElementById('stokTersedia');
    const stokWarning = document.getElementById('stokWarning');
    const alatInfo = document.getElementById('alatInfo');
    const alatDetail = document.getElementById('alatDetail');
    const tanggalPinjam = document.getElementById('tanggal_pinjam');
    const tanggalKembali = document.getElementById('tanggal_kembali');
    const lamaPinjamSpan = document.getElementById('lamaPinjam');
    const submitBtn = document.getElementById('submitBtn');

    // Update informasi alat terpilih
    function updateAlatInfo() {
        const selectedOption = alatSelect.options[alatSelect.selectedIndex];
        
        if (selectedOption && selectedOption.value !== '') {
            const stokTersedia = parseInt(selectedOption.getAttribute('data-tersedia'));
            const kondisi = selectedOption.getAttribute('data-kondisi');
            const deskripsi = selectedOption.getAttribute('data-deskripsi');
            
            // Update stok info
            stokTersediaSpan.textContent = stokTersedia;
            jumlahInput.max = stokTersedia;
            
            // Show alat info card
            alatInfo.style.display = 'block';
            
            // Update alat detail
            alatDetail.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <strong>Stok Tersedia:</strong><br>
                        <span class="badge bg-${stokTersedia > 0 ? 'success' : 'danger'} fs-6">
                            ${stokTersedia} unit
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Kondisi:</strong><br>
                        <span class="badge bg-${kondisi === 'baik' ? 'success' : 'warning'}">
                            <i class="fas fa-${kondisi === 'baik' ? 'check' : 'tools'}"></i>
                            ${kondisi.charAt(0).toUpperCase() + kondisi.slice(1)}
                        </span>
                    </div>
                </div>
                ${deskripsi ? `
                <div class="mt-2">
                    <strong>Deskripsi:</strong><br>
                    <small class="text-muted">${deskripsi}</small>
                </div>
                ` : ''}
            `;
            
            // Validasi jumlah
            validateJumlah();
        } else {
            alatInfo.style.display = 'none';
            stokTersediaSpan.textContent = '0';
            jumlahInput.max = 1;
        }
    }

    // Validasi jumlah peminjaman
    function validateJumlah() {
        const stokTersedia = parseInt(stokTersediaSpan.textContent);
        const jumlah = parseInt(jumlahInput.value);
        
        if (jumlah > stokTersedia) {
            stokWarning.style.display = 'inline';
            jumlahInput.classList.add('is-invalid');
            submitBtn.disabled = true;
        } else {
            stokWarning.style.display = 'none';
            jumlahInput.classList.remove('is-invalid');
            submitBtn.disabled = false;
        }
    }

    // Hitung durasi peminjaman
    function hitungDurasi() {
        const pinjam = new Date(tanggalPinjam.value);
        const kembali = new Date(tanggalKembali.value);
        
        if (pinjam && kembali && kembali > pinjam) {
            const diffTime = Math.abs(kembali - pinjam);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            lamaPinjamSpan.textContent = diffDays;
        } else {
            lamaPinjamSpan.textContent = '0';
        }
    }

    // Validasi tanggal
    function validateDates() {
        const pinjam = new Date(tanggalPinjam.value);
        const kembali = new Date(tanggalKembali.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        // Set min date untuk tanggal kembali
        const minKembali = new Date(pinjam);
        minKembali.setDate(minKembali.getDate() + 1);
        tanggalKembali.min = minKembali.toISOString().split('T')[0];

        if (pinjam < today) {
            tanggalPinjam.setCustomValidity('Tanggal pinjam tidak boleh kurang dari hari ini');
        } else {
            tanggalPinjam.setCustomValidity('');
        }

        if (kembali <= pinjam) {
            tanggalKembali.setCustomValidity('Tanggal kembali harus setelah tanggal pinjam');
        } else {
            tanggalKembali.setCustomValidity('');
        }

        hitungDurasi();
    }

    // Event listeners
    alatSelect.addEventListener('change', updateAlatInfo);
    jumlahInput.addEventListener('input', validateJumlah);
    tanggalPinjam.addEventListener('change', validateDates);
    tanggalKembali.addEventListener('change', validateDates);

    // Form submission validation
    document.getElementById('peminjamanForm').addEventListener('submit', function(e) {
        const stokTersedia = parseInt(stokTersediaSpan.textContent);
        const jumlah = parseInt(jumlahInput.value);
        
        if (jumlah > stokTersedia) {
            e.preventDefault();
            alert('Jumlah peminjaman melebihi stok yang tersedia!');
            return false;
        }

        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengajukan...';
        submitBtn.disabled = true;
    });

    // Initialize
    updateAlatInfo();
    validateDates();

    // Set minimum dates
    const today = new Date().toISOString().split('T')[0];
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tomorrowStr = tomorrow.toISOString().split('T')[0];

    tanggalPinjam.min = today;
    tanggalKembali.min = tomorrowStr;
});
</script>

<style>
.card-header.bg-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
}

.alert-warning {
    border-left: 4px solid #ffc107;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.is-invalid {
    border-color: #dc3545 !important;
}

#stokWarning {
    font-size: 0.875em;
}

#alatInfo {
    border-left: 4px solid #17a2b8;
}

.btn-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
}
</style>

<?php include 'views/layouts/footer.php'; ?>