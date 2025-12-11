<?php
/**
 * Model Absensi
 * Handle operasi database untuk tabel absensi
 */

class Absensi {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // CREATE - Catat absensi baru
    public function create($data) {
        $sql = "INSERT INTO absensi (karyawan_id, tanggal, jam_masuk, jam_keluar, status, keterangan) 
                VALUES (:karyawan_id, :tanggal, :jam_masuk, :jam_keluar, :status, :keterangan)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
    
    // READ - Ambil semua absensi (pake JOIN biar dapet nama karyawan)
    public function getAll($limit = 50) {
        $sql = "SELECT a.*, k.nip, k.nama, k.jabatan 
                FROM absensi a 
                INNER JOIN karyawan k ON a.karyawan_id = k.id 
                ORDER BY a.tanggal DESC, a.jam_masuk DESC 
                LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // READ - Ambil satu absensi berdasarkan ID
    public function getById($id) {
        $sql = "SELECT * FROM absensi WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    // UPDATE - Edit data absensi
    public function update($id, $data) {
        $sql = "UPDATE absensi 
                SET karyawan_id = :karyawan_id, tanggal = :tanggal, 
                    jam_masuk = :jam_masuk, jam_keluar = :jam_keluar, 
                    status = :status, keterangan = :keterangan 
                WHERE id = :id";
        $data['id'] = $id;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
    
    // DELETE - Hapus absensi
    public function delete($id) {
        $sql = "DELETE FROM absensi WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    // Ambil statistik kehadiran (buat halaman laporan)
    public function getStats() {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) as hadir,
                    SUM(CASE WHEN status = 'Izin' THEN 1 ELSE 0 END) as izin,
                    SUM(CASE WHEN status = 'Sakit' THEN 1 ELSE 0 END) as sakit,
                    SUM(CASE WHEN status = 'Alfa' THEN 1 ELSE 0 END) as alfa
                FROM absensi";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch();
    }
    
    // Filter absensi berdasarkan tanggal (buat fitur filter di laporan)
    public function filterByDate($startDate, $endDate) {
        $sql = "SELECT a.*, k.nip, k.nama 
                FROM absensi a 
                INNER JOIN karyawan k ON a.karyawan_id = k.id 
                WHERE a.tanggal BETWEEN :start AND :end 
                ORDER BY a.tanggal DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['start' => $startDate, 'end' => $endDate]);
        return $stmt->fetchAll();
    }
}
?>