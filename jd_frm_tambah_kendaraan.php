<?php
ob_start();
include('component/header.php');
include('koneksi/koneksi.php');

// Buat ID Jadwal baru secara otomatis
$query_max_id = "SELECT MAX(id_jadwal_kendaraan) AS max_id FROM jadwal_kendaraan";
$result_max_id = mysqli_query($conn, $query_max_id);
$row_max_id = mysqli_fetch_assoc($result_max_id);

if ($row_max_id['max_id']) {
    $last_id = $row_max_id['max_id'];
    $number = (int)substr($last_id, 3) + 1;
} else {
    $number = 1;
}

$new_id_jadwal_kendaraaan = 'VHC' . str_pad($number, 9, '0', STR_PAD_LEFT);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tambah Penggunaan Kendaraan</h1>
    </div>

    <div class="card">
        <div class="card-body" style="padding-top: 50px; padding-left: 100px; padding-right: 50px;">
            <form id="addJdKendaraaanForm" method="POST" action="proses/jadwal/jd_tambah_kendaraan.php">

                <input type="hidden" name="id_jadwal_kendaraan" value="<?php echo $new_id_jadwal_kendaraaan; ?>">

                <div class="row mb-2">
                    <label for="kendaraan" class="col-sm-3 col-form-label">Kendaraan <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="kendaraan_field" id="barangSelect" required onchange="updateHiddenInput()">
                            <option value="">-- Pilih Kendaraan --</option>
                            <?php
                            // Ambil data dari tabel data_barang dengan kategori = 'kendaraan'
                            $sql_barang = "SELECT * FROM data_barang WHERE kategori = 'kendaraan'";
                            $result_barang = mysqli_query($conn, $sql_barang);

                            // Loop untuk menampilkan opsi dari tabel data_barang
                            if (mysqli_num_rows($result_barang) > 0) {
                                while ($row = mysqli_fetch_assoc($result_barang)) {
                                    // Menampilkan nama_barang, merk, dan no_polisi sebagai opsi
                                    echo "<option value='" . $row['id_barang_pemda'] . "' data-nama-barang='" . $row['nama_barang'] . "' data-merk='" . $row['merk'] . "' data-no-polisi='" . $row['no_polisi'] . "'>" . $row['nama_barang'] . " - " . $row['merk'] . " - " . $row['no_polisi'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>Tidak ada data barang tersedia</option>";
                            }
                            ?>
                        </select>

                        <!-- Hidden input untuk mengirim id_barang_pemda -->
                        <input type="hidden" name="id_barang_pemda" id="id_barang_pemda" value="">

                        <!-- Hidden input untuk mengirim gabungan nama_barang-merk-no_polisi -->
                        <input type="hidden" name="kendaraan" id="kendaraan" value="">
                    </div>
                </div>
                        <script>
                            function updateHiddenInput() {
                                var selectElement = document.getElementById('barangSelect');
                                var selectedOption = selectElement.options[selectElement.selectedIndex];

                                // Update id_barang_pemda
                                document.getElementById('id_barang_pemda').value = selectedOption.value;

                                // Update gabungan nama_barang, merk, dan no_polisi
                                var namaBarang = selectedOption.getAttribute('data-nama-barang');
                                var merk = selectedOption.getAttribute('data-merk');
                                var noPolisi = selectedOption.getAttribute('data-no-polisi');
                                document.getElementById('kendaraan').value = namaBarang + " " + merk + " " + noPolisi;
                            }
                        </script>

                        <div class="row mb-2">
                            <label for="waktu_penggunaan" class="col-sm-3 col-form-label">Waktu Penggunaan</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="tgl_mulai">
                            </div>
                            <div class="col-sm-4">
                                <input type="time" class="form-control" name="waktu_mulai">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="waktu_selesai" class="col-sm-3 col-form-label">Waktu Selesai</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="tgl_selesai">
                            </div>
                            <div class="col-sm-4">
                                <input type="time" class="form-control" name="waktu_selesai">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="acara" class="col-sm-3 col-form-label">Kegiatan</label>
                            <div class="col-sm-8">
                                <input type="text" name="acara" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="pengguna" class="col-sm-3 col-form-label">Pengguna</label>
                            <div class="col-sm-8">
                                <input type="text" name="pengguna" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="penanggungjawab" class="col-sm-3 col-form-label">Penanggungjawab</label>
                            <div class="col-sm-8">
                                <input type="text" name="penanggungjawab" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-8 offset-sm-3 text-end">
                                <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                <a href="jadwal_ruang.php" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>

            </form>
        </div>
    </div>
</main>
<?php include("component/footer.php"); ?>
