<?php
ob_start();
session_start();
include('koneksi/koneksi.php');
include('component/header.php');

// Buat ID Jadwal baru secara otomatis
$query_max_id = "SELECT MAX(id_jadwal_ruang) AS max_id FROM jadwal_ruang";
$result_max_id = mysqli_query($conn, $query_max_id);
$row_max_id = mysqli_fetch_assoc($result_max_id);

if ($row_max_id['max_id']) {
    $last_id = $row_max_id['max_id'];
    $number = (int)substr($last_id, 3) + 1;
} else {
    $number = 1;
}

$new_id_jadwal_ruang = 'SPC' . str_pad($number, 8, '0', STR_PAD_LEFT);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tambah Penggunaan Ruang</h1>
    </div>

    <div class="card">
        <div class="card-body" style="padding-top: 50px; padding-left: 100px; padding-right: 50px;">
            <form id="addJdRuangForm" method="POST" action="proses/jadwal/jd_tambah_ruang.php">

                <input type="hidden" name="id_jadwal_ruang" value="<?php echo $new_id_jadwal_ruang; ?>">

                <div class="row mb-2">
                    <label for="ruang" class="col-sm-3 col-form-label">Ruang <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="ruang_field" id="ruangSelect" required onchange="updateHiddenInput()">
                            <option value="">-- Pilih Ruang --</option>
                            <?php
                            // Ambil data dari tabel lokasi dengan kategori = 'ruang'
                            $sql_lokasi = "SELECT * FROM lokasi WHERE kategori_lokasi = 'ruangan' AND tempat_lokasi = 'Dinkominfotik Kab. Brebes'";
                            $result_lokasi = mysqli_query($conn, $sql_lokasi);

                            // Loop untuk menampilkan opsi dari tabel lokasi
                            if (mysqli_num_rows($result_lokasi) > 0) {
                                while ($row = mysqli_fetch_assoc($result_lokasi)) {
                                    // Menampilkan nama_lokasi dan bid_lokasi sebagai opsi
                                    echo "<option value='" . $row['id_lokasi'] . "' data-nama-lokasi='" . $row['nama_lokasi'] . "' data-bid-lokasi='" . $row['bid_lokasi'] . "'>" . $row['nama_lokasi'] . " - " . $row['bid_lokasi'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>Tidak ada data ruang tersedia</option>";
                            }
                            ?>
                        </select>

                        <!-- Hidden input untuk mengirim id_lokasi -->
                        <input type="hidden" name="id_lokasi" id="id_lokasi" value="">

                        <!-- Hidden input untuk mengirim gabungan nama_lokasi-bid_lokasi -->
                        <input type="hidden" name="nama_lokasi" id="nama_lokasi" value="">
                    </div>
                </div>

                <script>
                    function updateHiddenInput() {
                        var selectElement = document.getElementById('ruangSelect');
                        var selectedOption = selectElement.options[selectElement.selectedIndex];

                        // Update id_lokasi
                        document.getElementById('id_lokasi').value = selectedOption.value;

                        // Update gabungan nama_lokasi dan bid_lokasi
                        var namaLokasi = selectedOption.getAttribute('data-nama-lokasi');
                        var bidLokasi = selectedOption.getAttribute('data-bid-lokasi');
                        document.getElementById('nama_lokasi').value = namaLokasi + " - " + bidLokasi;
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
