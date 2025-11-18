<?php include '../template/header.php'; ?>

<h2>Profil Admin</h2>
<form action="index.php?page=update_profil&id=<?= $admin['id'] ?>" method="POST">
    <label>Nama</label>
    <input type="text" name="nama" value="<?= $admin['nama'] ?>" required>

    <label>Username</label>
    <input type="text" name="username" value="<?= $admin['username'] ?>" required>

    <label>Password Baru (biarkan kosong jika tidak ingin ganti)</label>
    <input type="password" name="password">

    <button type="submit" class="btn">Update Profil</button>
</form>

<?php include '../template/footer.php'; ?>