<?php
session_start();
require_once '../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password dengan password_verify()
        if (password_verify($password, $row['password'])) {
            $_SESSION['nama_admin'] = $row['nama_admin'];
            $_SESSION['foto_admin'] = $row['foto_admin'];
            header('Location: ../frm_edit_barang.php?id_barang_pemda=' . urlencode($id_barang_pemda));
            exit;

            exit();
        } else {
            echo "<script>
                alert('Login gagal. Periksa kembali username dan password Anda.');
                window.location = '../qrcode_login.php';
                </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('Login gagal. Periksa kembali username dan password Anda.');
            window.location = '../qrcode_login.php';
            </script>";
        exit();
    }
} else {
    header('Location: ../qrcode_login.php');
    exit();
}
