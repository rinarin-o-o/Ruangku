<?php
include('../../koneksi/koneksi.php');

// Cek apakah request menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_pemilik_baru = $_POST['kode_pemilik_baru'];
    $nama_pemilik_baru = $_POST['nama_pemilik_baru'];

    // Validasi input
    if (!empty($kode_pemilik_baru) && !empty($nama_pemilik_baru)) {
        // Query untuk menambah pemilik baru ke database
        $sql = "INSERT INTO pemilik (kode_pemilik, nama_pemilik) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $kode_pemilik_baru, $nama_pemilik_baru);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false]);
    }
}

mysqli_close($conn);
?>
