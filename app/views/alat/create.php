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
                        <i class="fas fa-plus"></i> Tambah Alat Baru
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
                                           value="<?php echo isset($_POST['nama_alat']) ? $_POST['nama_alat'] : ''; ?>" 
                                           required>
                                </div>

                                <div class="mb-3">
                                    <label for="kode_alat" class="form-label">Kode Alat *</label>
                                    <input type="text" class="form-control" id="kode_alat" name="kode_alat" 
                                           value="<?php echo isset($_POST['kode_alat']) ? $_POST['kode_alat'] : ''; ?>" 
                                           required>
                                    <div class="form-text">Kode unik untuk identifikasi alat (contoh: LP001, MC002)</div>
                                </div>

                                <div class="mb-3">
                                    <label for="jumlah_total" class="form-label">Jumlah Total *</label>
                                    <input type="number" class="form-control" id="jumlah_total" name="jumlah_total" 
                                           value="<?php echo isset($_POST['jumlah_total']) ? $_POST['jumlah_total'] : '1'; ?>" 
                                           min="1" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kondisi" class="form-label">Kondisi *</label>
                                    <select class="form-select" id="kondisi" name="kondisi" required>
                                        <option value="baik" <?php echo (isset($_POST['kondisi']) && $_POST['kondisi'] == 'baik') ? 'selected' : ''; ?>>Baik</option>
                                        <option value="rusak" <?php echo (isset($_POST['kondisi']) && $_POST['kondisi'] == 'rusak') ? 'selected' : ''; ?>>Rusak</option>
                                        <option value="perbaikan" <?php echo (isset($_POST['kondisi']) && $_POST['kondisi'] == 'perbaikan') ? 'selected' : ''; ?>>Perbaikan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"><?php echo isset($_POST['deskripsi']) ? $_POST['deskripsi'] : ''; ?></textarea>
                                    <div class="form-text">Deskripsi detail tentang alat (spesifikasi, kegunaan, dll)</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Alat
                                </button>
                                <a href="index.php?page=alat&action=index" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

            </div>
        </main>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>