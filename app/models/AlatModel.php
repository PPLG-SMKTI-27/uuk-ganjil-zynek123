<?php
require_once "config/database.php";

class AlatModel {
    private $koneksi;

    public function __construct() {
        $db = new Database();
        $this->koneksi = $db->connect();
    }

    public function getAll() {
        return $this->koneksi->query("SELECT * FROM alat");
    }

    public function getById($id) {
        $id = (int)$id;
        $res = $this->koneksi->query("SELECT * FROM alat WHERE id_alat = $id");
        return $res->fetch_assoc();
    }

    public function tambah($nama, $desk, $jumlah) {
        $nama = $this->koneksi->real_escape_string($nama);
        $desk = $this->koneksi->real_escape_string($desk);
        $jumlah = (int)$jumlah;
        return $this->koneksi->query("INSERT INTO alat (nama_alat, deskripsi, jumlah) VALUES ('$nama', '$desk', $jumlah)");
    }

    public function update($id, $nama, $desk, $jumlah) {
        $id = (int)$id;
        $nama = $this->koneksi->real_escape_string($nama);
        $desk = $this->koneksi->real_escape_string($desk);
        $jumlah = (int)$jumlah;
        return $this->koneksi->query("UPDATE alat SET nama_alat='$nama', deskripsi='$desk', jumlah=$jumlah WHERE id_alat = $id");
    }

    public function hapus($id) {
        $id = (int)$id;
        return $this->koneksi->query("DELETE FROM alat WHERE id_alat = $id");
    }
}
?>