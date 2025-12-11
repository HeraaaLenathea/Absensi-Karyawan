<?php
/**
 * Controller buat kelola data karyawan
 * Dibuat: 8 Desember
 * Note: Sempet error di bagian validasi NIP, udah di fix
 */

require_once 'models/Karyawan.php';

class KaryawanController {
    private $model;
    private $message = '';
    private $messageType = '';
    
    public function __construct($pdo) {
        $this->model = new Karyawan($pdo);
    }
    
    // Nampilin daftar semua karyawan
    public function index() {
        $karyawan = $this->model->getAll();
        $message = $this->message;
        $messageType = $this->messageType;
        require_once 'views/karyawan.php';
    }
    
    // Form tambah karyawan baru
    public function create() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // ambil data dari form
            $data = [
                'nip' => trim($_POST['nip']),
                'nama' => trim($_POST['nama']),
                'jabatan' => trim($_POST['jabatan']),
                'departemen' => trim($_POST['departemen']),
                'email' => trim($_POST['email'])
            ];
            
            // Validasi - jangan sampe ada yang kosong
            if(empty($data['nip']) || empty($data['nama'])) {
                $this->message = '❌ NIP dan Nama wajib diisi ya!';
                $this->messageType = 'error';
            } 
            // Cek NIP udah ada belom
            elseif($this->model->nipExists($data['nip'])) {
                $this->message = '❌ NIP ini sudah dipake karyawan lain!';
                $this->messageType = 'error';
            } 
            else {
                // Kalo semua oke, simpan ke database
                if($this->model->create($data)) {
                    $_SESSION['message'] = '✅ Yeay! Data karyawan berhasil ditambahkan!';
                    $_SESSION['messageType'] = 'success';
                    header('Location: index.php?page=karyawan');
                    exit;
                } else {
                    $this->message = '❌ Waduh, ada yang error. Coba lagi deh!';
                    $this->messageType = 'error';
                }
            }
        }
        
        $message = $this->message;
        $messageType = $this->messageType;
        require_once 'views/karyawan.php';
    }
    
    // Edit data karyawan yang udah ada
    public function edit() {
        $id = $_GET['id'] ?? null;
        
        // Kalo ga ada ID nya, balik ke halaman utama aja
        if(!$id) {
            header('Location: index.php?page=karyawan');
            exit;
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nip' => trim($_POST['nip']),
                'nama' => trim($_POST['nama']),
                'jabatan' => trim($_POST['jabatan']),
                'departemen' => trim($_POST['departemen']),
                'email' => trim($_POST['email'])
            ];
            
            // Validasi lagi, safety first!
            if(empty($data['nip']) || empty($data['nama'])) {
                $this->message = '❌ NIP dan Nama harus diisi!';
                $this->messageType = 'error';
            } 
            // Pastiin NIP ga bentrok sama karyawan lain (kecuali dirinya sendiri)
            elseif($this->model->nipExists($data['nip'], $id)) {
                $this->message = '❌ NIP sudah digunakan karyawan lain!';
                $this->messageType = 'error';
            } 
            else {
                if($this->model->update($id, $data)) {
                    $_SESSION['message'] = '✅ Data karyawan berhasil diupdate!';
                    $_SESSION['messageType'] = 'success';
                    header('Location: index.php?page=karyawan');
                    exit;
                } else {
                    $this->message = '❌ Gagal update data!';
                    $this->messageType = 'error';
                }
            }
        }
        
        // Ambil data karyawan yang mau di-edit
        $karyawan = $this->model->getById($id);
        if(!$karyawan) {
            // Kalo ga ketemu data nya, redirect
            header('Location: index.php?page=karyawan');
            exit;
        }
        
        $message = $this->message;
        $messageType = $this->messageType;
        require_once 'views/karyawan.php';
    }
    
    // Hapus data karyawan
    public function delete() {
        $id = $_GET['id'] ?? null;
        
        if($id && $this->model->delete($id)) {
            $_SESSION['message'] = '✅ Data karyawan berhasil dihapus!';
            $_SESSION['messageType'] = 'success';
        } else {
            $_SESSION['message'] = '❌ Gagal menghapus data!';
            $_SESSION['messageType'] = 'error';
        }
        
        header('Location: index.php?page=karyawan');
        exit;
    }
}
?>