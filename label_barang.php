<?php
session_start();
require('fpdf/fpdf.php'); // Sertakan library FPDF
include 'koneksi/koneksi.php'; // Koneksi ke database

// Mendapatkan id_lokasi dari parameter URL
$id_lokasi = isset($_GET['id_lokasi']) ? $_GET['id_lokasi'] : 0;

// Query untuk mengambil barang berdasarkan id_lokasi
$query = "SELECT b.kode_barang, b.nama_barang, b.kategori, b.merk 
          FROM data_barang b 
          WHERE b.id_ruang_sekarang = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $id_lokasi);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Query untuk mendapatkan nama lokasi
$query_lokasi = "SELECT nama_lokasi FROM lokasi WHERE id_lokasi = ?";
$stmt_lokasi = mysqli_prepare($conn, $query_lokasi);
mysqli_stmt_bind_param($stmt_lokasi, "s", $id_lokasi);
mysqli_stmt_execute($stmt_lokasi);
$nama_ruang = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_lokasi))['nama_lokasi'] ?? '';

// Membuat instance FPDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Header PDF
$pdf->Cell(190, 10, 'Label Barang - ' . $nama_ruang, 0, 1, 'C');
$pdf->Ln(10); // Spasi tambahan

// Loop melalui data barang dan buat label
$pdf->SetFont('Arial', '', 12);
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(50, 10, 'Kode Barang: ' . $row['kode_barang'], 0, 0);
    $pdf->Cell(70, 10, 'Nama: ' . $row['nama_barang'], 0, 1);
    $pdf->Cell(50, 10, 'Kategori: ' . $row['kategori'], 0, 0);
    $pdf->Cell(70, 10, 'Merk: ' . $row['merk'], 0, 1);
    $pdf->Ln(5); // Spasi antara label
}

// Output PDF
$pdf->Output('D', 'Label_Barang_' . $nama_ruang . '.pdf'); // Unduh PDF
?>
