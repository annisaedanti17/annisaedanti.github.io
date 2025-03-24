<?php
header('Content-Type: application/json');
// submitContact.php

include 'koneksi.php';

// Tangkap data GET (real_escape_string mencegah SQL Injection)
$nama  = isset($_GET['nama']) ? $koneksi->real_escape_string($_GET['nama']) : '';
$email = isset($_GET['email']) ? $koneksi->real_escape_string($_GET['email']) : '';
$pesan = isset($_GET['pesan']) ? $koneksi->real_escape_string($_GET['pesan']) : '';

// Validasi sederhana
if (empty($nama) || empty($email) || empty($pesan)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Semua field harus diisi.'
    ]);
    exit;
}

// Simpan ke database
$sql = "INSERT INTO kontak (nama, email, pesan) VALUES ('$nama', '$email', '$pesan')";

if (mysqli_query($koneksi, $sql)) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Pesan berhasil dikirim. Terima kasih!'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Gagal mengirim pesan, silakan coba lagi.'
    ]);
}

exit;
?>
