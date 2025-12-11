<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi Karyawan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h1>📋 Sistem Absensi Karyawan</h1>
    </div>
    
    <!-- Menu navigasi -->
    <div class="nav">
        <?php $current_page = $_GET['page'] ?? 'karyawan'; ?>
        <a href="index.php?page=karyawan" class="<?= $current_page == 'karyawan' ? 'active' : '' ?>">
            Data Karyawan
        </a>
        <a href="index.php?page=absensi" class="<?= $current_page == 'absensi' ? 'active' : '' ?>">
            Catat Absensi
        </a>
        <a href="index.php?page=laporan" class="<?= $current_page == 'laporan' ? 'active' : '' ?>">
            Laporan
        </a>
    </div>
    
    <!-- Tampilkan pesan kalo ada -->
    <?php
    if(isset($_SESSION['message'])):
        $messageType = $_SESSION['messageType'] ?? 'success';
    ?>
        <div class="alert alert-<?= $messageType ?>">
            <?= $_SESSION['message'] ?>
        </div>
    <?php
        unset($_SESSION['message']);
        unset($_SESSION['messageType']);
    endif;
    
    // Pesan dari variabel lokal
    if(isset($message) && !empty($message)):
    ?>
        <div class="alert alert-<?= $messageType ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>