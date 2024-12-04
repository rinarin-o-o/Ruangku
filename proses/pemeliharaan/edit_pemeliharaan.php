<?php
session_start();
include('../../koneksi/koneksi.php'); // Include DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dengan validasi dasar
    $id_pemeliharaan = mysqli_real_escape_string($conn, $_POST['id_pemeliharaan']);
    $id_barang_pemda = mysqli_real_escape_string($conn, $_POST['id_barang_pemda']);
    $kode_barang = mysqli_real_escape_string($conn, $_POST['kode_barang']);
    $desk_pemeliharaan = mysqli_real_escape_string($conn, $_POST['desk_pemeliharaan']);
    $perbaikan = mysqli_real_escape_string($conn, $_POST['perbaikan']);
    $tgl_perbaikan = mysqli_real_escape_string($conn, $_POST['tgl_perbaikan']);
    $lama_perbaikan = mysqli_real_escape_string($conn, $_POST['lama_perbaikan']);
    $biaya_perbaikan = (int)$_POST['biaya_perbaikan'];

    // File upload logic
    $upload_dir = '../../uploads/pemeliharaan/';
    $bukti_transaksi = $_FILES['bukti_transaksi'];
    $new_file_name = '';

    if (!empty($bukti_transaksi['name'])) {
        $file_tmp = $bukti_transaksi['tmp_name'];
        $file_name = $bukti_transaksi['name'];
        $file_size = $bukti_transaksi['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];

        // Validasi tipe file dan ukuran file
        if (!in_array($file_ext, $allowed_extensions)) {
            $_SESSION['error'] = "Tipe file tidak diizinkan. Harap unggah file dengan format JPG, PNG, PDF, DOC, atau DOCX.";
            header('Location: ../../frm_edit_pemeliharaan.php?id_pemeliharaan=' . $id_pemeliharaan);
            exit;
        }

        if ($file_size > 2 * 1024 * 1024) { // 2MB
            $_SESSION['error'] = "Ukuran file terlalu besar. Maksimal 2MB.";
            header('Location: ../../frm_edit_pemeliharaan.php?id_pemeliharaan=' . $id_pemeliharaan);
            exit;
        }

        // Nama file unik
        $new_file_name = uniqid() . '.' . $file_ext;

        // Pindahkan file ke folder upload
        if (!move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
            $_SESSION['error'] = "Gagal mengunggah file. Silakan coba lagi.";
            header('Location: ../../frm_edit_pemeliharaan.php?id_pemeliharaan=' . $id_pemeliharaan);
            exit;
        }

        // Hapus file lama jika ada
        $sql_old_file = "SELECT bukti_transaksi FROM data_pemeliharaan WHERE id_pemeliharaan = '$id_pemeliharaan'";
        $result_old_file = mysqli_query($conn, $sql_old_file);
        if ($result_old_file && $row_old_file = mysqli_fetch_assoc($result_old_file)) {
            $old_file_path = $upload_dir . $row_old_file['bukti_transaksi'];
            if (!empty($row_old_file['bukti_transaksi']) && file_exists($old_file_path)) {
                unlink($old_file_path);
            }
        }
    }

    // Update data pemeliharaan
    $sql_update = "UPDATE data_pemeliharaan SET 
        desk_pemeliharaan = '$desk_pemeliharaan', 
        perbaikan = '$perbaikan', 
        tgl_perbaikan = '$tgl_perbaikan', 
        lama_perbaikan = '$lama_perbaikan', 
        biaya_perbaikan = '$biaya_perbaikan'";

    // Tambahkan kolom file jika ada file baru
    if (!empty($new_file_name)) {
        $sql_update .= ", bukti_transaksi = '$new_file_name'";
    }

    $sql_update .= " WHERE id_pemeliharaan = '$id_pemeliharaan'";

    if (mysqli_query($conn, $sql_update)) {
        $_SESSION['success'] = true;
        header('Location: ../../Data_pemeliharaan.php');
        exit;
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
        header('Location: ../../frm_edit_pemeliharaan.php?id_pemeliharaan=' . $id_pemeliharaan);
        exit;
    }
} else {
    header('Location: ../../Data_pemeliharaan.php');
    exit;
}
?>
