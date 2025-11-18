<?php
require_once "config/database.php";

class UserModel {

    private $koneksi;

    public function __construct() {
        $db = new Database();
        $this->koneksi = $db->connect();
    }

    // Ambil semua user
    public function getAll() {
        return $this->koneksi->query("SELECT * FROM users ORDER BY id_user DESC");
    }

    // Ambil user berdasarkan ID
    public function getById($id) {
        $id = (int)$id;
        return $this->koneksi->query("SELECT * FROM users WHERE id_user = $id")->fetch_assoc();
    }

    // AMBIL USER BERDASARKAN USERNAME (DIPAKAI LOGIN)
    public function getByUsername($username) {
        $username = $this->koneksi->real_escape_string($username);
        return $this->koneksi->query("
            SELECT * FROM users 
            WHERE username = '$username'
            LIMIT 1
        ");
    }

    // Tambah user baru
    public function tambah($nama, $username, $password, $role) {

        $nama     = $this->koneksi->real_escape_string($nama);
        $username = $this->koneksi->real_escape_string($username);
        $password = $this->koneksi->real_escape_string($password);
        $role     = $this->koneksi->real_escape_string($role);

        return $this->koneksi->query("
            INSERT INTO users (nama, username, password, role)
            VALUES ('$nama', '$username', '$password', '$role')
        ");
    }

    // Edit user
    public function update($id, $nama, $username, $password, $role) {

        $id       = (int)$id;
        $nama     = $this->koneksi->real_escape_string($nama);
        $username = $this->koneksi->real_escape_string($username);
        $password = $this->koneksi->real_escape_string($password);
        $role     = $this->koneksi->real_escape_string($role);

        return $this->koneksi->query("
            UPDATE users SET 
            nama='$nama',
            username='$username',
            password='$password',
            role='$role'
            WHERE id_user = $id
        ");
    }

    // Hapus user
    public function hapus($id) {
        $id = (int)$id;
        return $this->koneksi->query("DELETE FROM users WHERE id_user = $id");
    }
}
?>