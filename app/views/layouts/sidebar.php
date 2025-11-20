<?php
// Pastikan session sudah started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Sidebar -->
<div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse" id="sidebarMenu">
    <div class="position-sticky pt-3">
        <!-- User Info -->
        <div class="text-center text-white mb-4 p-3 border-bottom">
            <div class="mb-3">
                <i class="fas fa-user-circle fa-3x text-light"></i>
            </div>
            <h6 class="mb-1"><?php echo $_SESSION['user_nama']; ?></h6>
            <span class="badge bg-<?php 
                echo $_SESSION['user_role'] == 'admin' ? 'danger' : 
                    ($_SESSION['user_role'] == 'guru' ? 'warning' : 'info'); 
            ?>">
                <i class="fas fa-<?php 
                    echo $_SESSION['user_role'] == 'admin' ? 'user-shield' : 
                        ($_SESSION['user_role'] == 'guru' ? 'chalkboard-teacher' : 'user-graduate'); 
                ?>"></i>
                <?php echo ucfirst($_SESSION['user_role']); ?>
            </span>
        </div>

        <!-- Navigation Menu -->
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link text-white <?php echo ($_GET['page'] ?? '') == 'dashboard' ? 'active bg-primary' : ''; ?>" 
                   href="index.php?page=dashboard&action=index">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>

            <!-- Menu untuk Admin -->
            <?php if ($_SESSION['user_role'] == 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo ($_GET['page'] ?? '') == 'alat' ? 'active bg-primary' : ''; ?>" 
                   href="index.php?page=alat&action=index">
                    <i class="fas fa-tools me-2"></i>
                    Alat Laboratorium
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white <?php echo ($_GET['page'] ?? '') == 'user' ? 'active bg-primary' : ''; ?>" 
                   href="index.php?page=user&action=index">
                    <i class="fas fa-users me-2"></i>
                    Manajemen User
                </a>
            </li>
            <?php endif; ?>

            <!-- Menu untuk Semua User -->
            <li class="nav-item">
                <a class="nav-link text-white <?php echo ($_GET['page'] ?? '') == 'peminjaman' ? 'active bg-primary' : ''; ?>" 
                   href="index.php?page=peminjaman&action=index">
                    <i class="fas fa-clipboard-list me-2"></i>
                    Data Peminjaman
                </a>
            </li>

            <!-- Quick Action untuk Guru dan Siswa -->
            <?php if ($_SESSION['user_role'] != 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link text-white bg-success" 
                   href="index.php?page=peminjaman&action=create">
                    <i class="fas fa-plus-circle me-2"></i>
                    Ajukan Peminjaman
                </a>
            </li>
            <?php endif; ?>

            <!-- Quick Action untuk Admin -->
            <?php if ($_SESSION['user_role'] == 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link text-white bg-success" 
                   href="index.php?page=alat&action=create">
                    <i class="fas fa-plus-circle me-2"></i>
                    Tambah Alat Baru
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white bg-info" 
                   href="index.php?page=user&action=create">
                    <i class="fas fa-user-plus me-2"></i>
                    Tambah User Baru
                </a>
            </li>
            <?php endif; ?>
        </ul>

        <!-- Separator -->
        <hr class="text-white-50">

        <!-- Quick Stats (untuk Admin) -->
        <?php if ($_SESSION['user_role'] == 'admin'): ?>
        <div class="text-white small">
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-white-50">
                <span>Quick Stats</span>
            </h6>
            
            <?php
            // Include models untuk mendapatkan statistik
            require_once 'models/Alat.php';
            require_once 'models/Peminjaman.php';
            
            $alat = new Alat();
            $peminjaman = new Peminjaman();
            
            $total_alat = count($alat->readAll());
            $stats = $peminjaman->getStatistics();
            ?>
            
            <ul class="nav flex-column">
                <li class="nav-item px-3 py-1">
                    <small>
                        <i class="fas fa-tools text-success me-1"></i>
                        Total Alat: <strong><?php echo $total_alat; ?></strong>
                    </small>
                </li>
                <li class="nav-item px-3 py-1">
                    <small>
                        <i class="fas fa-clipboard-list text-info me-1"></i>
                        Total Peminjaman: <strong><?php echo $stats['total_peminjaman']; ?></strong>
                    </small>
                </li>
                <li class="nav-item px-3 py-1">
                    <small>
                        <i class="fas fa-clock text-warning me-1"></i>
                        Pending: <strong><?php echo $stats['pending']; ?></strong>
                    </small>
                </li>
                <li class="nav-item px-3 py-1">
                    <small>
                        <i class="fas fa-check-circle text-success me-1"></i>
                        Disetujui: <strong><?php echo $stats['disetujui']; ?></strong>
                    </small>
                </li>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Quick Links -->
        <div class="text-white small mt-4">
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-white-50">
                <span>Quick Links</span>
            </h6>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white-50" href="#" data-bs-toggle="modal" data-bs-target="#helpModal">
                        <i class="fas fa-question-circle me-2"></i>
                        Bantuan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white-50" href="#" data-bs-toggle="modal" data-bs-target="#aboutModal">
                        <i class="fas fa-info-circle me-2"></i>
                        Tentang Aplikasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white-50" href="index.php?page=auth&action=logout" 
                       onclick="return confirm('Yakin ingin logout?')">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- Copyright -->
        <div class="text-center text-white-50 mt-5 small">
            <p>&copy; 2024<br>Lab PPLG<br>v1.0</p>
        </div>
    </div>
</div>

<!-- Help Modal -->
<div class="modal fade" id="helpModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-question-circle"></i> Bantuan Penggunaan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if ($_SESSION['user_role'] == 'admin'): ?>
                <h6>Untuk Admin:</h6>
                <ul>
                    <li>Kelola data alat laboratorium</li>
                    <li>Kelola data user (guru & siswa)</li>
                    <li>Approve/reject peminjaman</li>
                    <li>Monitoring semua aktivitas</li>
                </ul>
                <?php elseif ($_SESSION['user_role'] == 'guru'): ?>
                <h6>Untuk Guru:</h6>
                <ul>
                    <li>Ajukan peminjaman alat</li>
                    <li>Lihat riwayat peminjaman</li>
                    <li>Edit peminjaman yang pending</li>
                    <li>Batalkan peminjaman yang pending</li>
                </ul>
                <?php else: ?>
                <h6>Untuk Siswa:</h6>
                <ul>
                    <li>Ajukan peminjaman alat</li>
                    <li>Lihat riwayat peminjaman</li>
                    <li>Edit peminjaman yang pending</li>
                    <li>Batalkan peminjaman yang pending</li>
                </ul>
                <?php endif; ?>
                
                <div class="alert alert-info mt-3">
                    <small>
                        <i class="fas fa-info-circle"></i>
                        <strong>Info:</strong> Untuk bantuan lebih lanjut, hubungi admin lab.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- About Modal -->
<div class="modal fade" id="aboutModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle"></i> Tentang Aplikasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="fas fa-flask fa-3x text-primary"></i>
                </div>
                <h5>Sistem Manajemen Lab PPLG</h5>
                <p class="text-muted">Aplikasi untuk mengelola peminjaman alat laboratorium</p>
                
                <div class="row text-start mt-4">
                    <div class="col-6">
                        <strong>Versi:</strong> 1.0.0<br>
                        <strong>Dibuat dengan:</strong> PHP Native<br>
                    </div>
                    <div class="col-6">
                        <strong>Framework:</strong> Bootstrap 5<br>
                        <strong>Database:</strong> MySQL<br>
                    </div>
                </div>
                
                <div class="mt-3 p-3 bg-light rounded">
                    <small class="text-muted">
                        <i class="fas fa-copyright"></i> 2024 Lab PPLG. 
                        Sistem dikembangkan untuk memudahkan manajemen peminjaman alat lab.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Sidebar Styles */
.sidebar {
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    min-height: calc(100vh - 56px);
}

.sidebar .nav-link {
    border-radius: 0.375rem;
    margin: 0.125rem 0.5rem;
    transition: all 0.3s ease;
}

.sidebar .nav-link:hover {
    background-color: rgba(255,255,255,0.1);
    transform: translateX(5px);
}

.sidebar .nav-link.active {
    background-color: #0d6efd !important;
    box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3);
}

.sidebar .nav-link.bg-success:hover {
    background-color: #198754 !important;
}

.sidebar .nav-link.bg-info:hover {
    background-color: #0dcaf0 !important;
}

.sidebar-heading {
    font-size: 0.75rem;
    text-transform: uppercase;
}

/* User Info Styles */
.sidebar .badge {
    font-size: 0.7em;
}

/* Progress bar untuk stats */
.progress {
    height: 6px;
    margin-top: 5px;
}

/* Responsive adjustments */
@media (max-width: 767.98px) {
    .sidebar {
        position: fixed;
        top: 56px;
        left: -100%;
        width: 100%;
        height: calc(100vh - 56px);
        transition: left 0.3s ease;
        z-index: 1000;
    }
    
    .sidebar.show {
        left: 0;
    }
}
</style>

<script>
// Auto-hide sidebar on mobile when clicking a link
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebarMenu');
    const navLinks = sidebar.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 768) {
                const bsCollapse = new bootstrap.Collapse(sidebar);
                bsCollapse.hide();
            }
        });
    });
    
    // Add active class based on current page
    const currentPage = '<?php echo $_GET["page"] ?? "dashboard"; ?>';
    const navItems = document.querySelectorAll('.sidebar .nav-link');
    
    navItems.forEach(item => {
        if (item.getAttribute('href').includes('page=' + currentPage)) {
            item.classList.add('active', 'bg-primary');
        }
    });
});
</script>