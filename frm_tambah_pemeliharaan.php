<?php
include('koneksi/koneksi.php');
include('component/header.php');

// Tampilkan pesan error atau success jika ada
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
} elseif (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>Data berhasil disimpan!</div>";
    unset($_SESSION['success']);
}

// Ambil data kode_barang dari tabel data_barang
$query_barang = "SELECT id_barang_pemda, kode_barang, nama_barang, no_regristrasi FROM data_barang";
$result_barang = mysqli_query($conn, $query_barang);

// Buat ID Pemeliharaan baru secara otomatis
$query_max_id = "SELECT MAX(id_pemeliharaan) AS max_id FROM data_pemeliharaan";
$result_max_id = mysqli_query($conn, $query_max_id);
$row_max_id = mysqli_fetch_assoc($result_max_id);

// Jika ada ID pemeliharaan, ambil angkanya lalu increment
if ($row_max_id['max_id']) {
    $last_id = $row_max_id['max_id'];
    $number = (int)substr($last_id, 3) + 1; // Ambil angka setelah 'MNT' dan tambah 1
} else {
    $number = 1; // Jika belum ada data, mulai dari 1
}

// Format ID menjadi 'MNT' diikuti angka 8 digit
$new_id_pemeliharaan = 'MNT' . str_pad($number, 8, '0', STR_PAD_LEFT);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tambah Data Pemeliharaan</h1>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body" style="padding-top: 40px; padding-left: 100px; padding-right: 50px;">
            <form method="POST" action="proses/pemeliharaan/tambah_pemeliharaan.php">
                <!-- ID Pemeliharaan Otomatis -->
                <div class="row mb-2">
                    <label for="id_pemeliharaan" class="col-sm-3 col-form-label">ID Pemeliharaan<span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="id_pemeliharaan" name="id_pemeliharaan" value="<?php echo $new_id_pemeliharaan; ?>" readonly style="background-color: #f0f0f0;">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="kode_barang" class="col-sm-3 col-form-label">Barang<span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="id_barang_pemda" id="barangSelect" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php
                            // Loop untuk menampilkan opsi dari tabel data_barang
                            if (mysqli_num_rows($result_barang) > 0) {
                                while ($row = mysqli_fetch_assoc($result_barang)) {
                                    echo "<option value='" . $row['id_barang_pemda'] . "' data-kode-barang='" . $row['kode_barang'] . "' data-no-registrasi='" . $row['no_regristrasi'] . "' data-nama-barang='" . $row['nama_barang'] . "'>" . $row['kode_barang'] . " - " . $row['no_regristrasi'] . " - " . $row['nama_barang'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>Tidak ada data barang tersedia</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Hidden input untuk mengirimkan data kode_barang, no_regristrasi, dan nama_barang -->
                <input type="hidden" name="kode_barang" id="kode_barang" required>

                <script>
                    document.getElementById('barangSelect').addEventListener('change', function() {
                        var selectedOption = this.options[this.selectedIndex];
                        if (selectedOption.value !== "") {
                            document.getElementById('kode_barang').value = selectedOption.getAttribute('data-kode-barang');
                            console.log("Kode Barang: " + document.getElementById('kode_barang').value); // Untuk cek nilai kode barang
                        } else {
                            document.getElementById('kode_barang').value = "";
                        }
                    });
                </script>

                <div class="row mb-2">
                    <label for="desk_pemeliharaan" class="col-sm-3 col-form-label">Pemeliharaan/Kerusakan</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="desk_pemeliharaan"></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="perbaikan" class="col-sm-3 col-form-label">Perbaikan</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="perbaikan">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="tgl_perbaikan" class="col-sm-3 col-form-label">Tanggal Perbaikan<span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" name="tgl_perbaikan" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="lama_perbaikan" class="col-sm-3 col-form-label">Lama Perbaikan (hari)</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="lama_perbaikan">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="biaya_perbaikan" class="col-sm-3 col-form-label">Biaya Perbaikan<span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="biaya_perbaikan" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-8 offset-sm-3 text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="Data_pemeliharaan.php" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main><!-- End Main Content -->

<?php include("component/footer.php"); ?>