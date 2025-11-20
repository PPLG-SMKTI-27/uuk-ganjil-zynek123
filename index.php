<?php
session_start();

// Path yang benar berdasarkan debug
$controllers_path = __DIR__ . '/app/controllers';

if (!is_dir($controllers_path)) {
    die("ERROR: Folder controllers tidak ditemukan di: $controllers_path");
}

// Function untuk load controller
function loadController($name) {
    global $controllers_path;
    $file = $controllers_path . '/' . $name . '.php';
    
    if (file_exists($file)) {
        require_once $file;
        
        // Pastikan class exists
        if (class_exists($name)) {
            return new $name();
        } else {
            die("ERROR: Class $name tidak ditemukan di file: $file");
        }
    } else {
        die("ERROR: Controller file tidak ditemukan: $file");
    }
}

// Routing
$page = $_GET['page'] ?? 'auth';
$action = $_GET['action'] ?? 'login';
$id = $_GET['id'] ?? null;

// Tambahkan DashboardController ke routing
switch ($page) {
    case 'auth':
        $controller = loadController('AuthController');
        break;
    case 'alat':
        $controller = loadController('AlatController');
        break;
    case 'peminjaman':
        $controller = loadController('PeminjamanController');
        break;
    case 'user':
        $controller = loadController('UserController');
        break;
    case 'dashboard':
        $controller = loadController('DashboardController');
        break;
    default:
        $controller = loadController('AuthController');
        $action = 'login';
        break;
}

// Execute action
if ($id) {
    if (method_exists($controller, $action)) {
        $controller->$action($id);
    } else {
        $controller->index();
    }
} else {
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        $controller->index();
    }
}
?>