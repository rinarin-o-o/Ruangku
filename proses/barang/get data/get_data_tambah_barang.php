<?php
include('koneksi/koneksi.php');

// Mengambil data pemilik untuk opsi select
$sql_pemilik = "SELECT kode_pemilik, nama_pemilik FROM pemilik";
$result_pemilik = mysqli_query($conn, $sql_pemilik);
$pemilikya = [];
while ($pemilik = mysqli_fetch_assoc($result_pemilik)) {
    $pemilikya[] = $pemilik;
}

// Mengambil data lokasi untuk opsi select
$sql_locations = "SELECT * FROM lokasi";
$locations_result = mysqli_query($conn, $sql_locations);

// Menyimpan lokasi dalam array
$locations = [];
while ($location = mysqli_fetch_assoc($locations_result)) {
    $locations[] = $location;
}
?>

<script>
    function handleLocationChange() {
        var selectElement = document.getElementById('lokasi_sekarang');
        var selectedValue = selectElement.value;

        if (selectedValue !== "other" && selectedValue !== "") {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            document.getElementById('id_ruang_sekarang').value = selectedValue;
            document.getElementById('nama_ruang_sekarang').value = selectedOption.getAttribute('data-nama');
            document.getElementById('bidang_ruang_sekarang').value = selectedOption.getAttribute('data-bidang');
            document.getElementById('tempat_ruang_sekarang').value = selectedOption.getAttribute('data-tempat');
        } else if (selectedValue === "other") {
            window.open("frm_tambah_lokasi.php", "_blank");
        } else {
            document.getElementById('id_ruang_sekarang').value = "";
            document.getElementById('nama_ruang_sekarang').value = "";
            document.getElementById('bidang_ruang_sekarang').value = "";
            document.getElementById('tempat_ruang_sekarang').value = "";
        }
    }

    window.onload = function() {
        handleLocationChange();
    };
</script>