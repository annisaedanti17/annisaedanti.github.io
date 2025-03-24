<?php
session_start();
session_destroy(); // Menghapus seluruh session (termasuk pesanan & kode_pesanan)
header("Location: pesanan.php"); // Kembali ke halaman pesanan
exit;
