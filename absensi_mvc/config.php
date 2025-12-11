<?php
/**
 * Konfigurasi Database
 */

// Setting database
$host = 'localhost';
$dbname = 'absensi_db';
$username = 'root';
$password = ''; // Kosong karena pake XAMPP defualt

try {
    // Koneksi pake PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set error mode biar kalo ada error langsung keliatan
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set fetch mode jadi associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Kalo gagal connect, tampilin error
    die("Koneksi Database Gagal: " . $e->getMessage() . "<br>Cek lagi setting database nya!");
}

?>