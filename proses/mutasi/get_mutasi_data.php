<?php
include("../../koneksi/koneksi.php");

if (isset($_POST['id_mutasi'])) {
    $id_mutasi = mysqli_real_escape_string($conn, $_POST['id_mutasi']);
    
    $query = "SELECT * FROM mutasi_barang WHERE id_mutasi = '$id_mutasi'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
    
    mysqli_close($conn);
}
?>
