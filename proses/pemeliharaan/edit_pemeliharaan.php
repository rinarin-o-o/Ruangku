<?php
session_start();
include('../../koneksi/koneksi.php'); // Include DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dengan validasi dasar
    $id_pemeliharaan = mysqli_real_escape_string($conn, $_POST['id_pemeliharaan']);

    // Validasi untuk id_barang_pemda
    if (!isset($_POST['id_barang_pemda'])) {
        $_SESSION['error'] = "ID Barang Pemda tidak ditemukan.";
        header('Location: ../../Data_pemeliharaan.php');
        exit;
    }

    $id_barang_pemda = mysqli_real_escape_string($conn, $_POST['id_barang_pemda']);
    $kode_barang = mysqli_real_escape_string($conn, $_POST['kode_barang']);
    $desk_pemeliharaan = mysqli_real_escape_string($conn, $_POST['desk_pemeliharaan']);
    $perbaikan = mysqli_real_escape_string($conn, $_POST['perbaikan']);
    $tgl_perbaikan = mysqli_real_escape_string($conn, $_POST['tgl_perbaikan']);   
    $lama_perbaikan = mysqli_real_escape_string($conn, $_POST['lama_perbaikan']);
    $biaya_perbaikan = (int) $_POST['biaya_perbaikan']; // Pastikan ini angka dan tidak perlu tanda kutip

    // Ambil biaya_perbaikan sebelumnya untuk menghitung selisih
    $sql_select = "SELECT biaya_perbaikan FROM data_pemeliharaan WHERE id_pemeliharaan ='$id_pemeliharaan'";
    $result = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_assoc($result);
    $biaya_lama = $row['biaya_perbaikan'];

    // Update data pemeliharaan
    $sql_update = "UPDATE data_pemeliharaan SET 
        desk_pemeliharaan ='$desk_pemeliharaan', 
        perbaikan = '$perbaikan', 
        tgl_perbaikan = '$tgl_perbaikan', 
        lama_perbaikan = '$lama_perbaikan', 
        biaya_perbaikan = '$biaya_perbaikan' 
    WHERE id_pemeliharaan ='$id_pemeliharaan'";

    if (mysqli_query($conn, $sql_update)) {
        // Hitung selisih biaya
        $selisih_biaya = $biaya_perbaikan - $biaya_lama;

        // Update harga_total di data_barang
        $sql_update_barang = "UPDATE data_barang SET harga_total = harga_total + $selisih_biaya WHERE id_barang_pemda = '$id_barang_pemda'";
        mysqli_query($conn, $sql_update_barang);

        $_SESSION['success'] = true;
        // Redirect to Data_pemeliharaan.php after update
        header('Location: ../../Data_pemeliharaan.php');
        exit;
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
        header('Location: ../../Data_pemeliharaan.php?id_barang_pemda=' . $id_barang_pemda);
        exit;
    }
} else {
    // Redirect to the location list page if accessed directly
    header('Location: ../../Data_pemeliharaan.php');
    exit;
}
?>
