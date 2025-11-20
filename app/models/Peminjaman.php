<?php
require_once __DIR__ . '/Database.php';

class Peminjaman {
    private $db;
    private $table = 'peminjaman';

    public $id;
    public $user_id;
    public $alat_id;
    public $jumlah;
    public $tanggal_pinjam;
    public $tanggal_kembali;
    public $status;
    public $keterangan;
    public $created_at;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Create Peminjaman
    public function create() {
        $query = "INSERT INTO {$this->table} (user_id, alat_id, jumlah, tanggal_pinjam, tanggal_kembali, status, keterangan) 
                  VALUES (:user_id, :alat_id, :jumlah, :tanggal_pinjam, :tanggal_kembali, :status, :keterangan)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':alat_id', $this->alat_id);
        $stmt->bindParam(':jumlah', $this->jumlah);
        $stmt->bindParam(':tanggal_pinjam', $this->tanggal_pinjam);
        $stmt->bindParam(':tanggal_kembali', $this->tanggal_kembali);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':keterangan', $this->keterangan);

        return $stmt->execute();
    }

    // Read All Peminjaman dengan join
    public function readAll() {
        $query = "SELECT p.*, u.nama as nama_peminjam, u.role, a.nama_alat, a.kode_alat 
                  FROM {$this->table} p 
                  JOIN users u ON p.user_id = u.id 
                  JOIN alat_lab a ON p.alat_id = a.id 
                  ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read Peminjaman by User ID
    public function readByUserId($user_id) {
        $query = "SELECT p.*, u.nama as nama_peminjam, a.nama_alat, a.kode_alat 
                  FROM {$this->table} p 
                  JOIN users u ON p.user_id = u.id 
                  JOIN alat_lab a ON p.alat_id = a.id 
                  WHERE p.user_id = :user_id 
                  ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read Single Peminjaman
    public function readOne() {
        $query = "SELECT p.*, u.nama as nama_peminjam, a.nama_alat, a.kode_alat, a.jumlah_tersedia 
                  FROM {$this->table} p 
                  JOIN users u ON p.user_id = u.id 
                  JOIN alat_lab a ON p.alat_id = a.id 
                  WHERE p.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update Peminjaman
    public function update() {
        $query = "UPDATE {$this->table} SET 
                  alat_id = :alat_id, 
                  jumlah = :jumlah, 
                  tanggal_pinjam = :tanggal_pinjam, 
                  tanggal_kembali = :tanggal_kembali, 
                  status = :status, 
                  keterangan = :keterangan 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':alat_id', $this->alat_id);
        $stmt->bindParam(':jumlah', $this->jumlah);
        $stmt->bindParam(':tanggal_pinjam', $this->tanggal_pinjam);
        $stmt->bindParam(':tanggal_kembali', $this->tanggal_kembali);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':keterangan', $this->keterangan);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Update Status Peminjaman
    public function updateStatus($id, $status) {
        $query = "UPDATE {$this->table} SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Delete Peminjaman
    public function delete() {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Get statistics
    public function getStatistics() {
        $query = "SELECT 
                  COUNT(*) as total_peminjaman,
                  SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                  SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui,
                  SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak,
                  SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as selesai
                  FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>