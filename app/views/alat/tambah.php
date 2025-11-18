<?php include "app/views/template/header.php"; ?>

<div class="card" style="max-width: 450px; margin:auto;">
    <h2 style="margin-bottom: 15px;">Tambah Alat Lab</h2>

    <form action="index.php?page=proses_tambah" method="POST">

        <label class="form-label">Nama Alat</label>
        <input type="text" name="nama" class="form-input" required>

        <label class="form-label">Deskripsi</label>
        <textarea name="desk" class="form-input" style="height: 80px;" required></textarea>

        <label class="form-label">Jumlah</label>
        <input type="number" name="jumlah" class="form-input" required>

        <button type="submit" class="btn btn-success" style="margin-top: 10px;">
            Simpan
        </button>
    </form>
</div>

<?php include "app/views/template/footer.php"; ?>