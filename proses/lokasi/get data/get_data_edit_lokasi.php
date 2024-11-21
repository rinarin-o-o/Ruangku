<?php
ob_start();
include('koneksi/koneksi.php');

if (!isset($_GET['id_lokasi'])) {
    header('Location: lokasi.php');
    exit;
}

$id_lokasi = $_GET['id_lokasi'];
$sql = "SELECT * FROM lokasi WHERE id_lokasi = '$id_lokasi'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
} else {
    header('Location: lokasi.php');
    exit;
}
?>