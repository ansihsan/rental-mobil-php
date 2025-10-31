<?php

require '../config/database.php';
require '../includes/functions.php';

// Ambil ID mobil dari URL
if (!isset($_GET['id'])) {
    echo "<script>alert('ID mobil tidak ditemukan'); window.location='mobil.php';</script>";
    exit;
}

$id_mobil = $_GET['id'];
$mobil = getById('mobil', 'id_mobil', $id_mobil);
if (!$mobil) {
    echo "<script>alert('Data mobil tidak ditemukan'); window.location='mobil.php';</script>";
    exit;
}

// Proses edit mobil
if (isset($_POST['edit'])) {
    if (edit_mobil($_POST, $conn)) {
        echo "<script>alert('Mobil berhasil diupdate'); window.location='mobil.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate mobil');</script>";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Mobil</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        form {
            width: 50%;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        img {
            margin-top: 10px;
            width: 120px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Edit Data Mobil</h2>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_mobil" value="<?= $mobil['id_mobil']; ?>">

        <label>Nama Mobil</label>
        <input type="text" name="nama_mobil" value="<?= htmlspecialchars($mobil['nama_mobil']); ?>" required>

        <label>Plat Nomor</label>
        <input type="text" name="plat_nomor" value="<?= htmlspecialchars($mobil['plat_nomor']); ?>" required>

        <label>Harga Sewa per Hari</label>
        <input type="number" name="harga_sewa" value="<?= htmlspecialchars($mobil['harga_sewa']); ?>" required>

        <label>Status</label>
        <select name="status" required>
            <option value="Tersedia" <?= $mobil['status'] === 'Tersedia' ? 'selected' : ''; ?>>Tersedia</option>
            <option value="Disewa" <?= $mobil['status'] === 'Disewa' ? 'selected' : ''; ?>>Disewa</option>
            <option value="Perawatan" <?= $mobil['status'] === 'Perawatan' ? 'selected' : ''; ?>>Perawatan</option>
        </select>

        <label>Gambar</label>
        <input type="file" name="gambar" accept="image/*">
        <?php if($mobil['gambar']): ?>
            <img src="../assets/img/<?= $mobil['gambar']; ?>" alt="Gambar Mobil">
        <?php endif; ?>

        <button type="submit" name="edit">Simpan Perubahan</button>
    </form>
</body>
</html>