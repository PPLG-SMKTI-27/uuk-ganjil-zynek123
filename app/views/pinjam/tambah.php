<?php include "app/views/template/header.php"; ?>
<?php include "app/views/template/footer.php"; ?>
<h2>Form Tambah Alat Ready</h2>

<form action="index.php?page=proses_pinjam" method="POST">

    <input type="hidden" name="id_user" value="1">

    <label>Pilih Alat</label><br>
<select name="id_alat" required>
    <option value="">-- Pilih Alat --</option>

    <?php foreach ($alat as $a): ?>
        <option value="<?= $a['id_alat'] ?>">
            <?= $a['id_alat'] ?> - <?= $a['nama_alat'] ?>
        </option>
    <?php endforeach; ?>
</select>
<br><br>


    <label>Tanggal Pinjam</label><br>
    <input type="date" name="tgl_pinjam" required><br><br>

    <label>Tanggal Kembali</label><br>
    <input type="date" name="tgl_kembali" required><br><br>

    <button type="submit">Simpan</button>
</form>
