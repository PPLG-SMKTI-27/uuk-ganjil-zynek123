
<h2 style="margin-bottom: 15px;">Kelola User</h2>

<a href="index.php?page=tambah_user" 
   style="
      display:inline-block;
      padding:8px 14px;
      background:#28a745;
      color:white;
      text-decoration:none;
      border-radius:5px;
      margin-bottom:15px;
   ">
   + Tambah User
</a>

<table style="
        width:100%;
        border-collapse:collapse;
        border:1px solid #ccc;
        font-size:14px;">
    
    <thead>
        <tr style="background:#f2f2f2;">
            <th style="padding:10px; border:1px solid #ccc;">ID</th>
            <th style="padding:10px; border:1px solid #ccc;">Nama</th>
            <th style="padding:10px; border:1px solid #ccc;">Username</th>
            <th style="padding:10px; border:1px solid #ccc;">Role</th>
            <th style="padding:10px; border:1px solid #ccc;">Aksi</th>
        </tr>
    </thead>

    <tbody>
    <?php while($u = $users->fetch_assoc()): ?>
        <tr>
            <td style="padding:8px; border:1px solid #ccc;"><?= $u['id_user'] ?></td>
            <td style="padding:8px; border:1px solid #ccc;"><?= $u['nama'] ?></td>
            <td style="padding:8px; border:1px solid #ccc;"><?= $u['username'] ?></td>
            <td style="padding:8px; border:1px solid #ccc; text-transform:capitalize;"><?= $u['role'] ?></td>

            <td style="padding:8px; border:1px solid #ccc;">
                <a href="index.php?page=edit_user&id=<?= $u['id_user'] ?>"
                   style="padding:6px 10px; background:#ffc107; color:black; border-radius:4px; text-decoration:none;">
                   Edit
                </a>

                <a href="index.php?page=hapus_user&id=<?= $u['id_user'] ?>"
                   onclick="return confirm('Hapus user ini?')"
                   style="padding:6px 10px; background:#dc3545; color:white; border-radius:4px; text-decoration:none;">
                   Hapus
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>

</table>

