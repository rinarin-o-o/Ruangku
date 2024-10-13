<?php
ob_start(); // Start output buffering
session_start();
include('../../koneksi/koneksi.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize POST data
    $id_barang_pemda = $_POST['id_barang_pemda'];
    $nama_barang = $_POST['nama_barang'];
    $no_registrasi = $_POST['no_registrasi'];
    $kode_pemilik = $_POST['kode_pemilik'];
    $kode_barang = $_POST['kode_barang'];
    $id_ruang_asal = $_POST['id_ruang_asal'];
    $nama_ruang_asal = $_POST['nama_ruang_asal'];
    $bidang_ruang_asal = $_POST['bidang_ruang_asal'];
    $tempat_ruang_asal = $_POST['tempat_ruang_asal'];
    $id_ruang_sekarang = $_POST['id_ruang_sekarang'];
    $nama_ruang_sekarang = $_POST['nama_ruang_sekarang'];
    $bidang_ruang_sekarang = $_POST['bidang_ruang_sekarang'];
    $tempat_ruang_sekarang = $_POST['tempat_ruang_sekarang'];
    $tgl_pembelian = $_POST['tgl_pembelian'];
    $tgl_pembukuan = $_POST['tgl_pembukuan'];
    $merk = $_POST['merk'];
    $type = $_POST['type'];
    $ukuran_CC = $_POST['ukuran_CC'];
    $no_pabrik = $_POST['no_pabrik'];
    $no_rangka = $_POST['no_rangka'];
    $no_bpkb = $_POST['no_bpkb'];
    $bahan = $_POST['bahan'];
    $no_mesin = $_POST['no_mesin'];
    $no_polisi = $_POST['no_polisi'];
    $kondisi_barang = $_POST['kondisi_barang'];
    $masa_manfaat = $_POST['masa_manfaat'];
    $harga_awal = $_POST['harga_awal']; // Remove currency formatting
    $harga_total =$_POST['harga_total']; // Remove currency formatting
    $keterangan = $_POST['keterangan'];
    $kategori = $_POST['kategori'] ?? null; // Menambahkan kategori jika ada

    // Handle file upload
    $file_name = null;
    if (isset($_FILES['foto_barang']) && $_FILES['foto_barang']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['foto_barang']['tmp_name'];
        $file_name = basename($_FILES['foto_barang']['name']);
        $upload_dir = '../../images/'; // Make sure this directory exists
        if (!move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            $_SESSION['error'] = 'Gagal mengunggah foto barang.';
            header('Location: ../../frm_tambah_barang.php');
            exit();
        }
    }

    // Check if kode_pemilik exists in pemilik table
    $check_kode_pemilik_sql = "SELECT COUNT(*) as count FROM pemilik WHERE kode_pemilik=?";
    $stmt = mysqli_prepare($conn, $check_kode_pemilik_sql);
    mysqli_stmt_bind_param($stmt, "s", $kode_pemilik);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // If kode_pemilik does not exist, add to pemilik table
    if ($count == 0) {
        if (empty($_POST['nama_pemilik'])) {
            $_SESSION['error'] = 'Kode Pemilik baru, harap masukkan Nama Pemilik.';
            header('Location: ../../frm_tambah_barang.php');
            exit();
        }
        $nama_pemilik = $_POST['nama_pemilik'];

        // Insert new pemilik
        $insert_pemilik_sql = "INSERT INTO pemilik (kode_pemilik, nama_pemilik) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insert_pemilik_sql);
        mysqli_stmt_bind_param($stmt, "ss", $kode_pemilik, $nama_pemilik);
        if (!mysqli_stmt_execute($stmt)) {
            $_SESSION['error'] = 'Gagal menambahkan pemilik baru: ' . mysqli_error($conn);
            header('Location: ../../frm_tambah_barang.php');
            exit();
        }
        mysqli_stmt_close($stmt);
    }

    // Insert data_barang (with kode_pemilik as foreign key)
    $insert_barang_sql = "INSERT INTO data_barang (id_barang_pemda, kode_barang, nama_barang, no_registrasi, kode_pemilik, id_ruang_asal, nama_ruang_asal, bidang_ruang_asal, tempat_ruang_asal, 
            id_ruang_sekarang, nama_ruang_sekarang, bidang_ruang_sekarang, tempat_ruang_sekarang, 
            tgl_pembelian, tgl_pembukuan, merk, type, kategori, ukuran_CC, no_pabrik, 
            no_rangka, no_bpkb, bahan, no_mesin, no_polisi, kondisi_barang, masa_manfaat, harga_awal, harga_total, foto_barang) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $insert_barang_sql);
    mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssssssssss", 
        $id_barang_pemda, $kode_barang, $nama_barang, $no_registrasi, $kode_pemilik, 
        $id_ruang_asal, $nama_ruang_asal, $bidang_ruang_asal, $tempat_ruang_asal, 
        $id_ruang_sekarang, $nama_ruang_sekarang, $bidang_ruang_sekarang, 
        $tempat_ruang_sekarang, $tgl_pembelian, $tgl_pembukuan, 
        $merk, $type, $kategori, $ukuran_CC, 
        $no_pabrik, $no_rangka, $no_bpkb, $bahan, $no_mesin, 
        $no_polisi, $kondisi_barang, $masa_manfaat, 
        $harga_awal, $harga_total, $file_name);

    // Execute the insert query
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = 'Data barang dan pemilik berhasil disimpan.';
        header('Location: ../../Data_barang.php');
        exit();
    } else {
        $_SESSION['error'] = 'Error: ' . mysqli_error($conn);
        header('Location: ../../frm_tambah_barang.php');
        exit();
    }
    
    mysqli_stmt_close($stmt);
}
?>
