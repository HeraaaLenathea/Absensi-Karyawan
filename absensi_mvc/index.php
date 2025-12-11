<?php
/**
 * File index.php - Router utama
 * Mengatur halaman mana yang harus ditampilkan
 */

session_start();

// Load database config
require_once 'config.php';

// Ambil parameter page dari URL, default ke karyawan
$page = isset($_GET['page']) ? $_GET['page'] : 'karyawan';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Routing ke controller
try {
    if($page == 'karyawan') {
        require_once 'controllers/KaryawanController.php';
        $controller = new KaryawanController($pdo);
    } 
    elseif($page == 'absensi') {
        require_once 'controllers/AbsensiController.php';
        $controller = new AbsensiController($pdo);
    } 
    elseif($page == 'laporan') {
        require_once 'controllers/LaporanController.php';
        $controller = new LaporanController($pdo);
    } 
    else {
        // Kalo page ga dikenali, redirect ke halaman karyawan
        header('Location: index.php?page=karyawan');
        exit;
    }
    
    // Panggil method action yang diminta
    if(method_exists($controller, $action)) {
        $controller->$action();
    } else {
        // Kalo action ga ada, jalanin index
        $controller->index();
    }
    
} catch(Exception $e) {
    // Kalo ada error, tampilin pesan
    echo "<h3>Error:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<a href='index.php'>Kembali ke halaman utama</a>";
}
?>