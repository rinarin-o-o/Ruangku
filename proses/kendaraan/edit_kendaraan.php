<?php
session_start();
include('../../koneksi/koneksi.php');

// Function to generate ID automatically with prefix
function generateId($prefix, $table, $column)
{
    global $conn;
    $query = "SELECT MAX($column) AS last_id FROM $table";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Get the last ID and extract the numeric part
    $last_id = $row['last_id'];
    $numeric_part = (int)substr($last_id, strlen($prefix));

    // Increment by 1 and return the new ID with prefix
    $new_id = $prefix . str_pad($numeric_part + 1, 10, '0', STR_PAD_LEFT);
    return $new_id;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize POST data
    $id_barang_pemda = mysqli_real_escape_string($conn, $_POST['id_barang_pemda']);
    $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $no_regristrasi = mysqli_real_escape_string($conn, $_POST['no_regristrasi']);
    $kode_pemilik = mysqli_real_escape_string($conn, $_POST['kode_pemilik']);
    $kode_barang = mysqli_real_escape_string($conn, $_POST['kode_barang']);
    $id_ruang_asal = mysqli_real_escape_string($conn, $_POST['id_ruang_asal']);
    $nama_ruang_asal = mysqli_real_escape_string($conn, $_POST['nama_ruang_asal']);
    $bidang_ruang_asal = mysqli_real_escape_string($conn, $_POST['bidang_ruang_asal']);
    $tempat_ruang_asal = mysqli_real_escape_string($conn, $_POST['tempat_ruang_asal']);
    $id_ruang_sekarang = mysqli_real_escape_string($conn, $_POST['id_ruang_sekarang']);
    $nama_ruang_sekarang = mysqli_real_escape_string($conn, $_POST['nama_ruang_sekarang']);
    $bidang_ruang_sekarang = isset($_POST['bid_ruang_sekarang']) ? mysqli_real_escape_string($conn, $_POST['bid_ruang_sekarang']) : '';
    $tempat_ruang_sekarang = mysqli_real_escape_string($conn, $_POST['tempat_ruang_sekarang']);
    $tgl_pembelian = mysqli_real_escape_string($conn, $_POST['tgl_pembelian']);
    $tgl_pembukuan = mysqli_real_escape_string($conn, $_POST['tgl_pembukuan']);
    $merk = mysqli_real_escape_string($conn, $_POST['merk']);
    $type = isset($_POST['type']) ? mysqli_real_escape_string($conn, $_POST['type']) : '';
    $ukuran_CC = isset($_POST['ukuran_CC']) ? mysqli_real_escape_string($conn, $_POST['ukuran_CC']) : '';
    $no_pabrik = isset($_POST['no_pabrik']) ? mysqli_real_escape_string($conn, $_POST['no_pabrik']) : '';
    $no_rangka = isset($_POST['no_rangka']) ? mysqli_real_escape_string($conn, $_POST['no_rangka']) : '';
    $bahan = isset($_POST['bahan']) ? mysqli_real_escape_string($conn, $_POST['bahan']) : '';
    $no_mesin = isset($_POST['no_mesin']) ? mysqli_real_escape_string($conn, $_POST['no_mesin']) : '';
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $no_bpkb = mysqli_real_escape_string($conn, $_POST['no_bpkb']);
    $no_polisi = mysqli_real_escape_string($conn, $_POST['no_polisi']);
    $masa_stnk = mysqli_real_escape_string($conn, $_POST['masa_stnk']);
    $tgl_bayar_no_polisi = mysqli_real_escape_string($conn, $_POST['tgl_bayar_no_polisi']);
    $tgl_bayar_stnk = mysqli_real_escape_string($conn, $_POST['tgl_bayar_stnk']);
    $masa_no_polisi = mysqli_real_escape_string($conn, $_POST['masa_no_polisi']);
    $status_stnk = mysqli_real_escape_string($conn, $_POST['status_stnk']);
    $status_no_polisi = mysqli_real_escape_string($conn, $_POST['status_no_polisi']);
    $pengguna = mysqli_real_escape_string($conn, $_POST['pengguna']);
    $kondisi_barang = mysqli_real_escape_string($conn, $_POST['kondisi_barang']);
    $masa_manfaat = mysqli_real_escape_string($conn, $_POST['masa_manfaat']);
    $harga_awal = mysqli_real_escape_string($conn, $_POST['harga_awal']); // Remove currency formatting
    $harga_total = mysqli_real_escape_string($conn, $_POST['harga_total']); // Remove currency formatting
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    // Handle file upload
    $foto_barang = ""; // Initialize $foto_barang
    if (isset($_FILES['foto_barang']) && $_FILES['foto_barang']['error'] === UPLOAD_ERR_OK) {
        $foto_barang = $_FILES['foto_barang']['name'];
        $target_dir = "../../assets/images/";
        $target_file = $target_dir . basename($foto_barang);

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $allowed_types)) {
            $_SESSION['error'] = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            header('Location: ../../frm_edit_barang.php?id_barang_pemda=' . $id_barang_pemda);
            exit;
        }

        if ($_FILES['foto_barang']['size'] > 5000000) { // Limit file size to 5MB
            $_SESSION['error'] = "File size should not exceed 5MB.";
            header('Location: ../../frm_edit_barang.php?id_barang_pemda=' . $id_barang_pemda);
            exit;
        }

        if (!move_uploaded_file($_FILES['foto_barang']['tmp_name'], $target_file)) {
            $_SESSION['error'] = "Failed to upload image.";
            header('Location: ../../frm_edit_barang.php?id_barang_pemda=' . $id_barang_pemda);
            exit;
        }
    }
    // Generate ID for 'id_bayar_stnk' (e.g., STNK0000000001)
    $id_bayar_stnk = generateId('STNK', 'bukti_bayar_stnk', 'id_bayar_stnk');

    // Generate ID for 'no_polisi' (e.g., PLAT0000000001)
    $id_bayar_no_polisi = generateId('PLAT', 'bukti_bayar_no_polisi', 'id_bayar_no_polisi');

    // Get the current date
    $current_date = new DateTime();

    // Initialize new statuses and dates
    $new_status_stnk = $status_stnk;
    $new_status_no_polisi = $status_no_polisi;
    $new_masa_stnk = $masa_stnk;
    $new_masa_no_polisi = $masa_no_polisi;

    // Check the current status for STNK
    if ($status_stnk == 'Lunas') {
        $masa_stnk_date = new DateTime($masa_stnk);
        // Change status to 'Belum Lunas' one month before the masa_stnk expiration
        if ($current_date->diff($masa_stnk_date)->days <= 30) {
            $new_status_stnk = 'Belum Lunas';
        }
    }

    // Check the current status for No Polisi
    if ($status_no_polisi == 'Aktif') {
        $masa_no_polisi_date = new DateTime($masa_no_polisi);
        // Change status to 'Belum Lunas' one month before the masa_no_polisi expiration
        if ($current_date->diff($masa_no_polisi_date)->days <= 30) {
            $new_status_no_polisi = 'Tidak Aktif';
        }
    }

    // Check if photo is uploaded for STNK (Belum Lunas -> Lunas)
    if ($status_stnk == 'Belum Lunas' && isset($_FILES['foto_stnk']) && $_FILES['foto_stnk']['error'] == 0) {
        // Upload file
        $foto_stnk_name = $_FILES['foto_stnk']['name'];
        $foto_stnk_tmp_name = $_FILES['foto_stnk']['tmp_name'];
        $foto_stnk_path = "assets/images/" . $foto_stnk_name;
        move_uploaded_file($foto_stnk_tmp_name, $foto_stnk_path);

        // Update status and masa for STNK
        $new_status_stnk = "Lunas";
        // Mengambil tanggal masa_no_polisi yang sudah ada
        $masa_stnk_date = new DateTime($masa_stnk);

        // Menambahkan 5 tahun ke masa_stnk
        $new_masa_stnk = $masa_stnk_date->modify('+1 years')->format('Y-m-d');


        // Insert payment into bukti_bayar_stnk
        $sql_bukti_stnk = "INSERT INTO bukti_bayar_stnk (id_bayar_stnk, id_barang_pemda, tgl_bayar_stnk, foto_stnk) 
                            VALUES ('$id_bayar_stnk','$id_barang_pemda', NOW(), '$foto_stnk_path')";
        mysqli_query($conn, $sql_bukti_stnk);
    }

    // Check if photo is uploaded for No Polisi (Belum Lunas -> Lunas)
    if ($status_no_polisi == 'Tidak Aktif' && isset($_FILES['foto_no_polisi']) && $_FILES['foto_no_polisi']['error'] == 0) {
        // Upload file
        $foto_no_polisi_name = $_FILES['foto_no_polisi']['name'];
        $foto_no_polisi_tmp_name = $_FILES['foto_no_polisi']['tmp_name'];
        $foto_no_polisi_path = "assets/images/" . $foto_no_polisi_name;
        move_uploaded_file($foto_no_polisi_tmp_name, $foto_no_polisi_path);

        // Update status and masa for No Polisi
        $new_status_no_polisi = "Aktif";
        // Mengambil tanggal masa_no_polisi yang sudah ada
        $masa_no_polisi_date = new DateTime($masa_no_polisi);

        // Menambahkan 5 tahun ke masa_no_polisi
        $new_masa_no_polisi = $masa_no_polisi_date->modify('+5 years')->format('Y-m-d');


        // Insert payment into bukti_bayar_no_polisi
        $sql_bukti_no_polisi = "INSERT INTO bukti_bayar_no_polisi (id_bayar_no_polisi, id_barang_pemda, tgl_bayar_no_polisi, foto_no_polisi) 
                                 VALUES ('$id_bayar_no_polisi','$id_barang_pemda', NOW(), '$foto_no_polisi_path')";
        mysqli_query($conn, $sql_bukti_no_polisi);
    }

    $id_mutasi_kendaraan = generateId('KDRN', 'mutasi_kendaraan', 'id_mutasi_kendaraan');

    $sql_old_user = "SELECT pengguna FROM data_barang WHERE id_barang_pemda = '$id_barang_pemda'";
    $result_old_user = mysqli_query($conn, $sql_old_user);
    $row_old_user = mysqli_fetch_assoc($result_old_user);
    $pengguna_lama = $row_old_user['pengguna'];

    // Jika pengguna berubah, catat ke tabel mutasi_kendaraan
    if ($pengguna_lama !== $pengguna) {
        $id_mutasi_kendaraan = generateId('KDRN', 'mutasi_kendaraan', 'id_mutasi_kendaraan');
        $tgl_mutasi_kendaraan = date('Y-m-d');
        $keterangan_mutasi = "Perubahan pengguna dari $pengguna_lama ke $pengguna";

        $sql_mutasi = "INSERT INTO mutasi_kendaraan 
                       (id_mutasi_kendaraan, id_barang_pemda, tgl_mutasi_kendaraan, pengguna_lama, pengguna_sekarang) 
                       VALUES ('$id_mutasi_kendaraan', '$id_barang_pemda', '$tgl_mutasi_kendaraan', '$pengguna_lama', '$pengguna')";

        if (!mysqli_query($conn, $sql_mutasi)) {
            $_SESSION['error'] = "Gagal mencatat mutasi kendaraan: " . mysqli_error($conn);
            header('Location: ../../frm_edit_kendaraan.php?id_barang_pemda=' . $id_barang_pemda);
            exit;
        }
    }
    // Update data in database
    $sql_update = "UPDATE data_barang SET
                   id_barang_pemda = '$id_barang_pemda',
                   nama_barang = '$nama_barang',
                   no_regristrasi = '$no_regristrasi',
                   kode_pemilik = '$kode_pemilik',
                   id_ruang_asal = '$id_ruang_asal',
                   nama_ruang_asal = '$nama_ruang_asal',
                   bidang_ruang_asal = '$bidang_ruang_asal',
                   tempat_ruang_asal = '$tempat_ruang_asal',
                   id_ruang_sekarang = '$id_ruang_sekarang',
                   nama_ruang_sekarang = '$nama_ruang_sekarang',
                   bidang_ruang_sekarang = '$bidang_ruang_sekarang',
                   tempat_ruang_sekarang = '$tempat_ruang_sekarang',
                   tgl_pembelian = '$tgl_pembelian',
                   tgl_pembukuan = '$tgl_pembukuan',
                   merk = '$merk',
                   type = '$type',
                   ukuran_CC = '$ukuran_CC',
                   no_pabrik = '$no_pabrik',
                   no_rangka = '$no_rangka',
                   no_bpkb = '$no_bpkb',
                   kategori = '$kategori',
                   bahan = '$bahan',
                   no_mesin = '$no_mesin',
                   no_polisi = '$no_polisi',
                   masa_stnk = '$new_masa_stnk',
                   masa_no_polisi = '$new_masa_no_polisi',
                   tgl_bayar_stnk = '$tgl_bayar_stnk',
                   tgl_bayar_no_polisi = '$tgl_bayar_no_polisi',
                   status_stnk = '$new_status_stnk',
                   status_no_polisi = '$new_status_no_polisi',
                   pengguna = '$pengguna',
                   kondisi_barang = '$kondisi_barang',
                   masa_manfaat = '$masa_manfaat',
                   harga_awal = '$harga_awal',
                   harga_total = '$harga_total',
                   keterangan = '$keterangan'";

    if ($foto_barang !== "") {
        $sql_update .= ", foto_barang = '$foto_barang'";
    }

    $sql_update .= " WHERE id_barang_pemda = '$id_barang_pemda'";

    // Execute the update query
    if (mysqli_query($conn, $sql_update)) {
        $_SESSION['success'] = "Data barang berhasil diupdate.";
        header('Location: ../../kendaraan.php?id_barang_pemda=' . $id_barang_pemda);
        exit;
    } else {
        $_SESSION['error'] = "Data barang gagal diupdate: " . mysqli_error($conn);
        header('Location: ../../frm_edit_kendaraan.php?id_barang_pemda=' . $id_barang_pemda);
        exit;
    }
}
