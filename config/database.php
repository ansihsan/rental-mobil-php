<?php
$host = "localhost";
$user = "root"; // ganti kalau username MySQL kamu berbeda
$pass = ""; // isi password MySQL kamu (biasanya kosong di localhost)
$db   = "rentalmobil_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
