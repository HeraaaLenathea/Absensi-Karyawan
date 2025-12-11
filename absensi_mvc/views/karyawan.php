<?php require_once 'views/header.php'; ?>

<div class="container">
    <?php
    $action = $_GET['action'] ?? 'index';
    
    // FORM TAMBAH / EDIT
    if($action == 'create' || $action == 'edit'):
        $isEdit = ($action == 'edit');
        $pageTitle = $isEdit ? 'Edit Data Karyawan' : 'Tambah Karyawan Baru';
        $buttonText = $isEdit ? 'Update Data' : 'Simpan Data';
    ?>
        <h2><?= $pageTitle ?></h2>
        
        <form method="POST" action="index.php?page=karyawan&action=<?= $action ?><?= $isEdit ? '&id='.$karyawan['id'] : '' ?>">
            <div class="form-group">
                <label>NIP (Nomor Induk Pegawai):</label>
                <input type="text" name="nip" class="form-control" 
                       value="<?= $isEdit ? htmlspecialchars($karyawan['nip']) : '' ?>" 
                       placeholder="Contoh: K001" required>
            </div>
            
            <div class="form-group">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama" class="form-control" 
                       value="<?= $isEdit ? htmlspecialchars($karyawan['nama']) : '' ?>" 
                       placeholder="Nama lengkap karyawan" required>
            </div>
            
            <div class="form-group">
                <label>Jabatan:</label>
                <input type="text" name="jabatan" class="form-control" 
                       value="<?= $isEdit ? htmlspecialchars($karyawan['jabatan']) : '' ?>" 
                       placeholder="Contoh: Manager, Staff" required>
            </div>
            
            <div class="form-group">
                <label>Departemen:</label>
                <input type="text" name="departemen" class="form-control" 
                       value="<?= $isEdit ? htmlspecialchars($karyawan['departemen']) : '' ?>" 
                       placeholder="Contoh: IT, Finance" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" 
                       value="<?= $isEdit ? htmlspecialchars($karyawan['email']) : '' ?>" 
                       placeholder="email@example.com" required>
            </div>
            
            <button type="submit" class="btn <?= $isEdit ? 'btn-success' : 'btn-primary' ?>">
                <?= $buttonText ?>
            </button>
            <a href="index.php?page=karyawan" class="btn btn-secondary">Batal</a>
        </form>
        
    <?php else: ?>
        <!-- TAMPILAN LIST KARYAWAN -->
        <h2>Data Karyawan</h2>
        
        <div class="mb-20">
            <a href="index.php?page=karyawan&action=create" class="btn btn-primary">
                + Tambah Karyawan
            </a>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Departemen</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($karyawan)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data karyawan</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach($karyawan as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nip']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['jabatan']) ?></td>
                        <td><?= htmlspecialchars($row['departemen']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td>
                            <a href="index.php?page=karyawan&action=edit&id=<?= $row['id'] ?>" 
                               class="btn btn-warning btn-sm">Edit</a>
                            <a href="index.php?page=karyawan&action=delete&id=<?= $row['id'] ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Yakin ingin menghapus data <?= htmlspecialchars($row['nama']) ?>?')">
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