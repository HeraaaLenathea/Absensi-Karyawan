<?php require_once 'views/header.php'; ?>

<div class="container">
    <?php
    $action = isset($_GET['action']) ? $_GET['action'] : 'index';
    
    // FORM TAMBAH / EDIT ABSENSI
    if($action == 'create' || $action == 'edit'):
        $isEdit = ($action == 'edit');
        $pageTitle = $isEdit ? 'Edit Data Absensi' : 'Catat Absensi Baru';
    ?>
        <h2><?= $pageTitle ?></h2>
        
        <form method="POST" action="index.php?page=absensi&action=<?= $action ?><?= $isEdit ? '&id='.$absensi['id'] : '' ?>">
            <div class="form-group">
                <label>Pilih Karyawan:</label>
                <select name="karyawan_id" class="form-control" required>
                    <option value="">-- Pilih Karyawan --</option>
                    <?php foreach($karyawan as $k): ?>
                        <option value="<?= $k['id'] ?>" <?= ($isEdit && $absensi['karyawan_id'] == $k['id']) ? 'selected' : '' ?>>
                            <?= $k['nip'] ?> - <?= $k['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Tanggal:</label>
                <input type="date" name="tanggal" class="form-control" 
                       value="<?= $isEdit ? $absensi['tanggal'] : date('Y-m-d') ?>" required>
            </div>
            
            <div class="form-group">
                <label>Jam Masuk:</label>
                <input type="time" name="jam_masuk" class="form-control" 
                       value="<?= $isEdit ? $absensi['jam_masuk'] : '' ?>">
                <small>Kosongkan jika tidak hadir</small>
            </div>
            
            <div class="form-group">
                <label>Jam Keluar:</label>
                <input type="time" name="jam_keluar" class="form-control" 
                       value="<?= $isEdit ? $absensi['jam_keluar'] : '' ?>">
                <small>Kosongkan jika belum pulang</small>
            </div>
            
            <div class="form-group">
                <label>Status Kehadiran:</label>
                <select name="status" class="form-control" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Hadir" <?= ($isEdit && $absensi['status']=='Hadir') ? 'selected' : '' ?>>Hadir</option>
                    <option value="Izin" <?= ($isEdit && $absensi['status']=='Izin') ? 'selected' : '' ?>>Izin</option>
                    <option value="Sakit" <?= ($isEdit && $absensi['status']=='Sakit') ? 'selected' : '' ?>>Sakit</option>
                    <option value="Alfa" <?= ($isEdit && $absensi['status']=='Alfa') ? 'selected' : '' ?>>Alfa</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Keterangan (opsional):</label>
                <textarea name="keterangan" class="form-control" rows="3"><?= $isEdit ? $absensi['keterangan'] : '' ?></textarea>
            </div>
            
            <button type="submit" class="btn <?= $isEdit ? 'btn-success' : 'btn-primary' ?>">
                <?= $isEdit ? 'Update Data' : 'Simpan Absensi' ?>
            </button>
            <a href="index.php?page=absensi" class="btn btn-secondary">Batal</a>
        </form>
        
    <?php else: ?>
        <!-- TAMPILAN LIST ABSENSI -->
        <h2>Data Absensi</h2>
        
        <div class="mb-20">
            <a href="index.php?page=absensi&action=create" class="btn btn-primary">
                + Catat Absensi
            </a>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($absensi)): ?>
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data absensi</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach($absensi as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                        <td><?= $row['nip'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['jabatan'] ?></td>
                        <td><?= $row['jam_masuk'] ?: '-' ?></td>
                        <td><?= $row['jam_keluar'] ?: '-' ?></td>
                        <td>
                            <span class="badge badge-<?= strtolower($row['status']) ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        <td>
                            <a href="index.php?page=absensi&action=edit&id=<?= $row['id'] ?>" 
                               class="btn btn-warning btn-sm">Edit</a>
                            <a href="index.php?page=absensi&action=delete&id=<?= $row['id'] ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Yakin ingin menghapus data ini?')">
                               Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
    <?php endif; ?>
</div>

<?php require_once 'views/footer.php'; ?>