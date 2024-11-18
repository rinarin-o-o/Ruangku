<?php
session_start();
include('../../koneksi/koneksi.php');

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
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $ukuran_CC = mysqli_real_escape_string($conn, $_POST['ukuran_CC']);
    $no_pabrik = mysqli_real_escape_string($conn, $_POST['no_pabrik']);
    $no_rangka = mysqli_real_escape_string($conn, $_POST['no_rangka']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $no_bpkb = mysqli_real_escape_string($conn, $_POST['no_bpkb']);
    $bahan = mysqli_real_escape_string($conn, $_POST['bahan']);
    $no_mesin = mysqli_real_escape_string($conn, $_POST['no_mesin']);
    $no_polisi = mysqli_real_escape_string($conn, $_POST['no_polisi']);
    $kondisi_barang = mysqli_real_escape_string($conn, $_POST['kondisi_barang']);
    $masa_manfaat = mysqli_real_escape_string($conn, $_POST['masa_manfaat']);
    $harga_awal = mysqli_real_escape_string($conn, $_POST['harga_awal']); // Remove currency formatting
    $harga_total = mysqli_real_escape_string($conn, $_POST['harga_total']); // Remove currency formatting
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    // Check if kode_pemilik exists in pemilik table
    $check_pemilik = "SELECT COUNT(*) AS count FROM pemilik WHERE Kode_pemilik = '$kode_pemilik'";
    $result = mysqli_query($conn, $check_pemilik);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] == 0) {
        $_SESSION['error'] = "Invalid kode pemilik.";
        header('Location: ../../frm_edit_barang.php?kode_barang=' . $kode_barang);
        exit;
    }

    // Handle file upload
    $foto_barang = ""; // Initialize $foto_barang

    if (isset($_FILES['foto_barang']) && $_FILES['foto_barang']['error'] === UPLOAD_ERR_OK) {
        $foto_barang = $_FILES['foto_barang']['name'];
        $target_dir = "../../images/"; // Adjust path according to your directory structure
        $target_file = $target_dir . basename($foto_barang);

        // Validate file type
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $allowed_types)) {
            $_SESSION['error'] = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            header('Location: ../../frm_edit_barang.php?id_barang_pemda=' . $id_barang_pemda);
            exit;
        }

        // Validate file size
        if ($_FILES['foto_barang']['size'] > 5000000) { // Limit file size to 5MB
            $_SESSION['error'] = "File size should not exceed 5MB.";
            header('Location: ../../frm_edit_barang.php?id_barang_pemda=' . $id_barang_pemda);
            exit;
        }

        // Upload file
        if (!move_uploaded_file($_FILES['foto_barang']['tmp_name'], $target_file)) {
            $_SESSION['error'] = "Failed to upload image.";
            header('Location: ../../frm_edit_barang.php?id_barang_pemda=' . $id_barang_pemda);
            exit;
        }
    }

    // Ambil id_ruang_sekarang sebelumnya untuk membandingkan
    $query_before_update = "SELECT id_ruang_sekarang FROM data_barang WHERE id_barang_pemda = '$id_barang_pemda'";
    $result_before_update = mysqli_query($conn, $query_before_update);
    $row_before = mysqli_fetch_assoc($result_before_update);
    $ruang_sekarang_sebelum = $row_before['id_ruang_sekarang'];

    // Update query for data_barang table
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
                   kondisi_barang = '$kondisi_barang',
                   masa_manfaat = '$masa_manfaat',
                   harga_awal = '$harga_awal',
                   harga_total = '$harga_total',
                   keterangan = '$keterangan'";

    // Add photo to query if uploaded
    if ($foto_barang !== "") {
        $sql_update .= ", foto_barang = '$foto_barang'";
    }

    $sql_update .= " WHERE id_barang_pemda = '$id_barang_pemda'";

    // Execute the update query
    if (mysqli_query($conn, $sql_update)) {
        // Memeriksa apakah id_ruang_sekarang telah berubah
        if ($ruang_sekarang_sebelum !== $id_ruang_sekarang) {
            // Menambahkan data mutasi
            $tgl_mutasi = date('Y-m-d H:i:s'); // Waktu saat ini
            $penanggung_jawab = ""; // Placeholder
            $keterangan_mutasi = ""; // Placeholder
            $jenis_mutasi = ""; // Placeholder

            // Membuat ID mutasi baru secara otomatis
            $query_max_id = "SELECT MAX(id_mutasi) AS max_id FROM mutasi_barang";
            $result_max_id = mysqli_query($conn, $query_max_id);
            $row_max_id = mysqli_fetch_assoc($result_max_id);
            $last_id = $row_max_id['max_id'];
            $number = $last_id ? (int)substr($last_id, 3) + 1 : 1; // Increment ID mutasi
            $new_id_mutasi = 'MTS' . str_pad($number, 7, '0', STR_PAD_LEFT); // Format ID

            $sql_ruang_asal = "SELECT * FROM lokasi WHERE id_lokasi = '$ruang_sekarang_sebelum'";
            $result_ruang_asal = mysqli_query($conn, $sql_ruang_asal);
            $row_ruang_asal = mysqli_fetch_assoc($result_ruang_asal);
            $ruang_asal_nama = $row_ruang_asal['id_lokasi'] . ' - ' . $row_ruang_asal['bid_lokasi'] . ' - ' . $row_ruang_asal['tempat_lokasi'];

            // Ambil informasi ruang sekarang
            $sql_ruang_sekarang = "SELECT * FROM lokasi WHERE id_lokasi = '$id_ruang_sekarang'";
            $result_ruang_sekarang = mysqli_query($conn, $sql_ruang_sekarang);
            $row_ruang_sekarang = mysqli_fetch_assoc($result_ruang_sekarang);
            $ruang_sekarang_nama = $row_ruang_sekarang['id_lokasi'] . ' - ' . $row_ruang_sekarang['bid_lokasi'] . ' - ' . $row_ruang_sekarang['tempat_lokasi'];


            // Query untuk menambahkan mutasi
            $query_insert_mutasi = "INSERT INTO mutasi_barang (id_mutasi, id_barang_pemda, kode_barang, nama_barang, ruang_asal, ruang_tujuan, jenis_mutasi, tgl_mutasi, penanggungjawab, keterangan) 
                                    SELECT '$new_id_mutasi', id_barang_pemda, kode_barang, nama_barang, '$ruang_asal_nama', '$ruang_sekarang_nama', '$jenis_mutasi', '$tgl_mutasi', '$penanggung_jawab', '$keterangan_mutasi' 
                                    FROM data_barang 
                                    WHERE id_barang_pemda = '$id_barang_pemda'";

            mysqli_query($conn, $query_insert_mutasi);
        }
        $_SESSION['success'] = "Data barang berhasil diupdate.";
        header('Location: ../../Data_barang.php?id_barang_pemda=' . $id_barang_pemda);
        exit;
    } else {
        $_SESSION['error'] = "Data barang gagal diupdate: " . mysqli_error($conn);
        header('Location: ../../frm_edit_barang.php?id_barang_pemda=' . $id_barang_pemda);
        exit;
    }
}
