<?php include 'views/layouts/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include 'views/layouts/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="mt-4">

<?php include 'views/layouts/footer.php'; ?>    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h4 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user"></i> Detail User
                    </h4>
                    <div>
                        <a href="index.php?page=user&action=index" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="index.php?page=user&action=edit&id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Lengkap</label>
                                        <p class="form-control-plaintext fs-5"><?php echo htmlspecialchars($user['nama']); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <p class="form-control-plaintext">
                                            <i class="fas fa-envelope text-primary"></i>
                                            <?php echo htmlspecialchars($user['email']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Role</label>
                                        <p>
                                            <span class="badge bg-<?php 
                                                echo $user['role'] == 'admin' ? 'danger' : 
                                                    ($user['role'] == 'guru' ? 'warning' : 'info'); 
                                            ?> fs-6">
                                                <i class="fas fa-<?php 
                                                    echo $user['role'] == 'admin' ? 'user-shield' : 
                                                        ($user['role'] == 'guru' ? 'chalkboard-teacher' : 'user-graduate'); 
                                                ?>"></i>
                                                <?php echo ucfirst($user['role']); ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status Akun</label>
                                        <p>
                                            <span class="badge bg-success fs-6">
                                                <i class="fas fa-check-circle"></i> Aktif
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Riwayat Peminjaman (jika ada) -->
                            <?php if (isset($riwayat_peminjaman) && !empty($riwayat_peminjaman)): ?>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Riwayat Peminjaman Terbaru</label>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Alat</th>
                                                        <th>Tanggal</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach (array_slice($riwayat_peminjaman, 0, 5) as $peminjaman): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($peminjaman['nama_alat']); ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($peminjaman['tanggal_pinjam'])); ?></td>
                                                        <td>
                                                            <span class="badge bg-<?php 
                                                                echo $peminjaman['status'] == 'disetujui' ? 'success' : 
                                                                    ($peminjaman['status'] == 'pending' ? 'warning' : 
                                                                    ($peminjaman['status'] == 'ditolak' ? 'danger' : 'info')); 
                                                            ?>">
                                                                <?php echo ucfirst($peminjaman['status']); ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php if (count($riwayat_peminjaman) > 5): ?>
                                        <div class="text-center">
                                            <small class="text-muted">
                                                Menampilkan 5 dari <?php echo count($riwayat_peminjaman); ?> peminjaman
                                            </small>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-info-circle"></i> Informasi User
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted">ID User</small>
                                        <p class="mb-0">#<?php echo str_pad($user['id'], 6, '0', STR_PAD_LEFT); ?></p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted">Terdaftar Sejak</small>
                                        <p class="mb-0"><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></p>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted">Total Peminjaman</small>
                                        <p class="mb-0">
                                            <?php if (isset($riwayat_peminjaman)): ?>
                                                <span class="badge bg-primary"><?php echo count($riwayat_peminjaman); ?> kali</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">0 kali</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>

                                    <div class="mb-0">
                                        <small class="text-muted">Aksi</small>
                                        <div class="mt-2">
                                            <a href="index.php?page=user&action=edit&id=<?php echo $user['id']; ?>" 
                                               class="btn btn-warning btn-sm w-100 mb-1">
                                                <i class="fas fa-edit"></i> Edit User
                                            </a>
                                            <a href="index.php?page=user&action=delete&id=<?php echo $user['id']; ?>" 
                                               class="btn btn-danger btn-sm w-100"
                                               onclick="return confirm('Yakin ingin menghapus user <?php echo htmlspecialchars($user['nama']); ?>?')">
                                                <i class="fas fa-trash"></i> Hapus User
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistik Peminjaman -->
                            <?php if (isset($riwayat_peminjaman) && !empty($riwayat_peminjaman)): ?>
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-chart-pie"></i> Statistik Peminjaman
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $stats = [
                                        'disetujui' => 0,
                                        'pending' => 0,
                                        'ditolak' => 0,
                                        'selesai' => 0
                                    ];
                                    
                                    foreach ($riwayat_peminjaman as $p) {
                                        $stats[$p['status']]++;
                                    }
                                    ?>
                                    
                                    <?php foreach ($stats as $status => $count): ?>
                                        <?php if ($count > 0): ?>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small><?php echo ucfirst($status); ?></small>
                                            <span class="badge bg-<?php 
                                                echo $status == 'disetujui' ? 'success' : 
                                                    ($status == 'pending' ? 'warning' : 
                                                    ($status == 'ditolak' ? 'danger' : 'info')); 
                                            ?>"><?php echo $count; ?></span>
                                        </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
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