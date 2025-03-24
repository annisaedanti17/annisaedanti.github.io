<?php
session_start();

// 1. Koneksi ke database (sesuaikan dengan konfigurasi Anda)
$conn = new mysqli("localhost", "root", "", "burgerniz"); 
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// 2. Pastikan ada pesanan di session
if (!empty($_SESSION['pesanan'])) {
    // 3. Loop setiap item pesanan
    foreach ($_SESSION['pesanan'] as $item) {
        $nama_burger = $conn->real_escape_string($item['nama_burger']);
        $harga       = $item['harga'];
        $jumlah      = $item['kuantitas'];
        $total_harga = $item['total_harga'];

        // 4. Simpan ke tabel `pesanan`
        $sql = "INSERT INTO pesanan (nama_burger, harga, kuantitas, total_harga)
                VALUES ('$nama_burger', '$harga', '$jumlah', '$total_harga')";
        $conn->query($sql);
    }

    // Tampilkan pesan sukses
    echo "<h2>Pesanan Anda dengan kode {$_SESSION['kode_pesanan']} telah disimpan di database.</h2>";

    // Hapus session agar pesanan kosong kembali
    session_destroy();
} else {
    echo "<h2>Tidak ada pesanan yang harus diproses.</h2>";
}

$conn->close();
?>
<a href="pesanan.php"><button>Kembali ke Daftar Pesanan</button></a>
