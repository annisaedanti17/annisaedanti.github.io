<?php
// File: koneksi.php
// Kode untuk menghubungkan ke database
$host = "localhost";
$user = "root"; // Sesuaikan dengan user database-mu
$pass = "";     // Sesuaikan dengan password database-mu
$db   = "burgerniz"; // Sesuaikan dengan nama database-mu

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
