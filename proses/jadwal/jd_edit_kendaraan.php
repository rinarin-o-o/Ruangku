<?php
session_start();
include('../../koneksi/koneksi.php'); // Include DB connection

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input to prevent SQL injection
    if (isset($_POST['id_jadwal_kendaraan'])) {
        $id_jadwal_kendaraan = mysqli_real_escape_string($conn, $_POST['id_jadwal_kendaraan']);
    } else {
        $_SESSION['error'] = 'ID Jadwal Kendaraan tidak ditemukan.';
        header('Location: ../../jd_frm_edit_kendaraan.php?id_jadwal_kendaraan=' . $id_jadwal_kendaraan);
        exit;
    }

    $tgl_mulai = isset($_POST['tgl_mulai']) ? mysqli_real_escape_string($conn, $_POST['tgl_mulai']) : null;
    $waktu_mulai = isset($_POST['waktu_mulai']) ? mysqli_real_escape_string($conn, $_POST['waktu_mulai']) : null;
    $tgl_sekarang = isset($_POST['tgl_selesai']) ? mysqli_real_escape_string($conn, $_POST['tgl_selesai']) : null;
    $waktu_sekarang = isset($_POST['waktu_selesai']) ? mysqli_real_escape_string($conn, $_POST['waktu_selesai']) : null;
    $penanggungjawab = isset($_POST['penanggungjawab']) ? mysqli_real_escape_string($conn, $_POST['penanggungjawab']) : '';
    $pengguna = isset($_POST['pengguna']) ? mysqli_real_escape_string($conn, $_POST['pengguna']) : '';
    $acara = isset($_POST['acara']) ? mysqli_real_escape_string($conn, $_POST['acara']) : '';

    // Check if all required fields are present
    if ($tgl_mulai && $waktu_mulai && $tgl_sekarang && $waktu_sekarang && $penanggungjawab && $pengguna && $acara) {
        // Update query
        $sql_update = "UPDATE jadwal_kendaraan 
                       SET tgl_mulai='$tgl_mulai', waktu_mulai='$waktu_mulai', tgl_selesai='$tgl_sekarang', waktu_selesai='$waktu_sekarang', penanggungjawab='$penanggungjawab', pengguna='$pengguna', acara='$acara'
                       WHERE id_jadwal_kendaraan='$id_jadwal_kendaraan'";

        if (mysqli_query($conn, $sql_update)) {
            $_SESSION['success'] = true;
            // Redirect to jadwal_kendaraan.php after update
            header('Location: ../../jadwal_kendaraan.php');
            exit;
        } else {
            $_SESSION['error'] = "Error: " . mysqli_error($conn);
            header('Location: ../../jd_frm_edit_kendaraan.php?id_jadwal_kendaraan=' . $id_jadwal_kendaraan);
            exit;
        }
    } else {
        // Redirect back with error if required fields are missing
        $_SESSION['error'] = 'Semua field harus diisi.';
        header('Location: ../../jd_frm_edit_kendaraan.php?id_jadwal_kendaraan=' . $id_jadwal_kendaraan);
        exit;
    }
} else {
    // Redirect to the location list page if accessed directly
    header('Location: ../../jadwal_kendaraan.php');
    exit;
}
