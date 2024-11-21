<?php
include('koneksi/koneksi.php'); // Include DB connection

$id_barang_pemda = isset($_GET['id_barang_pemda']) ? $_GET['id_barang_pemda'] : '';

$sql_barang = "SELECT * FROM data_barang WHERE id_barang_pemda = '$id_barang_pemda'";
$result_barang = mysqli_query($conn, $sql_barang);

if (mysqli_num_rows($result_barang) > 0) {
    $row_barang = mysqli_fetch_assoc($result_barang);
    $kode_pemilik = $row_barang['kode_pemilik'];
    $sql_pemilik = "SELECT nama_pemilik FROM pemilik WHERE kode_pemilik = '$kode_pemilik'";
    $result_pemilik = mysqli_query($conn, $sql_pemilik);
    $row_pemilik = mysqli_fetch_assoc($result_pemilik);

    $nama_pemilik = isset($row_pemilik['nama_pemilik']) ? $row_pemilik['nama_pemilik'] : 'Pemilik tidak ditemukan';

    $sql_locations = "SELECT * FROM lokasi";
    $locations_result = mysqli_query($conn, $sql_locations);

    $locations = [];
    while ($location = mysqli_fetch_assoc($locations_result)) {
        $locations[] = $location;
    }
} else {
    echo "Data barang tidak ditemukan.";
    exit;
}
?>

<script>
    // Fungsi untuk menangani perubahan pada dropdown lokasi
    function handleLocationChange() {
        var selectElement = document.getElementById('lokasi_sekarang');
        var selectedValue = selectElement.value;

        // Update hidden inputs jika pengguna memilih lokasi yang ada
        if (selectedValue !== "other" && selectedValue !== "") {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            document.getElementById('id_ruang_sekarang').value = selectedValue;
            document.getElementById('nama_ruang_sekarang').value = selectedOption.getAttribute('data-nama');
            document.getElementById('bid_ruang_sekarang').value = selectedOption.getAttribute('data-bid');
            document.getElementById('tempat_ruang_sekarang').value = selectedOption.getAttribute('data-tempat');
        } else if (selectedValue === "other") {
            // Buka halaman tambah lokasi di tab baru jika memilih "Tambah Ruang/lokasi Baru"
            window.open("frm_tambah_lokasi.php", "_blank");
        } else {
            // Reset hidden inputs jika tidak ada lokasi yang dipilih
            document.getElementById('id_ruang_sekarang').value = "";
            document.getElementById('nama_ruang_sekarang').value = "";
            document.getElementById('bid_ruang_sekarang').value = "";
            document.getElementById('tempat_ruang_sekarang').value = "";
        }
    }

    // Jalankan fungsi untuk mengisi hidden inputs ketika halaman dimuat
    window.onload = function() {
        handleLocationChange();
    };
</script>