<?php
session_start();
include('../../koneksi/koneksi.php');

// Pastikan parameter id_pemeliharaan ada di URL
if (isset($_GET['id_pemeliharaan'])) {
    $id_pemeliharaan = mysqli_real_escape_string($conn, $_GET['id_pemeliharaan']);

    // Query untuk mengambil biaya_perbaikan dan id_barang_pemda
    $sql_select = "SELECT biaya_perbaikan, id_barang_pemda FROM data_pemeliharaan WHERE id_pemeliharaan = '$id_pemeliharaan'";
    $result = mysqli_query($conn, $sql_select);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $biaya_perbaikan = $row['biaya_perbaikan'];
        $id_barang_pemda = $row['id_barang_pemda'];

        // Query untuk menghapus data dari tabel data_pemeliharaan
        $sql_delete = "DELETE FROM data_pemeliharaan WHERE id_pemeliharaan = '$id_pemeliharaan'";

        if (mysqli_query($conn, $sql_delete)) {
            // Update harga_total di data_barang
            $sql_update = "UPDATE data_barang SET harga_total = harga_total - $biaya_perbaikan WHERE id_barang_pemda = '$id_barang_pemda'";
            mysqli_query($conn, $sql_update);

            // Setelah berhasil menghapus, redirect ke halaman Data_pemeliharaan.php dengan pesan sukses
            $_SESSION['message'] = "Data pemeliharaan berhasil dihapus dan harga total diperbarui.";
            header('Location: ../../Data_pemeliharaan.php');
            exit();
        } else {
            // Jika gagal menghapus, tampilkan pesan error
            $_SESSION['error'] = "Gagal menghapus data pemeliharaan: " . mysqli_error($conn);
            header('Location: ../../Data_pemeliharaan.php');
            exit();
        }
    } else {
        // Jika tidak ada data pemeliharaan ditemukan
        $_SESSION['error'] = "Data pemeliharaan tidak ditemukan.";
        header('Location: ../../Data_pemeliharaan.php');
        exit();
    }
} else {
    // Jika id_pemeliharaan tidak ditemukan, redirect dengan pesan error
    $_SESSION['error'] = "ID Pemeliharaan tidak ditemukan.";
    header('Location: ../../Data_pemeliharaan.php');
    exit();
}
?>
