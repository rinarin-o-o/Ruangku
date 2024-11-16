<?php
include('koneksi/koneksi.php');

// Ambil parameter QR Code
$qrcode = isset($_GET['qrcode']) ? $_GET['qrcode'] : '';

$response = [
    'isLocation' => false,
    'isItem' => false
];

// Periksa apakah QR Code termasuk dalam `id_lokasi`
$sql_lokasi = "SELECT * FROM lokasi WHERE id_lokasi = '$qrcode'";
$result_lokasi = mysqli_query($conn, $sql_lokasi);

if (mysqli_num_rows($result_lokasi) > 0) {
    $row = mysqli_fetch_assoc($result_lokasi);
    $response['isLocation'] = true;
    $response['id_lokasi'] = $row['id_lokasi'];
}

// Periksa apakah QR Code termasuk dalam `id_barang_pemda`
$sql_barang = "SELECT * FROM data_barang WHERE id_barang_pemda = '$qrcode'";
$result_barang = mysqli_query($conn, $sql_barang);

if (mysqli_num_rows($result_barang) > 0) {
    $row = mysqli_fetch_assoc($result_barang);
    $response['isItem'] = true;
    $response['id_barang_pemda'] = $row['id_barang_pemda'];
}

// Kirim respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
<script>
function cekQRCode(qrData) {
    fetch(`cek_qrcode.php?qrcode=${encodeURIComponent(qrData)}`)
        .then(response => response.json())
        .then(data => {
            console.log('Response from server:', data); // Debug response here
            if (data.isLocation) {
                window.location.href = `qrcode_inventaris.php?id_lokasi=${data.id_lokasi}`;
            } else if (data.isItem) {
                window.location.href = `qrcode_detail_barang.php?id_barang_pemda=${data.id_barang_pemda}`;
            } else {
                qrResult.textContent = "QR Code tidak valid.";
            }
        })
        .catch(error => {
            console.error('Error checking QR code:', error);
            qrResult.textContent = "Terjadi kesalahan saat memproses QR Code.";
        });
}
</script>


