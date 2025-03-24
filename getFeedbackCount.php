<?php
header('Content-Type: application/json');
include 'koneksi.php';

$sql = "SELECT COUNT(*) AS total FROM kontak";
$result = mysqli_query($koneksi, $sql);
$row = mysqli_fetch_assoc($result);

echo json_encode(['total' => $row['total']]);
?>
