<?php include 'views/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'views/layouts/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="mt-4">
                
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h1 class="h3">
                                <i class="fas fa-clipboard-list"></i> Data Peminjaman
                            </h1>
                            <?php if ($_SESSION['user_role'] != 'admin'): ?>
                            <a href="index.php?page=peminjaman&action=create" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Ajukan Peminjaman
                            </a>
                            <?php endif; ?>
                        </div>

                        <!-- Filter Section -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-filter"></i> Filter Peminjaman
                                </h6>
                            </div>
                            <div class="card-body">
                                <form method="GET" class="row g-3">
                                    <input type="hidden" name="page" value="peminjaman">
                                    <input type="hidden" name="action" value="index">
                                    
                                    <div class="col-md-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="">Semua Status</option>
                                            <option value="pending" <?php echo (isset($_GET['status']) && $_GET['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="disetujui" <?php echo (isset($_GET['status']) && $_GET['status'] == 'disetujui') ? 'selected' : ''; ?>>Disetujui</option>
                                            <option value="ditolak" <?php echo (isset($_GET['status']) && $_GET['status'] == 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                                            <option value="selesai" <?php echo (isset($_GET['status']) && $_GET['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                        </select>
                                    </div>
                                    
                                    <?php if ($_SESSION['user_role'] == 'admin'): ?>
                                    <div class="col-md-3">
                                        <label for="role" class="form-label">Role Peminjam</label>
                                        <select class="form-select" id="role" name="role">
                                            <option value="">Semua Role</option>
                                            <option value="guru" <?php echo (isset($_GET['role']) && $_GET['role'] == 'guru') ? 'selected' : ''; ?>>Guru</option>
                                            <option value="siswa" <?php echo (isset($_GET['role']) && $_GET['role'] == 'siswa') ? 'selected' : ''; ?>>Siswa</option>
                                        </select>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="col-md-3">
                                        <label for="bulan" class="form-label">Bulan</label>
                                        <select class="form-select" id="bulan" name="bulan">
                                            <option value="">Semua Bulan</option>
                                            <?php
                                            $months = [
                                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                            ];
                                            foreach ($months as $num => $name) {
                                                $selected = (isset($_GET['bulan']) && $_GET['bulan'] == $num) ? 'selected' : '';
                                                echo "<option value='$num' $selected>$name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card shadow">
                            <div class="card-body">
                                <?php if (empty($data)): ?>
                                    <div class="text-center py-5">
                                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                        <h4 class="text-muted">Tidak ada data peminjaman</h4>
                                        <?php if ($_SESSION['user_role'] != 'admin'): ?>
                                        <p class="text-muted">Mulai dengan mengajukan peminjaman alat</p>
                                        <a href="index.php?page=peminjaman&action=create" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus"></i> Ajukan Peminjaman Pertama
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>No</th>
                                                    <?php if ($_SESSION['user_role'] == 'admin'): ?>
                                                    <th>Peminjam</th>
                                                    <th>Role</th>
                                                    <?php endif; ?>
                                                    <th>Alat</th>
                                                    <th>Kode</th>
                                                    <th>Jumlah</th>
                                                    <th>Tanggal Pinjam</th>
                                                    <th>Tanggal Kembali</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($data as $peminjaman): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    
                                                    <?php if ($_SESSION['user_role'] == 'admin'): ?>
                                                    <td>
                                                        <?php echo htmlspecialchars($peminjaman['nama_peminjam']); ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-<?php echo $peminjaman['role'] == 'guru' ? 'warning' : 'info'; ?>">
                                                            <i class="fas fa-<?php echo $peminjaman['role'] == 'guru' ? 'chalkboard-teacher' : 'user-graduate'; ?>"></i>
                                                            <?php echo ucfirst($peminjaman['role']); ?>
                                                        </span>
                                                    </td>
                                                    <?php endif; ?>
                                                    
                                                    <td>
                                                        <strong><?php echo htmlspecialchars($peminjaman['nama_alat']); ?></strong>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary"><?php echo $peminjaman['kode_alat']; ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary"><?php echo $peminjaman['jumlah']; ?></span>
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-calendar-alt text-primary me-1"></i>
                                                        <?php echo date('d/m/Y', strtotime($peminjaman['tanggal_pinjam'])); ?>
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-calendar-check text-success me-1"></i>
                                                        <?php echo date('d/m/Y', strtotime($peminjaman['tanggal_kembali'])); ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-<?php 
                                                            echo $peminjaman['status'] == 'disetujui' ? 'success' : 
                                                                ($peminjaman['status'] == 'pending' ? 'warning' : 
                                                                ($peminjaman['status'] == 'ditolak' ? 'danger' : 'info')); 
                                                        ?>">
                                                            <i class="fas fa-<?php 
                                                                echo $peminjaman['status'] == 'disetujui' ? 'check' : 
                                                                    ($peminjaman['status'] == 'pending' ? 'clock' : 
                                                                    ($peminjaman['status'] == 'ditolak' ? 'times' : 'check-double')); 
                                                            ?>"></i>
                                                            <?php echo ucfirst($peminjaman['status']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="index.php?page=peminjaman&action=show&id=<?php echo $peminjaman['id']; ?>" 
                                                               class="btn btn-info" title="Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            
                                                            <?php if (($_SESSION['user_role'] == 'admin') || ($_SESSION['user_role'] != 'admin' && $peminjaman['status'] == 'pending')): ?>
                                                            <a href="index.php?page=peminjaman&action=edit&id=<?php echo $peminjaman['id']; ?>" 
                                                               class="btn btn-warning" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <?php endif; ?>
                                                            
                                                            <?php if ($_SESSION['user_role'] == 'admin' && $peminjaman['status'] == 'pending'): ?>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                                                                    <i class="fas fa-cog"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item text-success" 
                                                                           href="index.php?page=peminjaman&action=updateStatus&id=<?php echo $peminjaman['id']; ?>&status=disetujui"
                                                                           onclick="return confirm('Setujui peminjaman ini?')">
                                                                            <i class="fas fa-check"></i> Setujui
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item text-danger" 
                                                                           href="index.php?page=peminjaman&action=updateStatus&id=<?php echo $peminjaman['id']; ?>&status=ditolak"
                                                                           onclick="return confirm('Tolak peminjaman ini?')">
                                                                            <i class="fas fa-times"></i> Tolak
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <?php endif; ?>
                                                            
                                                            <?php if ($_SESSION['user_role'] == 'admin' || $peminjaman['status'] == 'pending'): ?>
                                                            <a href="index.php?page=peminjaman&action=delete&id=<?php echo $peminjaman['id']; ?>" 
                                                               class="btn btn-danger" title="Hapus"
                                                               onclick="return confirm('Yakin ingin menghapus peminjaman ini?')">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Statistics -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="card-title">
                                                        <i class="fas fa-chart-bar"></i> Statistik Peminjaman
                                                    </h6>
                                                    <div class="row text-center">
                                                        <?php
                                                        $stats = [
                                                            'total' => count($data),
                                                            'pending' => 0,
                                                            'disetujui' => 0,
                                                            'ditolak' => 0,
                                                            'selesai' => 0
                                                        ];
                                                        
                                                        foreach ($data as $p) {
                                                            $stats[$p['status']]++;
                                                        }
                                                        ?>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="border rounded p-3 bg-white">
                                                                <h4 class="text-primary"><?php echo $stats['total']; ?></h4>
                                                                <small class="text-muted">Total</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="border rounded p-3 bg-white">
                                                                <h4 class="text-warning"><?php echo $stats['pending']; ?></h4>
                                                                <small class="text-muted">Pending</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="border rounded p-3 bg-white">
                                                                <h4 class="text-success"><?php echo $stats['disetujui']; ?></h4>
                                                                <small class="text-muted">Disetujui</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="border rounded p-3 bg-white">
                                                                <h4 class="text-danger"><?php echo $stats['ditolak']; ?></h4>
                                                                <small class="text-muted">Ditolak</small>
                                                            </div>
                                                        </div>
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
        </main>
    </div>
</div>

<style>
.table th {
    font-weight: 600;
    font-size: 0.875rem;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.badge {
    font-size: 0.7em;
}

/* Hover effects */
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.025);
}

/* Status badge animations */
.badge.bg-warning {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-close dropdown after click
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            const dropdown = this.closest('.dropdown-menu');
            if (dropdown) {
                const dropdownInstance = bootstrap.Dropdown.getInstance(dropdown.previousElementSibling);
                if (dropdownInstance) {
                    dropdownInstance.hide();
                }
            }
        });
    });

    // Filter form reset
    const resetFilter = document.getElementById('resetFilter');
    if (resetFilter) {
        resetFilter.addEventListener('click', function() {
            document.getElementById('status').value = '';
            document.getElementById('role').value = '';
            document.getElementById('bulan').value = '';
        });
    }

    // Print functionality
    const printButton = document.getElementById('printTable');
    if (printButton) {
        printButton.addEventListener('click', function() {
            window.print();
        });
    }
});
</script>

<?php include 'views/layouts/footer.php'; ?>