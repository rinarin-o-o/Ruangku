<?php
session_start();
include('../../koneksi/koneksi.php');

// Pastikan parameter id_jadwal_ruang ada di URL
if (isset($_GET['id_jadwal_ruang'])) {
    $id_jadwal_ruang = mysqli_real_escape_string($conn, $_GET['id_jadwal_ruang']);

    // Query untuk menghapus data dari tabel lokasi
    $sql = "DELETE FROM jadwal_ruang WHERE id_jadwal_ruang = '$id_jadwal_ruang'";

    if (mysqli_query($conn, $sql)) {
        // Setelah berhasil menghapus, redirect ke halaman lokasi dengan pesan sukses
        $_SESSION['message'] = "Data berhasil dihapus.";
        header('Location: ../../jadwal_ruang.php');
        exit();
    } else {
        // Jika gagal menghapus, tampilkan pesan error
        $_SESSION['error'] = "Gagal menghapus data lokasi: " . mysqli_error($conn);
        header('Location: ../../jadwal_ruang.php');
        exit();
    }
} else {
    // Jika id_jadwal_ruang tidak ditemukan, redirect dengan pesan error
    $_SESSION['error'] = "ID Lokasi tidak ditemukan.";
    header('Location: ../../jadwal_ruang.php');
    exit();
}
?>
