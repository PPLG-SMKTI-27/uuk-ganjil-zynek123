<?php include '../template/header.php'; ?>

<h2>Edit User</h2>
<form action="index.php?page=update_user&id=<?= $user['id'] ?>" method="POST">
    <label>Nama</label>
    <input type="text" name="nama" value="<?= $user['nama'] ?>" required>

    <label>NIS/NIP</label>
    <input type="text" name="nis_nip" value="<?= $user['nis_nip'] ?>" required>

    <label>Kelas/Jabatan</label>
    <input type="text" name="kelas_jabatan" value="<?= $user['kelas_jabatan'] ?>" required>

    <button type="submit" class="btn">Update</button>
</form>

<?php include '../template/footer.php'; ?>