<?php include "app/views/template/header.php"; ?>

<div class="card">
    <h2>Daftar Alat Lab</h2>

    <a href="index.php?page=tambah" class="btn btn-primary" style="margin-bottom: 15px;">
        + Tambah Alat
    </a>

    <table class="table">
        <tr>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>

        <?php while ($a = $data->fetch_assoc()) { ?>
        <tr>
            <td><?= $a['nama_alat']; ?></td>
            <td><?= $a['deskripsi']; ?></td>
            <td><?= $a['jumlah']; ?></td>

            <td>
                <a href="index.php?page=hapus&id=<?= $a['id_alat']; ?>"
                   class="btn btn-danger"
                   onclick="return confirm('Yakin ingin menghapus?')">
                   Hapus
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<?php include "app/views/template/footer.php"; ?>