<?php
require_once __DIR__ . '/Database.php';

class Alat {
    private $db;
    private $table = 'alat_lab';

    public $id;
    public $nama_alat;
    public $kode_alat;
    public $deskripsi;
    public $jumlah_total;
    public $jumlah_tersedia;
    public $kondisi;
    public $created_at;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Create Alat
    public function create() {
        $query = "INSERT INTO {$this->table} (nama_alat, kode_alat, deskripsi, jumlah_total, jumlah_tersedia, kondisi) 
                  VALUES (:nama_alat, :kode_alat, :deskripsi, :jumlah_total, :jumlah_tersedia, :kondisi)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':nama_alat', $this->nama_alat);
        $stmt->bindParam(':kode_alat', $this->kode_alat);
        $stmt->bindParam(':deskripsi', $this->deskripsi);
        $stmt->bindParam(':jumlah_total', $this->jumlah_total);
        $stmt->bindParam(':jumlah_tersedia', $this->jumlah_tersedia);
        $stmt->bindParam(':kondisi', $this->kondisi);

        return $stmt->execute();
    }

    // Read All Alat
    public function readAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read Single Alat
    public function readOne() {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update Alat
    public function update() {
        $query = "UPDATE {$this->table} SET 
                  nama_alat = :nama_alat, 
                  kode_alat = :kode_alat, 
                  deskripsi = :deskripsi, 
                  jumlah_total = :jumlah_total, 
                  jumlah_tersedia = :jumlah_tersedia, 
                  kondisi = :kondisi 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':nama_alat', $this->nama_alat);
        $stmt->bindParam(':kode_alat', $this->kode_alat);
        $stmt->bindParam(':deskripsi', $this->deskripsi);
        $stmt->bindParam(':jumlah_total', $this->jumlah_total);
        $stmt->bindParam(':jumlah_tersedia', $this->jumlah_tersedia);
        $stmt->bindParam(':kondisi', $this->kondisi);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete Alat
    public function delete() {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Update jumlah tersedia
    public function updateJumlahTersedia($id, $jumlah) {
        $query = "UPDATE {$this->table} SET jumlah_tersedia = :jumlah WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':jumlah', $jumlah);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Check if kode alat exists
    public function kodeAlatExists($kode_alat) {
        $query = "SELECT id FROM {$this->table} WHERE kode_alat = :kode_alat";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':kode_alat', $kode_alat);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }
}
?>