<?php require_once 'views/header.php'; ?>

<div class="container">
    <h2>Laporan Absensi</h2>
    
    <!-- Statistik Kehadiran -->
    <div class="stats">
        <div class="stat-card">
            <h3><?= $stats['total'] ?></h3>
            <p>Total Absensi</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
            <h3><?= $stats['hadir'] ?></h3>
            <p>Hadir</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
            <h3><?= $stats['izin'] ?></h3>
            <p>Izin</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #17a2b8 0%, #00bcd4 100%);">
            <h3><?= $stats['sakit'] ?></h3>
            <p>Sakit</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #dc3545 0%, #e91e63 100%);">
            <h3><?= $stats['alfa'] ?></h3>
            <p>Alfa</p>
        </div>
    </div>
    
    <!-- Filter Tanggal -->
    <div class="container" style="background-color: #f8f9fa; margin-bottom: 20px;">
        <h3>Filter Berdasarkan Tanggal</h3>
        <form method="GET" action="index.php">
            <input type="hidden" name="page" value="laporan">
            <div style="display: flex; gap: 15px; align-items: flex-end;">
                <div class="form-group" style="flex: 1;">
                    <label>Dari Tanggal:</label>
                    <input type="date" name="start_date" class="form-control" 
                           value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Sampai Tanggal:</label>
                    <input type="date" name="end_date" class="form-control" 
                           value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="index.php?page=laporan" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Tabel Riwayat Absensi -->
    <h3>Riwayat Absensi</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIP</th>
                <th>Nama Karyawan</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($absensi)): ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data untuk ditampilkan</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach($absensi as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                    <td><?= $row['nip'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['jam_masuk'] ?: '-' ?></td>
                    <td><?= $row['jam_keluar'] ?: '-' ?></td>
                    <td>
                        <span class="badge badge-<?= strtolower($row['status']) ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                    <td><?= $row['keterangan'] ?: '-' ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'views/footer.php'; ?>