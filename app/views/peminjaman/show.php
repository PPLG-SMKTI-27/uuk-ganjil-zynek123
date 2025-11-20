<?php include 'views/layouts/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'views/layouts/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="mt-4">

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h4 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clipboard-list"></i> Detail Peminjaman
                    </h4>
                    <div>
                        <a href="index.php?page=peminjaman&action=index" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <?php if (($_SESSION['user_role'] == 'admin') || ($_SESSION['user_role'] != 'admin' && $peminjaman['status'] == 'pending')): ?>
                        <a href="index.php?page=peminjaman&action=edit&id=<?php echo $peminjaman['id']; ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Informasi Utama -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Peminjam</label>
                                        <p class="form-control-plaintext">
                                            <?php echo htmlspecialchars($peminjaman['nama_peminjam']); ?>
                                            <span class="badge bg-<?php 
                                                echo $peminjaman['role'] == 'guru' ? 'warning' : 'info';
                                            ?> ms-1">
                                                <?php echo ucfirst($peminjaman['role']); ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status Peminjaman</label>
                                        <p>
                                            <span class="badge bg-<?php 
                                                echo $peminjaman['status'] == 'disetujui' ? 'success' : 
                                                    ($peminjaman['status'] == 'pending' ? 'warning' : 
                                                    ($peminjaman['status'] == 'ditolak' ? 'danger' : 'info')); 
                                            ?> fs-6">
                                                <i class="fas fa-<?php 
                                                    echo $peminjaman['status'] == 'disetujui' ? 'check' : 
                                                        ($peminjaman['status'] == 'pending' ? 'clock' : 
                                                        ($peminjaman['status'] == 'ditolak' ? 'times' : 'check-double')); 
                                                ?>"></i>
                                                <?php echo ucfirst($peminjaman['status']); ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Alat -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Alat yang Dipinjam</label>
                                        <p class="form-control-plaintext">
                                            <?php echo htmlspecialchars($peminjaman['nama_alat']); ?>
                                            <br>
                                            <small class="text-muted">Kode: <?php echo $peminjaman['kode_alat']; ?></small>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Jumlah</label>
                                        <p>
                                            <span class="badge bg-primary fs-6"><?php echo $peminjaman['jumlah']; ?> unit</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Waktu -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Pinjam</label>
                                        <p class="form-control-plaintext">
                                            <i class="fas fa-calendar-alt text-primary"></i>
                                            <?php echo date('d/m/Y', strtotime($peminjaman['tanggal_pinjam'])); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Kembali</label>
                                        <p class="form-control-plaintext">
                                            <i class="fas fa-calendar-check text-success"></i>
                                            <?php echo date('d/m/Y', strtotime($peminjaman['tanggal_kembali'])); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lama Pinjam</label>
                                        <p class="form-control-plaintext">
                                            <?php 
                                                $tanggal_pinjam = new DateTime($peminjaman['tanggal_pinjam']);
                                                $tanggal_kembali = new DateTime($peminjaman['tanggal_kembali']);
                                                $selisih = $tanggal_pinjam->diff($tanggal_kembali);
                                                echo $selisih->days . ' hari';
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Keterangan Penggunaan</label>
                                <div class="card">
                                    <div class="card-body">
                                        <?php if ($peminjaman['keterangan']): ?>
                                            <p class="card-text"><?php echo nl2br(htmlspecialchars($peminjaman['keterangan'])); ?></p>
                                        <?php else: ?>
                                            <p class="card-text text-muted">Tidak ada keterangan</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Status Card -->
                            <div class="card bg-light mb-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-info-circle"></i> Informasi Peminjaman
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted">ID Peminjaman</small>
                                        <p class="mb-0">#<?php echo str_pad($peminjaman['id'], 6, '0', STR_PAD_LEFT); ?></p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted">Diajukan Pada</small>
                                        <p class="mb-0"><?php echo date('d/m/Y H:i', strtotime($peminjaman['created_at'])); ?></p>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted">Status Saat Ini</small>
                                        <p class="mb-0">
                                            <span class="badge bg-<?php 
                                                echo $peminjaman['status'] == 'disetujui' ? 'success' : 
                                                    ($peminjaman['status'] == 'pending' ? 'warning' : 
                                                    ($peminjaman['status'] == 'ditolak' ? 'danger' : 'info')); 
                                            ?>">
                                                <?php echo ucfirst($peminjaman['status']); ?>
                                            </span>
                                        </p>
                                    </div>

                                    <?php if ($_SESSION['user_role'] == 'admin'): ?>
                                    <div class="mb-0">
                                        <small class="text-muted">Aksi Admin</small>
                                        <div class="mt-2">
                                            <?php if ($peminjaman['status'] == 'pending'): ?>
                                                <a href="index.php?page=peminjaman&action=updateStatus&id=<?php echo $peminjaman['id']; ?>&status=disetujui" 
                                                   class="btn btn-success btn-sm w-100 mb-1"
                                                   onclick="return confirm('Setujui peminjaman ini?')">
                                                    <i class="fas fa-check"></i> Setujui
                                                </a>
                                                <a href="index.php?page=peminjaman&action=updateStatus&id=<?php echo $peminjaman['id']; ?>&status=ditolak" 
                                                   class="btn btn-danger btn-sm w-100"
                                                   onclick="return confirm('Tolak peminjaman ini?')">
                                                    <i class="fas fa-times"></i> Tolak
                                                </a>
                                            <?php elseif ($peminjaman['status'] == 'disetujui'): ?>
                                                <a href="index.php?page=peminjaman&action=updateStatus&id=<?php echo $peminjaman['id']; ?>&status=selesai" 
                                                   class="btn btn-info btn-sm w-100"
                                                   onclick="return confirm('Tandai peminjaman sebagai selesai?')">
                                                    <i class="fas fa-check-double"></i> Tandai Selesai
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Timeline Status -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-history"></i> Timeline Status
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="timeline-item <?php echo $peminjaman['status'] == 'pending' ? 'active' : 'completed'; ?>">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <small>Diajukan</small>
                                                <br>
                                                <small class="text-muted"><?php echo date('d/m H:i', strtotime($peminjaman['created_at'])); ?></small>
                                            </div>
                                        </div>
                                        
                                        <?php if ($peminjaman['status'] != 'pending'): ?>
                                        <div class="timeline-item <?php echo in_array($peminjaman['status'], ['disetujui', 'selesai']) ? 'completed' : ''; ?>">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <small>Diproses Admin</small>
                                                <br>
                                                <small class="text-muted">-</small>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if (in_array($peminjaman['status'], ['disetujui', 'selesai'])): ?>
                                        <div class="timeline-item <?php echo $peminjaman['status'] == 'disetujui' ? 'active' : 'completed'; ?>">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <small>Disetujui</small>
                                                <br>
                                                <small class="text-muted">-</small>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if ($peminjaman['status'] == 'selesai'): ?>
                                        <div class="timeline-item completed">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <small>Selesai</small>
                                                <br>
                                                <small class="text-muted">-</small>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-cog"></i> Actions
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="btn-group">
                                        <a href="index.php?page=peminjaman&action=index" class="btn btn-secondary">
                                            <i class="fas fa-list"></i> Kembali ke Daftar
                                        </a>
                                        
                                        <?php if (($_SESSION['user_role'] == 'admin') || ($_SESSION['user_role'] != 'admin' && $peminjaman['status'] == 'pending')): ?>
                                        <a href="index.php?page=peminjaman&action=edit&id=<?php echo $peminjaman['id']; ?>" 
                                           class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Edit Peminjaman
                                        </a>
                                        <?php endif; ?>

                                        <?php if ($_SESSION['user_role'] == 'admin' || $peminjaman['status'] == 'pending'): ?>
                                        <a href="index.php?page=peminjaman&action=delete&id=<?php echo $peminjaman['id']; ?>" 
                                           class="btn btn-danger"
                                           onclick="return confirm('Yakin ingin menghapus peminjaman ini?')">
                                            <i class="fas fa-trash"></i> Hapus Peminjaman
                                        </a>
                                        <?php endif; ?>

                                        <?php if ($_SESSION['user_role'] != 'admin' && $peminjaman['status'] == 'pending'): ?>
                                        <button class="btn btn-info" onclick="printDetail()">
                                            <i class="fas fa-print"></i> Cetak Detail
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 20px;
}

.timeline-item {
    position: relative;
    margin-bottom: 15px;
    padding-left: 20px;
}

.timeline-marker {
    position: absolute;
    left: -10px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #dee2e6;
    border: 2px solid #fff;
}

.timeline-item.completed .timeline-marker {
    background-color: #28a745;
}

.timeline-item.active .timeline-marker {
    background-color: #007bff;
    animation: pulse 1.5s infinite;
}

.timeline-content {
    font-size: 0.875rem;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
</style>

<script>
function printDetail() {
    window.print();
}
</script>

            </div>
        </main>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>