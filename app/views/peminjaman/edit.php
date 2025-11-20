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
                        <i class="fas fa-edit"></i> Edit Data Peminjaman
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
                                    <label class="form-label">Peminjam</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($peminjaman['nama_peminjam']); ?>" readonly>
                                    <div class="form-text">Nama peminjam tidak dapat diubah</div>
                                </div>

                                <div class="mb-3">
                                    <label for="alat_id" class="form-label">Pilih Alat *</label>
                                    <select class="form-select" id="alat_id" name="alat_id" required <?php echo $_SESSION['user_role'] == 'admin' && $peminjaman['status'] != 'pending' ? 'disabled' : ''; ?>>
                                        <option value="">Pilih Alat</option>
                                        <?php foreach ($alat_list as $alat): ?>
                                            <?php if ($alat['jumlah_tersedia'] > 0 || $alat['id'] == $peminjaman['alat_id']): ?>
                                            <option value="<?php echo $alat['id']; ?>" 
                                                    data-tersedia="<?php echo $alat['jumlah_tersedia']; ?>"
                                                    <?php echo $alat['id'] == $peminjaman['alat_id'] ? 'selected' : ''; ?>
                                                    <?php echo ($_SESSION['user_role'] != 'admin' && $alat['id'] != $peminjaman['alat_id'] && $alat['jumlah_tersedia'] == 0) ? 'disabled' : ''; ?>>
                                                <?php echo htmlspecialchars($alat['nama_alat']); ?> 
                                                (Kode: <?php echo $alat['kode_alat']; ?>)
                                                - Tersedia: <?php echo $alat['jumlah_tersedia']; ?>
                                            </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if ($_SESSION['user_role'] == 'admin' && $peminjaman['status'] != 'pending'): ?>
                                        <input type="hidden" name="alat_id" value="<?php echo $peminjaman['alat_id']; ?>">
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah *</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" 
                                           value="<?php echo $peminjaman['jumlah']; ?>" min="1" required
                                           <?php echo $_SESSION['user_role'] == 'admin' && $peminjaman['status'] != 'pending' ? 'readonly' : ''; ?>>
                                    <div class="form-text" id="info-tersedia">
                                        Stok tersedia: <span id="stok-tersedia"><?php echo $peminjaman['jumlah_tersedia']; ?></span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam *</label>
                                    <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" 
                                           value="<?php echo $peminjaman['tanggal_pinjam']; ?>" required
                                           <?php echo $_SESSION['user_role'] == 'admin' && $peminjaman['status'] != 'pending' ? 'readonly' : ''; ?>>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali *</label>
                                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" 
                                           value="<?php echo $peminjaman['tanggal_kembali']; ?>" required
                                           <?php echo $_SESSION['user_role'] == 'admin' && $peminjaman['status'] != 'pending' ? 'readonly' : ''; ?>>
                                </div>

                                <?php if ($_SESSION['user_role'] == 'admin'): ?>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="pending" <?php echo $peminjaman['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="disetujui" <?php echo $peminjaman['status'] == 'disetujui' ? 'selected' : ''; ?>>Disetujui</option>
                                        <option value="ditolak" <?php echo $peminjaman['status'] == 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                                        <option value="selesai" <?php echo $peminjaman['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                    </select>
                                </div>
                                <?php else: ?>
                                    <input type="hidden" name="status" value="<?php echo $peminjaman['status']; ?>">
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4"
                                              <?php echo $_SESSION['user_role'] == 'admin' && $peminjaman['status'] != 'pending' ? 'readonly' : ''; ?>><?php echo htmlspecialchars($peminjaman['keterangan']); ?></textarea>
                                    <div class="form-text">Tujuan penggunaan alat (untuk praktikum apa, dll)</div>
                                </div>

                                <div class="mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title"><i class="fas fa-info-circle"></i> Informasi Peminjaman</h6>
                                            <p class="card-text mb-1">
                                                <strong>Diajukan:</strong> <?php echo date('d/m/Y H:i', strtotime($peminjaman['created_at'])); ?>
                                            </p>
                                            <p class="card-text mb-1">
                                                <strong>Status Saat Ini:</strong> 
                                                <span class="badge bg-<?php 
                                                    echo $peminjaman['status'] == 'disetujui' ? 'success' : 
                                                        ($peminjaman['status'] == 'pending' ? 'warning' : 
                                                        ($peminjaman['status'] == 'ditolak' ? 'danger' : 'info')); 
                                                ?>">
                                                    <?php echo ucfirst($peminjaman['status']); ?>
                                                </span>
                                            </p>
                                            <?php if ($_SESSION['user_role'] != 'admin' && $peminjaman['status'] != 'pending'): ?>
                                                <p class="card-text mb-0 text-warning">
                                                    <i class="fas fa-exclamation-triangle"></i> 
                                                    Peminjaman sudah diproses, tidak dapat diubah
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" 
                                    <?php echo ($_SESSION['user_role'] != 'admin' && $peminjaman['status'] != 'pending') ? 'disabled' : ''; ?>>
                                    <i class="fas fa-save"></i> Update Peminjaman
                                </button>
                                <a href="index.php?page=peminjaman&action=index" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <a href="index.php?page=peminjaman&action=show&id=<?php echo $peminjaman['id']; ?>" class="btn btn-info">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                                
                                <?php if ($_SESSION['user_role'] == 'admin' && $peminjaman['status'] == 'pending'): ?>
                                    <div class="btn-group ms-2">
                                        <a href="index.php?page=peminjaman&action=updateStatus&id=<?php echo $peminjaman['id']; ?>&status=disetujui" 
                                           class="btn btn-success" onclick="return confirm('Setujui peminjaman ini?')">
                                            <i class="fas fa-check"></i> Setujui
                                        </a>
                                        <a href="index.php?page=peminjaman&action=updateStatus&id=<?php echo $peminjaman['id']; ?>&status=ditolak" 
                                           class="btn btn-danger" onclick="return confirm('Tolak peminjaman ini?')">
                                            <i class="fas fa-times"></i> Tolak
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const alatSelect = document.getElementById('alat_id');
    const jumlahInput = document.getElementById('jumlah');
    const stokTersediaSpan = document.getElementById('stok-tersedia');
    const infoTersedia = document.getElementById('info-tersedia');

    function updateStokInfo() {
        const selectedOption = alatSelect.options[alatSelect.selectedIndex];
        const stokTersedia = selectedOption ? parseInt(selectedOption.getAttribute('data-tersedia')) : 0;
        
        stokTersediaSpan.textContent = stokTersedia;
        
        // Update max value untuk jumlah input
        jumlahInput.max = stokTersedia;
        
        // Validasi real-time
        const jumlah = parseInt(jumlahInput.value);
        if (jumlah > stokTersedia) {
            jumlahInput.setCustomValidity('Jumlah melebihi stok tersedia');
            infoTersedia.className = 'form-text text-danger';
        } else {
            jumlahInput.setCustomValidity('');
            infoTersedia.className = 'form-text text-success';
        }
    }

    // Event listeners
    alatSelect.addEventListener('change', updateStokInfo);
    jumlahInput.addEventListener('input', updateStokInfo);
    
    // Initialize
    updateStokInfo();

    // Validasi tanggal
    const tanggalPinjam = document.getElementById('tanggal_pinjam');
    const tanggalKembali = document.getElementById('tanggal_kembali');
    
    function validateDates() {
        const pinjam = new Date(tanggalPinjam.value);
        const kembali = new Date(tanggalKembali.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);

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
    }

    tanggalPinjam.addEventListener('change', validateDates);
    tanggalKembali.addEventListener('change', validateDates);
});
</script>

            </div>
        </main>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>