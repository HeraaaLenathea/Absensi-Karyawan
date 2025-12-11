<?php
/**
 * Model Karyawan
 * Buat ngatur semua operasi database tabel karyawan
 */

class Karyawan {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // CREATE - Tambah karyawan baru
    public function create($data) {
        try {
            $sql = "INSERT INTO karyawan (nip, nama, jabatan, departemen, email) 
                    VALUES (:nip, :nama, :jabatan, :departemen, :email)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch(PDOException $e) {
            // Kalo error (misalnya NIP duplicate), return false
            return false;
        }
    }
    
    // READ - Ambil semua data karyawan
    public function getAll() {
        $sql = "SELECT * FROM karyawan ORDER BY nama ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    
    // READ - Ambil satu karyawan berdasarkan ID
    public function getById($id) {
        $sql = "SELECT * FROM karyawan WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    // UPDATE - Edit data karyawan
    public function update($id, $data) {
        try {
            $sql = "UPDATE karyawan 
                    SET nip = :nip, nama = :nama, jabatan = :jabatan, 
                        departemen = :departemen, email = :email 
                    WHERE id = :id";
            $data['id'] = $id;
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    // DELETE - Hapus karyawan
    public function delete($id) {
        $sql = "DELETE FROM karyawan WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    // Cek apakah NIP sudah ada atau belum
    public function nipExists($nip, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM karyawan WHERE nip = :nip";
        if($excludeId) {
            $sql .= " AND id != :id";
        }
        $stmt = $this->pdo->prepare($sql);
        $params = ['nip' => $nip];
        if($excludeId) {
            $params['id'] = $excludeId;
        }
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}
?>