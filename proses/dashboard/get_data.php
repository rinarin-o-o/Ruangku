<?php
include('koneksi/koneksi.php');
//KENDARAAN
$queryKendaraan = "SELECT COUNT(*) AS total_kendaraan 
                   FROM data_barang 
                   WHERE kategori = 'Barang Bergerak (Kendaraan)'";
$resultKendaraan = mysqli_query($conn, $queryKendaraan);
if (!$resultKendaraan) {
  die('Query Error: ' . mysqli_error($conn));
}
$rowKendaraan = mysqli_fetch_assoc($resultKendaraan);
$totalKendaraan = $rowKendaraan['total_kendaraan'];

// RUANGAN
$queryRuang = "SELECT COUNT(*) AS total_ruang 
              FROM lokasi 
              WHERE LOWER(TRIM(kategori_lokasi)) = 'ruangan'";
$resultRuang = mysqli_query($conn, $queryRuang);
if (!$resultRuang) {
    die('Query Error: ' . mysqli_error($conn));
}
$rowRuang = mysqli_fetch_assoc($resultRuang);
$totalRuang = $rowRuang['total_ruang'];

// BARANG
$queryBarang = "SELECT COUNT(*) AS total_barang FROM data_barang";
$resultBarang = mysqli_query($conn, $queryBarang);
if (!$resultBarang) {
    die('Query Error: ' . mysqli_error($conn));
}
$rowBarang = mysqli_fetch_assoc($resultBarang);
$totalBarang = $rowBarang['total_barang'];
?>