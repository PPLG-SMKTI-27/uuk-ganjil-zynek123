<?php include '../template/header.php'; ?>

<h2>Edit Alat</h2>
<form action="index.php?page=update_alat&id=<?= $alat['id'] ?>" method="POST">
    <label>Nama Alat</label>
    <input type="text" name="nama" value="<?= $alat['nama'] ?>" required>

    <label>Kode Alat</label>
    <input type="text" name="kode" value="<?= $alat['kode'] ?>" required>

    <label>Jumlah</label>
    <input type="number" name="jumlah" value="<?= $alat['jumlah'] ?>" required>

    <label>Kondisi</label>
    <select name="kondisi" required>
        <option value="Baik" <?= $alat['kondisi']=='Baik'?'selected':'' ?>>Baik</option>
        <option value="Rusak" <?= $alat['kondisi']=='Rusak'?'selected':'' ?>>Rusak</option>
    </select>

    <button type="submit" class="btn">Update</button>
</form>

<?php include '../template/footer.php'; ?>