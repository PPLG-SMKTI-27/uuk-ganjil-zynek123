<?php
require_once "app/models/PinjamModel.php";

class PinjamController {

    private $model;

    public function __construct() {
        $this->model = new PinjamModel();
    }

    // Halaman daftar peminjaman
    public function index() {
        $data = $this->model->getAll();
        include "app/views/pinjam/index.php";
    }

    public function pinjam() {
    require_once "app/models/AlatModel.php";
    $alatModel = new AlatModel();

    $alat = $alatModel->getAll();  // AMBIL DATA ALAT UNTUK DROPDOWN

    include "app/views/pinjam/tambah.php";
}


    // Proses pinjam
    public function prosesPinjam() {
        $this->model->pinjam(
            $_POST['id_user'],
            $_POST['id_alat'],
            $_POST['tgl_pinjam'],
            $_POST['tgl_kembali']
        );

        header("Location: index.php?page=pinjam");
    }

    // Proses kembalikan
    public function kembalikan() {
        $this->model->kembalikan($_GET['id']);
        header("Location: index.php?page=pinjam");
    }

    // Hapus peminjaman
    public function hapus() {
        $this->model->hapus($_GET['id']);
        header("Location: index.php?page=pinjam");
    }
}
?>
