<?php
session_start();
include('koneksi/koneksi.php');
include('component/header.php');

$sql_pemilik = "SELECT kode_pemilik, nama_pemilik FROM pemilik";
$result_pemilik = mysqli_query($conn, $sql_pemilik);
$pemilikya = [];
while ($pemilik = mysqli_fetch_assoc($result_pemilik)) {
    $pemilikya[] = $pemilik;
}

$sql_locations = "SELECT * FROM lokasi";
$locations_result = mysqli_query($conn, $sql_locations);
$locations = [];
while ($location = mysqli_fetch_assoc($locations_result)) {
    $locations[] = $location;
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tambah Barang</h1>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body" style="padding-top: 50px; padding-left: 100px; padding-right: 50px;">
            <form method="POST" action="proses/barang/tambah_barang.php" enctype="multipart/form-data">

                <!-- ID Barang -->
                <div class="row mb-2">
                    <label for="id_barang_pemda" class="col-sm-3 col-form-label">ID Pemda: <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" id="id_barang_pemda" name="id_barang_pemda" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="nama_barang" class="col-sm-3 col-form-label">Nama Barang <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="nama_barang" class="form-control" id="nama_barang" required>
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="kode_barang" class="col-sm-3 col-form-label">Kode Barang <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="kode_barang" class="form-control" id="kode_barang" required>
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="kode_pemilik" class="col-sm-3 col-form-label">Kode Pemilik <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <select id="kode_pemilik" name="kode_pemilik" class="form-select" onchange="handlePemilikChange()" required>
                            <option value="">Pilih Kode Pemilik</option>
                            <?php foreach ($pemilikya as $pemilik) : ?>
                                <option value="<?php echo htmlspecialchars($pemilik['kode_pemilik']); ?>">
                                    <?php echo htmlspecialchars($pemilik['kode_pemilik'] . ' - ' . $pemilik['nama_pemilik']); ?>
                                </option>
                            <?php endforeach; ?>
                            <option value="other">Tambah pemilik baru ...</option>
                        </select>
                    </div>
                </div>

                <!-- Modal untuk tambah pemilik baru -->
                <div class="modal fade" id="tambahPemilikModal" tabindex="-1" aria-labelledby="tambahPemilikLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahPemilikLabel">Tambah Pemilik Baru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="tambahPemilikForm">
                                    <div class="mb-3">
                                        <label for="kode_pemilik_baru" class="form-label">Kode Pemilik</label>
                                        <input type="text" class="form-control" id="kode_pemilik_baru" name="kode_pemilik_baru" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_pemilik_baru" class="form-label">Nama Pemilik</label>
                                        <input type="text" class="form-control" id="nama_pemilik_baru" name="nama_pemilik_baru" required>
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="simpanPemilikBaru()">Simpan Pemilik</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <script>
                    function handlePemilikChange() {
                        var selectElement = document.getElementById('kode_pemilik');
                        var selectedValue = selectElement.value;

                        if (selectedValue === "other") {
                            var tambahPemilikModal = new bootstrap.Modal(document.getElementById('tambahPemilikModal'), {});
                            tambahPemilikModal.show();
                        }
                    }

                    function simpanPemilikBaru() {
                        // Ambil nilai dari input form
                        var kodePemilikBaru = document.getElementById('kode_pemilik_baru').value;
                        var namaPemilikBaru = document.getElementById('nama_pemilik_baru').value;

                        // Cek jika input tidak kosong
                        if (kodePemilikBaru && namaPemilikBaru) {
                            // AJAX request untuk menyimpan pemilik baru ke database
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "proses/barang/tambah_pemilik.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    var response = JSON.parse(xhr.responseText);
                                    if (response.success) {
                                        // Tambahkan pemilik baru ke dropdown
                                        var selectElement = document.getElementById('kode_pemilik');
                                        var newOption = document.createElement('option');
                                        newOption.value = kodePemilikBaru;
                                        newOption.textContent = kodePemilikBaru + ' - ' + namaPemilikBaru;
                                        selectElement.appendChild(newOption);
                                        selectElement.value = kodePemilikBaru;

                                        // Tutup modal
                                        var tambahPemilikModal = bootstrap.Modal.getInstance(document.getElementById('tambahPemilikModal'));
                                        tambahPemilikModal.hide();
                                    } else {
                                        alert('Gagal menambahkan pemilik baru. Silakan coba lagi.');
                                    }
                                }
                            };
                            xhr.send("kode_pemilik_baru=" + encodeURIComponent(kodePemilikBaru) + "&nama_pemilik_baru=" + encodeURIComponent(namaPemilikBaru));
                        } else {
                            alert('Mohon lengkapi semua field.');
                        }
                    }
                </script>


                <!-- No. Registrasi -->
                <div class="row mb-2">
                    <label for="no_regristrasi" class="col-sm-3 col-form-label">No. Registrasi: <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" id="no_regristrasi" name="no_regristrasi" class="form-control" id="no_regristrasi" requred>
                    </div>
                </div>

                <!-- Select Lokasi Asal -->
                <div class="row mb-2">
                    <label for="lokasi_asal" class="col-sm-3 col-form-label">Lokasi Asal: <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <select id="lokasi_asal" name="lokasi_asal" class="form-select" required>
                            <option value="">Pilih Lokasi Asal</option>
                            <?php foreach ($locations as $location) : ?>
                                <option value="<?php echo htmlspecialchars($location['id_lokasi']); ?>" data-nama="<?php echo htmlspecialchars($location['nama_lokasi']); ?>" data-bidang="<?php echo htmlspecialchars($location['bid_lokasi']); ?>" data-tempat="<?php echo htmlspecialchars($location['tempat_lokasi']); ?>">
                                    <?php echo htmlspecialchars($location['nama_lokasi'] . ' - ' . $location['bid_lokasi'] . ' - ' . $location['tempat_lokasi']); ?>
                                </option>
                            <?php endforeach; ?>
                            <option value="other">Tambah lokasi Baru (Masuk ke Inventaris Lokasi)...</option>
                        </select>
                    </div>
                </div>

                <!-- Hidden inputs for Lokasi Asal -->
                <input type="hidden" id="id_ruang_asal" name="id_ruang_asal">
                <input type="hidden" id="nama_ruang_asal" name="nama_ruang_asal">
                <input type="hidden" id="bidang_ruang_asal" name="bidang_ruang_asal">
                <input type="hidden" id="tempat_ruang_asal" name="tempat_ruang_asal">

                <script>
                    // Fungsi untuk menangani perubahan pada dropdown lokasi
                    function handleLocationChange() {
                        var selectElement = document.getElementById('lokasi_asal');
                        var selectedValue = selectElement.value;

                        // Update hidden inputs jika pengguna memilih lokasi yang ada
                        if (selectedValue !== "other" && selectedValue !== "") {
                            var selectedOption = selectElement.options[selectElement.selectedIndex];
                            document.getElementById('id_ruang_asal').value = selectedValue;
                            document.getElementById('nama_ruang_asal').value = selectedOption.getAttribute('data-nama');
                            document.getElementById('bidang_ruang_asal').value = selectedOption.getAttribute('data-bid');
                            document.getElementById('tempat_ruang_asal').value = selectedOption.getAttribute('data-tempat');
                        } else if (selectedValue === "other") {
                            // Buka halaman tambah lokasi di tab baru jika memilih "Tambah Ruang/lokasi Baru"
                            window.open("frm_tambah_lokasi.php", "_blank");
                        } else {
                            // Reset hidden inputs jika tidak ada lokasi yang dipilih
                            document.getElementById('id_ruang_asal').value = "";
                            document.getElementById('nama_ruang_asal').value = "";
                            document.getElementById('bidang_ruang_asal').value = "";
                            document.getElementById('tempat_ruang_asal').value = "";
                        }
                    }

                    // Jalankan fungsi untuk mengisi hidden inputs ketika halaman dimuat
                    window.onload = function() {
                        handleLocationChange();
                    };
                </script>

                <!-- Select Lokasi Sekarang -->
                <div class="row mb-2">
                    <label for="lokasi_sekarang" class="col-sm-3 col-form-label">Lokasi Sekarang: <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <select id="lokasi_sekarang" name="lokasi_sekarang" class="form-select" required>
                            <option value="">Pilih Lokasi Sekarang</option>
                            <?php foreach ($locations as $location) : ?>
                                <option value="<?php echo htmlspecialchars($location['id_lokasi']); ?>" data-nama="<?php echo htmlspecialchars($location['nama_lokasi']); ?>" data-bidang="<?php echo htmlspecialchars($location['bid_lokasi']); ?>" data-tempat="<?php echo htmlspecialchars($location['tempat_lokasi']); ?>">
                                    <?php echo htmlspecialchars($location['nama_lokasi'] . ' - ' . $location['bid_lokasi'] . ' - ' . $location['tempat_lokasi']); ?>
                                </option>
                            <?php endforeach; ?>
                            <option value="other">Tambah lokasi Baru (Masuk ke Inventaris Lokasi)...</option>
                        </select>
                    </div>
                </div>

                <!-- Hidden inputs untuk menyimpan data lokasi sekarang -->
                <input type="hidden" id="id_ruang_sekarang" name="id_ruang_sekarang" value="<?php echo htmlspecialchars($row_barang['id_ruang_sekarang']); ?>">
                <input type="hidden" id="nama_ruang_sekarang" name="nama_ruang_sekarang" value="<?php echo htmlspecialchars($row_barang['nama_ruang_sekarang']); ?>">
                <input type="hidden" id="bidang_ruang_sekarang" name="bidang_ruang_sekarang" value="<?php echo htmlspecialchars($row_barang['bidang_ruang_sekarang']); ?>">
                <input type="hidden" id="tempat_ruang_sekarang" name="tempat_ruang_sekarang" value="<?php echo htmlspecialchars($row_barang['tempat_ruang_sekarang']); ?>">

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
                            document.getElementById('bidang_ruang_sekarang').value = selectedOption.getAttribute('data-bid');
                            document.getElementById('tempat_ruang_sekarang').value = selectedOption.getAttribute('data-tempat');
                        } else if (selectedValue === "other") {
                            // Buka halaman tambah lokasi di tab baru jika memilih "Tambah Ruang/lokasi Baru"
                            window.open("frm_tambah_lokasi.php", "_blank");
                        } else {
                            // Reset hidden inputs jika tidak ada lokasi yang dipilih
                            document.getElementById('id_ruang_sekarang').value = "";
                            document.getElementById('nama_ruang_sekarang').value = "";
                            document.getElementById('bidang_ruang_sekarang').value = "";
                            document.getElementById('tempat_ruang_sekarang').value = "";
                        }
                    }

                    // Jalankan fungsi untuk mengisi hidden inputs ketika halaman dimuat
                    window.onload = function() {
                        handleLocationChange();
                    };
                </script>

                <!-- Kategori -->
                <div class="row mb-2">
                    <label for="kategori" class="col-sm-3 col-form-label">Kategori: <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <select id="kategori" name="kategori" class="form-select" onchange="handleCategoryChange()">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="kendaraan">Kendaraan</option>
                            <option value="peralatan">Peralatan</option>
                            <option value="mesin">Mesin</option>
                            <option value="elektronik">Elektronik</option>
                            <option value="other">Tambah Kategori Baru...</option>
                        </select>
                    </div>
                </div>

                <!-- Modal untuk kategori baru -->
                <div class="modal fade" id="kategoriBaruModal" tabindex="-1" aria-labelledby="kategoriBaruModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="kategoriBaruModalLabel">Tambah Kategori Baru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" id="kategori_baru_input" class="form-control" placeholder="Masukkan kategori baru">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" onclick="saveCategory()">OK</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    // Fungsi untuk menampilkan pop-up kategori baru
                    function handleCategoryChange() {
                        var selectElement = document.getElementById('kategori');
                        if (selectElement.value === "other") {
                            var kategoriModal = new bootstrap.Modal(document.getElementById('kategoriBaruModal'));
                            kategoriModal.show();
                        }
                    }

                    // Fungsi untuk menyimpan kategori baru dan menambahkannya ke select input
                    function saveCategory() {
                        var kategoriBaru = document.getElementById('kategori_baru_input').value.trim();
                        if (kategoriBaru) {
                            var selectElement = document.getElementById('kategori');
                            selectElement.options[selectElement.options.length - 1] = new Option(kategoriBaru, kategoriBaru.toLowerCase().replace(/\s+/g, '_')); // Ganti option "Tambah Kategori Baru..."
                            selectElement.value = kategoriBaru.toLowerCase().replace(/\s+/g, '_'); // Set value select ke kategori baru

                            // Tambahkan kembali opsi "Tambah Kategori Baru..."
                            selectElement.options[selectElement.options.length] = new Option("Tambah Kategori Baru...", "other");

                            var kategoriModal = bootstrap.Modal.getInstance(document.getElementById('kategoriBaruModal'));
                            kategoriModal.hide(); // Sembunyikan modal
                        }
                    }
                </script>

                <div class="row mb-2">
                    <label for="merk" class="col-sm-3 col-form-label">Merk</label>
                    <div class="col-sm-8">
                        <input type="text" name="merk" class="form-control" id="merk">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="type" class="col-sm-3 col-form-label">Tipe</label>
                    <div class="col-sm-8">
                        <input type="text" name="type" class="form-control" id="type">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="bahan" class="col-sm-3 col-form-label">Bahan</label>
                    <div class="col-sm-8">
                        <input type="text" name="bahan" class="form-control" id="bahan">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="ukuran_CC" class="col-sm-3 col-form-label">Ukuran / CC</label>
                    <div class="col-sm-8">
                        <input type="text" name="ukuran_CC" class="form-control" id="ukuran_CC">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="no_pabrik" class="col-sm-3 col-form-label">No Pabrik</label>
                    <div class="col-sm-8">
                        <input type="text" name="no_pabrik" class="form-control" id="no_pabrik">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="no_rangka" class="col-sm-3 col-form-label">No Rangka</label>
                    <div class="col-sm-8">
                        <input type="text" name="no_rangka" class="form-control" id="no_rangka">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="no_mesin" class="col-sm-3 col-form-label">No Mesin</label>
                    <div class="col-sm-8">
                        <input type="text" name="no_mesin" class="form-control" id="no_mesin">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="no_bpkb" class="col-sm-3 col-form-label">No BPKB</label>
                    <div class="col-sm-8">
                        <input type="text" name="no_bpkb" class="form-control" id="no_bpkb">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="no_polisi" class="col-sm-3 col-form-label">No Polisi</label>
                    <div class="col-sm-8">
                        <input type="text" name="no_polisi" class="form-control" id="no_polisi">
                    </div>
                </div>

                <!-- Harga Awal -->
                <div class="row mb-2">
                    <label for="harga_awal" class="col-sm-3 col-form-label">Harga Perolehan: <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="harga_awal" name="harga_awal" class="form-control" id="harga_awal" step="0.01">
                        </div>
                    </div>
                </div>

                <input type="hidden" id="harga_total" name="harga_total" class="form-control" id="harga_total" step="0.01">

                <div class="row mb-2">
                    <label for="tgl_pembelian" class="col-sm-3 col-form-label">Tanggal Pembelian <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="date" name="tgl_pembelian" class="form-control" id="tgl_pembelian">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="tgl_pembukuan" class="col-sm-3 col-form-label">Tanggal Pembukuan <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="date" name="tgl_pembukuan" class="form-control" id="tgl_pembukuan">
                    </div>
                </div>

                <!-- Masa Manfaat -->
                <div class="row mb-2">
                    <label for="masa_manfaat" class="col-sm-3 col-form-label">Masa Manfaat : <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="number" id="masa_manfaat" name="masa_manfaat" class="form-control" id="masa_manfaat" required>
                            <span class="input-group-text">Bulan</span>
                        </div>
                    </div>
                </div>


                <div class="row mb-2">
                    <label for="kondisi_barang" class="col-sm-3 col-form-label">Kondisi Barang <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                        <select name="kondisi_barang" class="form-select" id="kondisi_barang" required>
                            <option value="" disabled selected>Pilih Kondisi</option>
                            <option value="baik">Baik</option>
                            <option value="kurang_baik">Kurang Baik</option>
                            <option value="rusak">Rusak</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-8">
                        <textarea name="keterangan" class="form-control" id="keterangan"></textarea>
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="foto_barang" class="col-sm-3 col-form-label">Foto Barang</label>
                    <div class="col-sm-8">
                        <input type="file" name="foto_barang" class="form-control" id="foto_barang">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-8 offset-sm-3 text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="Data_barang.php" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form><!-- End form -->
        </div>
    </div>
</main><!-- End Main Content -->

<?php include("component/footer.php"); ?>