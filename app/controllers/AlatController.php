<?php
require_once "app/models/AlatModel.php";

class AlatController {

    private $model;

    public function __construct() {
        $this->model = new AlatModel();
    }

    public function index() {
        $data = $this->model->getAll();
        include "app/views/alat/index.php";
    }

    public function tambah() {
        include "app/views/alat/tambah.php";
    }

  public function prosesTambah() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?page=tambah");
        exit;
    }

    $nama   = $_POST['nama_alat'] ?? '';
    $desk   = $_POST['deskripsi'] ?? '';
    $jumlah = $_POST['jumlah'] ?? 0;

    if ($nama === '' || $desk === '' || $jumlah === '') {
        echo "<script>alert('Semua field harus diisi!'); window.location='index.php?page=tambah';</script>";
        exit;
    }

    $this->model->tambah($nama, $desk, $jumlah);

    header("Location: index.php");
    exit;
}


    public function edit() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $alat = $this->model->getById($id);

        if (!$alat) {
            echo "Data tidak ditemukan!";
            exit;
        }

        include "app/views/alat/edit.php";
    }

   public function prosesEdit() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php");
        exit;
    }

    $id     = $_POST['id_alat'];
    $nama   = $_POST['nama_alat'];
    $desk   = $_POST['deskripsi'];
    $jumlah = $_POST['jumlah'];

    $this->model->update($id, $nama, $desk, $jumlah);

    header("Location: index.php");
    exit;
}

    public function hapus() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->model->hapus($id);
        header("Location: index.php");
        exit;
    }
}
?>
