<?php
/**
 * Controller Laporan
 * Buat nampilin statistik dan laporan absensi
 */

require_once 'models/Absensi.php';

class LaporanController {
    private $model;
    
    public function __construct($pdo) {
        $this->model = new Absensi($pdo);
    }
    
    // Nampilin halaman laporan
    public function index() {
        // Ambil statistik kehadiran
        $stats = $this->model->getStats();
        
        // Cek apakah ada filter tanggal
        if(isset($_GET['start_date']) && isset($_GET['end_date'])) {
            $startDate = $_GET['start_date'];
            $endDate = $_GET['end_date'];
            $absensi = $this->model->filterByDate($startDate, $endDate);
        } else {
            // Kalo ga ada filter, tampilin semua data
            $absensi = $this->model->getAll(100);
        }
        
        require_once 'views/laporan.php';
    }
}
?>