<?php include 'views/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'views/layouts/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="mt-4">

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">
                    <i class="fas fa-tools"></i> Data Alat Laboratorium
                </h1>
                <a href="index.php?page=alat&action=create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Alat
                </a>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Alat</th>
                                    <th>Nama Alat</th>
                                    <th>Deskripsi</th>
                                    <th>Total</th>
                                    <th>Tersedia</th>
                                    <th>Kondisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($data)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-3x mb-3"></i><br>
                                            Tidak ada data alat
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($data as $alat): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo $alat['kode_alat']; ?></span>
                                        </td>
                                        <td>
                                            <strong><?php echo $alat['nama_alat']; ?></strong>
                                        </td>
                                        <td>
                                            <?php 
                                                $deskripsi = $alat['deskripsi'];
                                                echo strlen($deskripsi) > 50 ? substr($deskripsi, 0, 50) . '...' : $deskripsi;
                                            ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?php echo $alat['jumlah_total']; ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo $alat['jumlah_tersedia'] > 0 ? 'success' : 'danger'; ?>">
                                                <?php echo $alat['jumlah_tersedia']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $alat['kondisi'] == 'baik' ? 'success' : 
                                                    ($alat['kondisi'] == 'rusak' ? 'danger' : 'warning'); 
                                            ?>">
                                                <i class="fas fa-<?php 
                                                    echo $alat['kondisi'] == 'baik' ? 'check' : 
                                                        ($alat['kondisi'] == 'rusak' ? 'times' : 'tools'); 
                                                ?>"></i>
                                                <?php echo ucfirst($alat['kondisi']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="index.php?page=alat&action=show&id=<?php echo $alat['id']; ?>" 
                                                   class="btn btn-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="index.php?page=alat&action=edit&id=<?php echo $alat['id']; ?>" 
                                                   class="btn btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="index.php?page=alat&action=delete&id=<?php echo $alat['id']; ?>" 
                                                   class="btn btn-danger" title="Hapus"
                                                   onclick="return confirm('Yakin ingin menghapus alat <?php echo $alat['nama_alat']; ?>?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
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
</div>

            </div>
        </main>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>