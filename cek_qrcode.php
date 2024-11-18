<?php
header('Content-Type: application/json');
include('koneksi/koneksi.php');
$qrcode = $_GET['qrcode']; // Mengambil data QR code dari request

// Cek apakah QR code cocok dengan id_lokasi di tabel lokasi
$queryLokasi = "SELECT id_lokasi FROM lokasi WHERE id_lokasi = '$qrcode'";
$resultLokasi = $mysqli->query($queryLokasi);

if ($resultLokasi && $resultLokasi->num_rows > 0) {
    $row = $resultLokasi->fetch_assoc();
    echo json_encode([
        "isLocation" => true,
        "isItem" => false,
        "id_lokasi" => $row['id_lokasi']
    ]);
    exit();
}

$queryBarang = "SELECT id_barang_pemda FROM data_barang WHERE id_barang_pemda = '$qrcode'";
$resultBarang = $mysqli->query($queryBarang);

if ($resultBarang && $resultBarang->num_rows > 0) {
    $row = $resultBarang->fetch_assoc();
    echo json_encode([
        "isLocation" => false,
        "isItem" => true,
        "id_barang_pemda" => $row['id_barang_pemda']
    ]);
    exit();
}

// Jika tidak ditemukan di kedua tabel
echo json_encode([
    "isLocation" => false,
    "isItem" => false,
    "message" => "QR Code tidak valid."
]);
exit();
?>
