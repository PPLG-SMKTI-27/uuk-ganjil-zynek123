<?php include 'views/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'views/layouts/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="mt-4">

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit"></i> Edit Data Alat
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
                                    <label for="nama_alat" class="form-label">Nama Alat *</label>
                                    <input type="text" class="form-control" id="nama_alat" name="nama_alat" 
                                           value="<?php echo htmlspecialchars($alat['nama_alat']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="kode_alat" class="form-label">Kode Alat *</label>
                                    <input type="text" class="form-control" id="kode_alat" name="kode_alat" 
                                           value="<?php echo htmlspecialchars($alat['kode_alat']); ?>" required>
                                    <div class="form-text">Kode unik untuk identifikasi alat</div>
                                </div>

                                <div class="mb-3">
                                    <label for="jumlah_total" class="form-label">Jumlah Total *</label>
                                    <input type="number" class="form-control" id="jumlah_total" name="jumlah_total" 
                                           value="<?php echo $alat['jumlah_total']; ?>" min="1" required>
                                    <div class="form-text">Jumlah total alat yang dimiliki</div>
                                </div>

                                <div class="mb-3">
                                    <label for="jumlah_tersedia" class="form-label">Jumlah Tersedia *</label>
                                    <input type="number" class="form-control" id="jumlah_tersedia" name="jumlah_tersedia" 
                                           value="<?php echo $alat['jumlah_tersedia']; ?>" min="0" 
                                           max="<?php echo $alat['jumlah_total']; ?>" required>
                                    <div class="form-text">Jumlah alat yang tersedia untuk dipinjam</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kondisi" class="form-label">Kondisi *</label>
                                    <select class="form-select" id="kondisi" name="kondisi" required>
                                        <option value="baik" <?php echo $alat['kondisi'] == 'baik' ? 'selected' : ''; ?>>Baik</option>
                                        <option value="rusak" <?php echo $alat['kondisi'] == 'rusak' ? 'selected' : ''; ?>>Rusak</option>
                                        <option value="perbaikan" <?php echo $alat['kondisi'] == 'perbaikan' ? 'selected' : ''; ?>>Perbaikan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="6"><?php echo htmlspecialchars($alat['deskripsi']); ?></textarea>
                                    <div class="form-text">Deskripsi detail tentang alat (spesifikasi, kegunaan, dll)</div>
                                </div>

                                <div class="mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title"><i class="fas fa-info-circle"></i> Informasi Alat</h6>
                                            <p class="card-text mb-1">
                                                <strong>Dibuat:</strong> <?php echo date('d/m/Y H:i', strtotime($alat['created_at'])); ?>
                                            </p>
                                            <p class="card-text mb-0">
                                                <strong>Status:</strong> 
                                                <span class="badge bg-<?php echo $alat['jumlah_tersedia'] > 0 ? 'success' : 'danger'; ?>">
                                                    <?php echo $alat['jumlah_tersedia'] > 0 ? 'Tersedia' : 'Habis'; ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Alat
                                </button>
                                <a href="index.php?page=alat&action=index" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <a href="index.php?page=alat&action=show&id=<?php echo $alat['id']; ?>" class="btn btn-info">
                                    <i class="fas fa-eye"></i> Lihat Detail
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
// Validasi jumlah tersedia tidak melebihi jumlah total
document.addEventListener('DOMContentLoaded', function() {
    const jumlahTotal = document.getElementById('jumlah_total');
    const jumlahTersedia = document.getElementById('jumlah_tersedia');
    
    function validateJumlah() {
        const total = parseInt(jumlahTotal.value);
        const tersedia = parseInt(jumlahTersedia.value);
        
        if (tersedia > total) {
            jumlahTersedia.setCustomValidity('Jumlah tersedia tidak boleh melebihi jumlah total');
        } else {
            jumlahTersedia.setCustomValidity('');
        }
        
        // Update max attribute
        jumlahTersedia.max = total;
    }
    
    jumlahTotal.addEventListener('change', validateJumlah);
    jumlahTersedia.addEventListener('keyup', validateJumlah);
    validateJumlah(); // Jalankan validasi saat pertama kali load
});
</script>

            </div>
        </main>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>