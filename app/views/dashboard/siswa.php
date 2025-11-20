<?php include 'views/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'views/layouts/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="mt-4">
                
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">
                <i class="fas fa-tachometer-alt"></i> Dashboard Siswa
                <small class="text-muted">Selamat belajar, <?php echo $_SESSION['user_nama']; ?>!</small>
            </h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Peminjaman</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count($recent_peminjaman); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                    $disetujui = array_filter($recent_peminjaman, function($p) {
                                        return $p['status'] == 'disetujui';
                                    });
                                    echo count($disetujui);
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                    $pending = array_filter($recent_peminjaman, function($p) {
                                        return $p['status'] == 'pending';
                                    });
                                    echo count($pending);
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Alat Tersedia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_alat; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tools fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Peminjaman -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history"></i> Riwayat Peminjaman Saya
                    </h6>
                    <a href="index.php?page=peminjaman&action=create" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Ajukan Peminjaman
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Alat</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($recent_peminjaman)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                            Belum ada riwayat peminjaman
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($recent_peminjaman as $peminjaman): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <strong><?php echo $peminjaman['nama_alat']; ?></strong>
                                            <br>
                                            <small class="text-muted">Kode: <?php echo $peminjaman['kode_alat']; ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?php echo $peminjaman['jumlah']; ?></span>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($peminjaman['tanggal_pinjam'])); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($peminjaman['tanggal_kembali'])); ?></td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $peminjaman['status'] == 'disetujui' ? 'success' : 
                                                    ($peminjaman['status'] == 'pending' ? 'warning' : 
                                                    ($peminjaman['status'] == 'ditolak' ? 'danger' : 'info')); 
                                            ?>">
                                                <?php echo ucfirst($peminjaman['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="index.php?page=peminjaman&action=show&id=<?php echo $peminjaman['id']; ?>" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <?php if ($peminjaman['status'] == 'pending'): ?>
                                                <a href="index.php?page=peminjaman&action=edit&id=<?php echo $peminjaman['id']; ?>" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt"></i> Akses Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="index.php?page=peminjaman&action=create" class="btn btn-primary w-100">
                                <i class="fas fa-plus"></i> Ajukan Peminjaman
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="index.php?page=peminjaman&action=index" class="btn btn-info w-100">
                                <i class="fas fa-list"></i> Lihat Semua Peminjaman
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="#" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#alatModal">
                                <i class="fas fa-tools"></i> Lihat Daftar Alat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Daftar Alat -->
<div class="modal fade" id="alatModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-tools"></i> Daftar Alat Lab Tersedia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Alat</th>
                                <th>Kode</th>
                                <th>Tersedia</th>
                                <th>Kondisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $alat_list = $this->alat->readAll();
                            foreach ($alat_list as $alat): 
                                if ($alat['jumlah_tersedia'] > 0):
                            ?>
                            <tr>
                                <td><?php echo $alat['nama_alat']; ?></td>
                                <td><span class="badge bg-secondary"><?php echo $alat['kode_alat']; ?></span></td>
                                <td><span class="badge bg-success"><?php echo $alat['jumlah_tersedia']; ?></span></td>
                                <td>
                                    <span class="badge bg-<?php echo $alat['kondisi'] == 'baik' ? 'success' : 'warning'; ?>">
                                        <?php echo ucfirst($alat['kondisi']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </tbody>
                    </table>
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