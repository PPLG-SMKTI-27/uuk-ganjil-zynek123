<?php include "app/views/template/header.php"; ?>
<?php include "app/views/template/footer.php"; ?>
<div class="card">
    <h2>Data Peminjaman</h2>
    <a href="index.php?page=tambah_pinjam" class="btn">+ Tambah Peminjaman</a>
</div>

<div class="card">
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr style="background:#e7e7e7;">
            <th>ID</th>
            <th>User</th>
            <th>Alat</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php while($row = $data->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_pinjam'] ?></td>
            <td><?= $row['nama_user'] ?></td>
            <td><?= $row['nama_alat'] ?></td>
            <td><?= $row['tgl_pinjam'] ?></td>
            <td><?= $row['tgl_kembali'] ?></td>
            <td>
                <?php if($row['status'] == 'dikembalikan'): ?>
                    ✔ Sudah Kembali
                <?php else: ?>
                    🔥 Dipinjam
                <?php endif; ?>
            </td>
            <td>
                <?php if($row['status'] != 'dikembalikan'): ?>
                    <a class="btn" href="index.php?page=kembalikan&id=<?= $row['id_pinjam'] ?>">Kembalikan</a>
                <?php endif; ?>

                <a class="btn" href="index.php?page=hapus_pinjam&id=<?= $row['id_pinjam'] ?>" style="background:red;">
                    Hapus
                </a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>
</div>
