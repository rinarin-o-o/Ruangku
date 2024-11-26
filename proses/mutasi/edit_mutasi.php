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

    // Initialize file upload variables
    $file_name = null;
    
    // Check if a file was uploaded
    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == 0) {
        // Get file details
        $file_tmp = $_FILES['file_upload']['tmp_name'];
        $file_name = $_FILES['file_upload']['name'];
        $file_size = $_FILES['file_upload']['size'];
        $file_type = $_FILES['file_upload']['type'];

        // Validate file extension
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_extensions)) {
            $_SESSION['error'] = "Format file tidak didukung. Harap unggah file dengan format JPG, PNG, PDF, DOC, dll.";
            header('Location: ../../frm_edit_mutasi.php?id_mutasi=' . $id_mutasi);
            exit;
        }

        // Validate file size (max 2MB)
        if ($file_size > 2 * 1024 * 1024) {
            $_SESSION['error'] = "Ukuran file terlalu besar. Maksimal 2MB.";
            header('Location: ../../frm_edit_mutasi.php?id_mutasi=' . $id_mutasi);
            exit;
        }

        // Set the upload directory
        $upload_dir = '../../uploads/mutasi/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);  // Create directory if it doesn't exist
        }

        // Generate a unique file name
        $new_file_name = uniqid() . '.' . $file_ext;
        $upload_path = $upload_dir . $new_file_name;

        // Move the uploaded file to the desired directory
        if (!move_uploaded_file($file_tmp, $upload_path)) {
            $_SESSION['error'] = "Gagal mengunggah file. Coba lagi.";
            header('Location: ../../frm_edit_mutasi.php?id_mutasi=' . $id_mutasi);
            exit;
        }

        // Set the file name for the database
        $file_name = $new_file_name;
    }

    // Using prepared statement to update the data in the database
    $sql = "UPDATE mutasi_barang SET jenis_mutasi = ?, tgl_mutasi = ?, penanggungjawab = ?, keterangan = ?, file_upload = ? WHERE id_mutasi = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        if ($file_name) {
            $stmt->bind_param("ssssss", $jenis_mutasi, $tgl_mutasi, $penanggungjawab, $keterangan, $file_name, $id_mutasi);
        } else {
            // If no file is uploaded, pass NULL for file_upload
            $file_name = null;
            $stmt->bind_param("sssssi", $jenis_mutasi, $tgl_mutasi, $penanggungjawab, $keterangan, $file_name, $id_mutasi);
        }

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['success'] = "Data mutasi berhasil diperbarui.";
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
        // Handle error if statement preparation fails
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
        header('Location: ../../frm_edit_mutasi.php?id_mutasi=' . $id_mutasi);
        exit;
    }
} else {
    // Redirect to the mutasi list page if accessed directly
    header('Location: ../../Data_mutasi_barang.php');
    exit;
}
?>
