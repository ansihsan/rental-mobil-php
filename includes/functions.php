<?php
require '../config/database.php';

function tambah_mobil($data, $conn) {
    $nama_mobil = mysqli_real_escape_string($conn, $data['nama_mobil']);
    $plat_nomor = mysqli_real_escape_string($conn, $data['plat_nomor']);
    $harga_sewa = mysqli_real_escape_string($conn, $data['harga_sewa']);
    
    // Proses upload gambar
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../assets/img/';
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $filename = basename($_FILES['gambar']['name']);
        $target_file = $upload_dir . $filename;
        
        if (move_uploaded_file($tmp_name, $target_file)) {
            $gambar = $filename;
        }
    }
    
    $query = "INSERT INTO mobil (nama_mobil, plat_nomor, harga_sewa, status, gambar) 
              VALUES ('$nama_mobil', '$plat_nomor', '$harga_sewa', 'Tersedia', '$gambar')";
    
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function getAll($table) {
    global $conn;

    // Amankan nama tabel (hindari injection)
    $allowed_tables = ['mobil', 'pelanggan', 'transaksi']; 
    if (!in_array($table, $allowed_tables)) {
        return []; // jika nama tabel tidak diizinkan, kembalikan array kosong
    }

    $query = "SELECT * FROM $table ORDER BY id_mobil DESC";
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

// Ambil data berdasarkan ID

function getById($table, $id_field, $id_value) {
    global $conn;

    $query = "SELECT * FROM $table WHERE $id_field = '$id_value' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}


function hapus_mobil($id_mobil, $conn) {
    // Ambil data mobil untuk hapus gambar juga
    $mobil = getById('mobil', 'id_mobil', $id_mobil);
    if ($mobil && $mobil['gambar']) {
        $path = "../assets/img/" . $mobil['gambar'];
        if (file_exists($path)) {
            unlink($path); // hapus gambar
        }
    }

    $query = "DELETE FROM mobil WHERE id_mobil = '$id_mobil'";
    return mysqli_query($conn, $query);
}

function edit_mobil($data, $conn) {
    $id_mobil = mysqli_real_escape_string($conn, $data['id_mobil']);
    $nama_mobil = mysqli_real_escape_string($conn, $data['nama_mobil']);
    $plat_nomor = mysqli_real_escape_string($conn, $data['plat_nomor']);
    $harga_sewa = mysqli_real_escape_string($conn, $data['harga_sewa']);
    $status = mysqli_real_escape_string($conn, $data['status']);

    // Ambil data lama
    $mobil = getById('mobil', 'id_mobil', $id_mobil);
    $gambar = $mobil['gambar'];

    // Cek jika user upload gambar baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        // Hapus gambar lama
        if ($gambar && file_exists("../assets/img/" . $gambar)) {
            unlink("../assets/img/" . $gambar);
        }

        // Simpan gambar baru
        $nama_file = time() . '_' . basename($_FILES['gambar']['name']);
        $target_path = "../assets/img/" . $nama_file;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_path)) {
            $gambar = $nama_file;
        }
    }

    $query = "UPDATE mobil 
              SET nama_mobil = '$nama_mobil',
                  plat_nomor = '$plat_nomor',
                  harga_sewa = '$harga_sewa',
                  status = '$status',
                  gambar = '$gambar'
              WHERE id_mobil = '$id_mobil'";

    return mysqli_query($conn, $query);
}