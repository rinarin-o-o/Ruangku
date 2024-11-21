<?php
session_start();
include('../../koneksi/koneksi.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['foto_barang']) && isset($_POST['id_barang_pemda'])) {
        $id_barang_pemda = $_POST['id_barang_pemda']; // Pastikan kode barang dikirim
        $target_dir = "../../assets/images/";
        $file_name = basename($_FILES['foto_barang']['name']);
        $target_file = $target_dir . $file_name;

        // Validasi file (opsional)
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        header('Content-Type: application/json');

        if (!in_array($file_type, $allowed_types)) {
            echo json_encode(['success' => false, 'message' => 'Jenis file tidak valid.']);
            exit;
        }

        // Pindahkan file yang diunggah
        if (move_uploaded_file($_FILES['foto_barang']['tmp_name'], $target_file)) {
            // Update database
            include('../config.php'); // Sesuaikan dengan file koneksi Anda
            $query = "UPDATE data_barang SET foto_barang = '$file_name' WHERE id_barang_pemda = '$id_barang_pemda'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal memperbarui database.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengunggah file.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
    }
}
?>

