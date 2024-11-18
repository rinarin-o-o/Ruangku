<?php
session_start();
include('../../koneksi/koneksi.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize POST data
    $id_barang_pemda = $_POST['id_barang_pemda'];
    $nama_barang = $_POST['nama_barang'];
    $no_regristrasi = $_POST['no_regristrasi'];
    $kode_pemilik = $_POST['kode_pemilik'];
    $kode_barang = $_POST['kode_barang'];
    $id_ruang_asal = $_POST['id_ruang_sekarang'];
    $nama_ruang_asal = $_POST['nama_ruang_sekarang'];
    $bidang_ruang_asal = $_POST['bidang_ruang_sekarang'];
    $tempat_ruang_asal = $_POST['tempat_ruang_sekarang'];
    $id_ruang_sekarang = $_POST['id_ruang_sekarang'];
    $nama_ruang_sekarang = $_POST['nama_ruang_sekarang'];
    $bidang_ruang_sekarang = $_POST['bidang_ruang_sekarang'];
    $tempat_ruang_sekarang = $_POST['tempat_ruang_sekarang'];
    $tgl_pembelian = $_POST['tgl_pembelian'];
    $tgl_pembukuan = $_POST['tgl_pembelian'];
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
    $harga_awal = $_POST['harga_awal'];
    $harga_total = $_POST['harga_total'];
    if (empty($harga_total)) {
        $harga_total = 0; // atau bisa juga null jika kolom mendukung NULL
    }
    $keterangan = $_POST['keterangan'];
    $kategori = $_POST['kategori'] ?? null;

    // Handle file upload
    $file_name = null;
    if (isset($_FILES['foto_barang']) && $_FILES['foto_barang']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['foto_barang']['tmp_name'];
        $file_name = basename($_FILES['foto_barang']['name']);
        $upload_dir = '../../images/';
        if (!move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            $_SESSION['error'] = 'Gagal mengunggah foto barang.';
            header('Location: ../../frm_tambah_barang.php');
            exit();
        }
    }

    // Insert data_barang
    $insert_barang_sql = "INSERT INTO data_barang (
        id_barang_pemda, kode_barang, nama_barang, no_regristrasi, kode_pemilik, 
        id_ruang_asal, nama_ruang_asal, bidang_ruang_asal, tempat_ruang_asal, 
        id_ruang_sekarang, nama_ruang_sekarang, bidang_ruang_sekarang, tempat_ruang_sekarang, 
        tgl_pembelian, tgl_pembukuan, merk, type, kategori, ukuran_CC, no_pabrik, 
        no_rangka, no_bpkb, bahan, no_mesin, no_polisi, kondisi_barang, masa_manfaat, 
        harga_awal, harga_total, keterangan, foto_barang
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $insert_barang_sql);
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssssssssssssssssssssss",
        $id_barang_pemda,
        $kode_barang,
        $nama_barang,
        $no_regristrasi,
        $kode_pemilik,
        $id_ruang_asal,
        $nama_ruang_asal,
        $bidang_ruang_asal,
        $tempat_ruang_asal,
        $id_ruang_sekarang,
        $nama_ruang_sekarang,
        $bidang_ruang_sekarang,
        $tempat_ruang_sekarang,
        $tgl_pembelian,
        $tgl_pembukuan,
        $merk,
        $type,
        $kategori,
        $ukuran_CC,
        $no_pabrik,
        $no_rangka,
        $no_bpkb,
        $bahan,
        $no_mesin,
        $no_polisi,
        $kondisi_barang,
        $masa_manfaat,
        $harga_awal,
        $harga_total,
        $keterangan,
        $file_name
    );

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
