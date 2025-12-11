<?php
/**
 * Controller Absensi
 * Ngatur semua logic untuk absensi karyawan
 */

require_once 'models/Absensi.php';
require_once 'models/Karyawan.php';

class AbsensiController {
    private $model;
    private $karyawanModel;
    private $message = '';
    private $messageType = '';
    
    public function __construct($pdo) {
        $this->model = new Absensi($pdo);
        $this->karyawanModel = new Karyawan($pdo);
    }
    
    // Nampilin list absensi
    public function index() {
        $absensi = $this->model->getAll();
        $message = $this->message;
        $messageType = $this->messageType;
        require_once 'views/absensi.php';
    }
    
    // Form tambah + proses simpan absensi
    public function create() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'karyawan_id' => $_POST['karyawan_id'],
                'tanggal' => $_POST['tanggal'],
                'jam_masuk' => !empty($_POST['jam_masuk']) ? $_POST['jam_masuk'] : null,
                'jam_keluar' => !empty($_POST['jam_keluar']) ? $_POST['jam_keluar'] : null,
                'status' => $_POST['status'],
                'keterangan' => trim($_POST['keterangan'])
            ];
            
            // Validasi data penting
            if(empty($data['karyawan_id']) || empty($data['status'])) {
                $this->message = '❌ Karyawan dan Status harus dipilih!';
                $this->messageType = 'error';
            } else {
                if($this->model->create($data)) {
                    $_SESSION['message'] = '✅ Absensi berhasil dicatat!';
                    $_SESSION['messageType'] = 'success';
                    header('Location: index.php?page=absensi');
                    exit;
                } else {
                    $this->message = '❌ Gagal menyimpan absensi!';
                    $this->messageType = 'error';
                }
            }
        }
        
        // Ambil data karyawan buat dropdown
        $karyawan = $this->karyawanModel->getAll();
        $message = $this->message;
        $messageType = $this->messageType;
        require_once 'views/absensi.php';
    }
    
    // Edit absensi
    public function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if(!$id) {
            header('Location: index.php?page=absensi');
            exit;
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'karyawan_id' => $_POST['karyawan_id'],
                'tanggal' => $_POST['tanggal'],
                'jam_masuk' => !empty($_POST['jam_masuk']) ? $_POST['jam_masuk'] : null,
                'jam_keluar' => !empty($_POST['jam_keluar']) ? $_POST['jam_keluar'] : null,
                'status' => $_POST['status'],
                'keterangan' => trim($_POST['keterangan'])
            ];
            
            if($this->model->update($id, $data)) {
                $_SESSION['message'] = '✅ Data absensi berhasil diupdate!';
                $_SESSION['messageType'] = 'success';
                header('Location: index.php?page=absensi');
                exit;
            } else {
                $this->message = '❌ Gagal update data!';
                $this->messageType = 'error';
            }
        }
        
        $absensi = $this->model->getById($id);
        if(!$absensi) {
            header('Location: index.php?page=absensi');
            exit;
        }
        
        $karyawan = $this->karyawanModel->getAll();
        $message = $this->message;
        $messageType = $this->messageType;
        require_once 'views/absensi.php';
    }
    
    // Hapus absensi
    public function delete() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if($id && $this->model->delete($id)) {
            $_SESSION['message'] = '✅ Data absensi berhasil dihapus!';
            $_SESSION['messageType'] = 'success';
        } else {
            $_SESSION['message'] = '❌ Gagal menghapus data!';
            $_SESSION['messageType'] = 'error';
        }
        
        header('Location: index.php?page=absensi');
        exit;
    }
}
?>