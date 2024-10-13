<?php
session_start();
include('../../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input to prevent SQL injection
    $id_mutasi = mysqli_real_escape_string($conn, $_POST['id_mutasi']);
    $jenis_mutasi = mysqli_real_escape_string($conn, $_POST['jenis_mutasi']);
    $tgl_mutasi = mysqli_real_escape_string($conn, $_POST['tgl_mutasi']);
    $penanggungjawab = mysqli_real_escape_string($conn, $_POST['penanggungjawab']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    // Using prepared statement to update the data
    $stmt = $conn->prepare("UPDATE mutasi_barang SET jenis_mutasi =?,tgl_mutasi=?, penanggungjawab=?, keterangan=? WHERE id_mutasi=?");
    
    if ($stmt === false) {
        // Handle error if statement preparation fails
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
        header('Location: ../../frm_edit_mutasi.php?id_mutasi=' . $id_mutasi);
        exit;
    }

    // Bind the parameters
    $stmt->bind_param("sssss", $jenis_mutasi, $tgl_mutasi, $penanggungjawab, $keterangan, $id_mutasi);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['success'] = true;
        // Redirect to Data_mutasi_barang.php after update
        header('Location: ../../Data_mutasi_barang.php');
        exit;
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
        header('Location: ../../frm_edit_mutasi.php?id_mutasi=' . $id_mutasi);
        exit;
    }

    // Close the statement
    $stmt->close();
} else {
    // Redirect to the location list page if accessed directly
    header('Location: ../../Data_mutasi_barang.php');
    exit;
}
?>
