<?php include '../template/header.php'; ?>

<h2>Riwayat Peminjaman</h2>
<form method="GET" action="index.php">
    <input type="hidden" name="page" value="laporan">
    <label>Dari Tanggal</label>
    <input type="date" name="start_date">
    <label>Sampai Tanggal</label>
    <input type="date" name="end_date">
    <button type="submit" class="btn">Filter</button>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Peminjam</th>
            <th>Alat</th>
            <th>Jumlah</th>
            <th>Tanggal Peminjaman</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($peminjaman as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['nama_peminjam'] ?></td>
            <td><?= $p['nama_alat'] ?></td>
            <td><?= $p['jumlah_pinjam'] ?></td>
            <td><?= $p['tanggal_pinjam'] ?></td>
            <td><?= $p['status'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../template/footer.php'; ?>