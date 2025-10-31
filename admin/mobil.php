<?php
require '../config/database.php';
require '../includes/functions.php';

// Proses tambah mobil
if (isset($_POST['tambah'])) {
    if (tambah_mobil($_POST, $conn)) {
        echo "<script>alert('Mobil berhasil ditambahkan'); window.location='mobil.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan mobil');</script>";
    }
}
// Proses hapus mobil
if (isset($_GET['hapus'])) {
    $id_mobil = $_GET['hapus'];
    if (hapus_mobil($id_mobil, $conn)) {
        echo "<script>alert('Mobil berhasil dihapus'); window.location='mobil.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus mobil');</script>";
    }
}

// Proses edit mobil bisa ditambahkan nanti
if (isset($_POST['edit'])) {
    if (edit_mobil($_POST, $conn)) {
        echo "<script>alert('Mobil berhasil diupdate'); window.location='mobil.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate mobil');</script>";
    }
}

// Ambil data mobil
$daftar_mobil = getAll('mobil');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Mobil</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Data Mobil</h1>

    <!-- Form Tambah Mobil -->
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="nama_mobil" placeholder="Nama Mobil" required>
        <input type="text" name="plat_nomor" placeholder="Plat Nomor" required>
        <input type="number" name="harga_sewa" placeholder="Harga Sewa per Hari" required>
        <input type="file" name="gambar" accept="image/*">
        <button type="submit" name="tambah">Tambah Mobil</button>
    </form>

    <!-- Tabel Data Mobil -->
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>NO</th>
                <th>Nama Mobil</th>
                <th>Plat Nomor</th>
                <th>Harga Sewa</th>
                <th>Status</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($daftar_mobil as $mobil): ?>
            <tr>
                <td data-label = "No"><?= $i ?></td>
                
                <td data-label="Nama Mobil"><?= htmlspecialchars($mobil['nama_mobil']) ?></td>
                <td data-label="Plat Nomor"><?= htmlspecialchars($mobil['plat_nomor']) ?></td>
                <td data-label="Harga Sewa"><?= htmlspecialchars(number_format($mobil['harga_sewa'], 0, ',', '.')) ?></td>
                <td data-label="Status"><?= htmlspecialchars($mobil['status']) ?></td>
                <td data-label="Gambar">
                    <?php if($mobil['gambar']): ?>
                        <img src="../assets/img/<?= $mobil['gambar'] ?>" width="100">
                    <?php endif; ?>
                </td>
                <td data-label="Aksi">
                    <a href="mobil.php?hapus=<?= $mobil['id_mobil'] ?>" onclick="return confirm('Hapus mobil ini?')">Hapus</a>
                    <a href="edit_mobil.php?id=<?= $mobil['id_mobil'] ?>">Edit</a>
                </td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>