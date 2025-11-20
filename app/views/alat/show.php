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
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h4 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tools"></i> Detail Alat Laboratorium
                    </h4>
                    <div>
                        <a href="index.php?page=alat&action=index" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <?php if ($_SESSION['user_role'] == 'admin'): ?>
                        <a href="index.php?page=alat&action=edit&id=<?php echo $alat['id']; ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Alat</label>
                                        <p class="form-control-plaintext"><?php echo htmlspecialchars($alat['nama_alat']); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kode Alat</label>
                                        <p>
                                            <span class="badge bg-secondary fs-6"><?php echo $alat['kode_alat']; ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Jumlah Total</label>
                                        <p>
                                            <span class="badge bg-primary fs-6"><?php echo $alat['jumlah_total']; ?> unit</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Jumlah Tersedia</label>
                                        <p>
                                            <span class="badge bg-<?php echo $alat['jumlah_tersedia'] > 0 ? 'success' : 'danger'; ?> fs-6">
                                                <?php echo $alat['jumlah_tersedia']; ?> unit
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kondisi</label>
                                        <p>
                                            <span class="badge bg-<?php 
                                                echo $alat['kondisi'] == 'baik' ? 'success' : 
                                                    ($alat['kondisi'] == 'rusak' ? 'danger' : 'warning'); 
                                            ?> fs-6">
                                                <i class="fas fa-<?php 
                                                    echo $alat['kondisi'] == 'baik' ? 'check' : 
                                                        ($alat['kondisi'] == 'rusak' ? 'times' : 'tools'); 
                                                ?>"></i>
                                                <?php echo ucfirst($alat['kondisi']); ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <div class="card">
                                    <div class="card-body">
                                        <?php if ($alat['deskripsi']): ?>
                                            <p class="card-text"><?php echo nl2br(htmlspecialchars($alat['deskripsi'])); ?></p>
                                        <?php else: ?>
                                            <p class="card-text text-muted">Tidak ada deskripsi</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-info-circle"></i> Informasi Tambahan
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted">ID Alat</small>
                                        <p class="mb-0"><?php echo $alat['id']; ?></p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted">Tanggal Ditambahkan</small>
                                        <p class="mb-0"><?php echo date('d/m/Y H:i', strtotime($alat['created_at'])); ?></p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted">Status Ketersediaan</small>
                                        <p class="mb-0">
                                            <?php if ($alat['jumlah_tersedia'] > 0): ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check"></i> Tersedia
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times"></i> Tidak Tersedia
                                                </span>
                                            <?php endif; ?>
                                        </p>
                                    </div>

                                    <div class="mb-0">
                                        <small class="text-muted">Persentase Tersedia</small>
                                        <div class="progress mt-1">
                                            <?php 
                                                $persentase = $alat['jumlah_total'] > 0 ? 
                                                    ($alat['jumlah_tersedia'] / $alat['jumlah_total']) * 100 : 0;
                                            ?>
                                            <div class="progress-bar bg-<?php echo $persentase > 50 ? 'success' : ($persentase > 20 ? 'warning' : 'danger'); ?>" 
                                                 role="progressbar" 
                                                 style="width: <?php echo $persentase; ?>%"
                                                 aria-valuenow="<?php echo $persentase; ?>" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                <?php echo round($persentase); ?>%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if ($_SESSION['user_role'] != 'admin' && $alat['jumlah_tersedia'] > 0): ?>
                            <div class="card mt-3 border-success">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-success">
                                        <i class="fas fa-shopping-cart"></i> Alat Tersedia
                                    </h6>
                                    <p class="card-text">Alat ini dapat dipinjam</p>
                                    <a href="index.php?page=peminjaman&action=create" class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i> Ajukan Peminjaman
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <?php if ($_SESSION['user_role'] == 'admin'): ?>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-cog"></i> Admin Actions
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="btn-group">
                                        <a href="index.php?page=alat&action=edit&id=<?php echo $alat['id']; ?>" 
                                           class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Edit Alat
                                        </a>
                                        <a href="index.php?page=alat&action=delete&id=<?php echo $alat['id']; ?>" 
                                           class="btn btn-danger"
                                           onclick="return confirm('Yakin ingin menghapus alat <?php echo htmlspecialchars($alat['nama_alat']); ?>?')">
                                            <i class="fas fa-trash"></i> Hapus Alat
                                        </a>
                                        <a href="index.php?page=peminjaman&action=index" class="btn btn-info">
                                            <i class="fas fa-clipboard-list"></i> Lihat Peminjaman
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
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