<?php
require_once __DIR__ . "/../models/UserModel.php";

class UserController {

    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    // Menampilkan semua user
    public function index() {
        $users = $this->model->getAll();
        include __DIR__ . "/../views/users/list.php";
    }

    // Halaman tambah user
    public function tambah() {
        include __DIR__ . "/../views/users/tambah.php";
    }

    // Proses tambah user
    public function prosesTambah() {
        $this->model->tambah($_POST['nama'], $_POST['username'], $_POST['password'], $_POST['role']);
        header("Location: index.php?page=kelola_user");
    }

    // Halaman edit
    public function edit() {
        $id = $_GET['id'];
        $user = $this->model->getById($id);
        include __DIR__ . "/../views/user/edit.php";
    }

    // Proses Edit
    public function prosesEdit() {
        $this->model->update($_POST['id_user'], $_POST['nama'], $_POST['username'], $_POST['password'], $_POST['role']);
        header("Location: index.php?page=kelola_user");
    }

    // Hapus user
    public function hapus() {
        $this->model->hapus($_GET['id']);
        header("Location: index.php?page=kelola_user");
    }
}
?>