<?php
session_start();
include('../../koneksi/koneksi.php');

// Pastikan parameter id_barang_pemda ada di URL
if (isset($_GET['id_barang_pemda'])) {
    $id_barang_pemda = mysqli_real_escape_string($conn, $_GET['id_barang_pemda']);

    // Query untuk menghapus data dari tabel data_barang
    $sql = "DELETE FROM data_barang WHERE id_barang_pemda = '$id_barang_pemda'";

    if (mysqli_query($conn, $sql)) {
        // Setelah berhasil menghapus, redirect ke halaman data_barang dengan pesan sukses
        $_SESSION['message'] = "Data barang berhasil dihapus.";
        header('Location: ../../Data_barang.php');
        exit();
    } else {
        // Jika gagal menghapus, tampilkan pesan error
        $_SESSION['error'] = "Gagal menghapus data data_barang: " . mysqli_error($conn);
        header('Location: ../../Data_barang.php');
        exit();
    }
} else {
    // Jika id_barang_pemda tidak ditemukan, redirect dengan pesan error
    $_SESSION['error'] = "ID data_barang tidak ditemukan.";
    header('Location: ../../Data_barang.php');
    exit();
}
?>
