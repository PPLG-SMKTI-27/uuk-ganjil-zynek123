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
                <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                <small class="text-muted">Selamat datang, <?php echo $_SESSION['user_nama']; ?>!</small>
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
                                Total Alat Lab</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_alat; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tools fa-2x text-gray-300"></i>
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
                                Total Peminjaman</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats_peminjaman['total_peminjaman']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                                Pending Approval</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats_peminjaman['pending']; ?></div>
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
                                Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats_peminjaman['disetujui']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                        <i class="fas fa-history"></i> Peminjaman Terbaru
                    </h6>
                    <a href="index.php?page=peminjaman&action=index" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Peminjam</th>
                                    <th>Alat</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($recent_peminjaman)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Tidak ada data peminjaman</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($recent_peminjaman as $peminjaman): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $peminjaman['nama_peminjam']; ?></td>
                                        <td><?php echo $peminjaman['nama_alat']; ?></td>
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
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if ($peminjaman['status'] == 'pending'): ?>
                                                <a href="index.php?page=peminjaman&action=updateStatus&id=<?php echo $peminjaman['id']; ?>&status=disetujui" 
                                                   class="btn btn-sm btn-success">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="index.php?page=peminjaman&action=updateStatus&id=<?php echo $peminjaman['id']; ?>&status=ditolak" 
                                                   class="btn btn-sm btn-danger">
                                                    <i class="fas fa-times"></i>
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
                    <i class="fas fa-bolt"></i> Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="index.php?page=alat&action=create" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Tambah Alat
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="index.php?page=user&action=create" class="btn btn-success w-100">
                            <i class="fas fa-user-plus"></i> Tambah User
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="index.php?page=alat&action=index" class="btn btn-info w-100">
                            <i class="fas fa-tools"></i> Kelola Alat
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="index.php?page=peminjaman&action=index" class="btn btn-warning w-100">
                            <i class="fas fa-clipboard-list"></i> Kelola Peminjaman
                        </a>
                    </div>
                </div>
                
                <!-- Second Row of Actions -->
                <div class="row mt-2">
                    <div class="col-md-4 mb-3">
                        <a href="index.php?page=user&action=index" class="btn btn-secondary w-100">
                            <i class="fas fa-users"></i> Manajemen User
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-dark w-100" onclick="showStats()">
                            <i class="fas fa-chart-bar"></i> Lihat Statistik
                        </button>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-light w-100" onclick="exportData()">
                            <i class="fas fa-download"></i> Export Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showStats() {
    alert('Statistik Lab:\n\nTotal Alat: <?php echo $total_alat; ?>\nTotal Peminjaman: <?php echo $stats_peminjaman['total_peminjaman']; ?>\nPending: <?php echo $stats_peminjaman['pending']; ?>\nDisetujui: <?php echo $stats_peminjaman['disetujui']; ?>\nDitolak: <?php echo $stats_peminjaman['ditolak']; ?>');
}

function exportData() {
    alert('Fitur export data akan segera tersedia!');
}
</script>
            </div>
        </main>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>