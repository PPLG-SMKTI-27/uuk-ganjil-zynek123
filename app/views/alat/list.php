<?php include '../template/header.php'; ?>

<h2>Data Alat</h2>
<a href="index.php?page=tambah_alat" class="btn">Tambah Alat</a>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Alat</th>
            <th>Kode Alat</th>
            <th>Jumlah</th>
            <th>Kondisi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($alat as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= $a['nama'] ?></td>
            <td><?= $a['kode'] ?></td>
            <td><?= $a['jumlah'] ?></td>
            <td><?= $a['kondisi'] ?></td>
            <td>
                <a href="index.php?page=edit_alat&id=<?= $a['id'] ?>">Edit</a>
                <a href="index.php?page=hapus_alat&id=<?= $a['id'] ?>" onclick="return confirm('Yakin?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../template/footer.php'; ?>