<?php
session_start();

// Pastikan parameter index ada
if (!isset($_GET['index'])) {
    header("Location: pesanan.php");
    exit;
}

$index = $_GET['index'];

// Pastikan item dengan index tersebut ada di session
if (!isset($_SESSION['pesanan'][$index])) {
    header("Location: pesanan.php");
    exit;
}

// Jika form konfirmasi disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        // Hapus item dari session
        unset($_SESSION['pesanan'][$index]);
        $_SESSION['pesanan'] = array_values($_SESSION['pesanan']);
    }
    header("Location: pesanan.php");
    exit;
}

$item = $_SESSION['pesanan'][$index];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus Pesanan</title>
</head>
<body>
    <h2>Konfirmasi Hapus Pesanan</h2>
    <p>Apakah Anda yakin ingin menghapus pesanan untuk: <strong><?php echo htmlspecialchars($item['nama_burger']); ?></strong>?</p>
    <form action="delete.php?index=<?php echo $index; ?>" method="POST">
        <button type="submit" name="confirm" value="yes">Ya, Hapus</button>
        <button type="submit" name="confirm" value="no">Tidak, Batal</button>
    </form>
</body>
</html>
