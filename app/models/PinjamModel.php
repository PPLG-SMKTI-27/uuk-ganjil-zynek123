<?php
require_once "config/database.php";

class PinjamModel {

    private $koneksi;

    public function __construct() {
        $db = new Database();
        $this->koneksi = $db->connect();
    }

    // Ambil semua data peminjaman
    public function getAll() {
        return $this->koneksi->query("
            SELECT p.*, u.nama AS nama_user, a.nama_alat
            FROM peminjaman p
            LEFT JOIN users u ON p.id_user = u.id_user
            LEFT JOIN alat a ON p.id_alat = a.id_alat
        ");
    }

    // Tambah peminjaman
    public function pinjam($id_user, $id_alat, $tgl_pinjam, $tgl_kembali) {
        return $this->koneksi->query("
            INSERT INTO peminjaman (id_user, id_alat, tgl_pinjam, tgl_kembali, status)
            VALUES ('$id_user', '$id_alat', '$tgl_pinjam', '$tgl_kembali', 'dipinjam')
        ");
    }

    // Kembalikan
    public function kembalikan($id_pinjam) {
        $id = (int)$id_pinjam;
        return $this->koneksi->query("
            UPDATE peminjaman SET status = 'dikembalikan'
            WHERE id_pinjam = $id
        ");
    }

    // Hapus
    public function hapus($id_pinjam) {
        $id = (int)$id_pinjam;
        return $this->koneksi->query("
            DELETE FROM peminjaman WHERE id_pinjam = $id
        ");
    }
}
?>
