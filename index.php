<?php
session_start();

require_once "app/controllers/AlatController.php";
require_once "app/controllers/PinjamController.php";
require_once "app/controllers/AuthController.php";
require_once "app/controllers/UserController.php";

$user = new UserController();
$alat   = new AlatController();
$pinjam = new PinjamController();
$auth   = new AuthController();

$page = $_GET['page'] ?? 'login';

switch ($page) {

    // LOGIN
    case 'login':
        $auth->login();
        break;

    case 'prosesLogin':
        $auth->prosesLogin();
        break;

    case 'logout':
        $auth->logout();
        break;


    // ADMIN DASHBOARD
    case 'dashboard_admin':
        include "app/role/admin.php";
        break;


    // GURU DASHBOARD
    case 'dashboard_guru':
        include "app/role/guru.php";
        break;


    // SISWA DASHBOARD
    case 'dashboard_siswa':
        include "app/role/siswa.php";
        break;


    // FITUR ALAT
    case 'index':
        $alat->index();
        break;

    case 'tambah':
        $alat->tambah();
        break;

    case 'proses_tambah':
        $alat->prosesTambah();
        break;

    case 'edit':
        $alat->edit();
        break;

    case 'proses_edit':
        $alat->prosesEdit();
        break;

    case 'hapus':
        $alat->hapus();
        break;


    // FITUR PINJAM
    case 'pinjam':
        $pinjam->index();
        break;

    case 'tambah_pinjam':
        $pinjam->pinjam();
        break;

    case 'proses_pinjam':
        $pinjam->prosesPinjam();
        break;

    case 'kembalikan':
        $pinjam->kembalikan();
        break;

    case 'hapus_pinjam':
        $pinjam->hapus();
        break;

    // BUHAN USER
    case 'kelola_user':
    $user->index();
    break;

    case 'tambah_user':
    $user->tambah();
    break;

    case 'proses_tambah_user':
    $user->prosesTambah();
    break;

    case 'edit_user':
    $user->edit();
    break;

    case 'proses_edit_user':
    $user->prosesEdit();
    break;

    case 'hapus_user':
    $user->hapus();
    break;

    // 404
    default:
        echo "<h2>404 — Halaman Tidak Ada</h2>";
        break;
}