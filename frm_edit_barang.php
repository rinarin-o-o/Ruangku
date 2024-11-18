<?php
include('component/header.php');
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id_barang_pemda = $_POST['id_barang_pemda'];
  $nama_barang = $_POST['nama_barang'];
  $no_regristrasi = $_POST['no_regristrasi'];
  $kode_pemilik = $_POST['kode_pemilik'];
  $kode_barang = $_POST['kode_barang'];
  $id_ruang_asal = $_POST['id_ruang_asal'];
  $nama_ruang_asal = $_POST['nama_ruang_asal'];
  $bidang_ruang_asal = $_POST['bidang_ruang_asal'];
  $tempat_ruang_asal = $_POST['tempat_ruang_asal'];
  $id_ruang_sekarang = $_POST['id_ruang_sekarang'];
  $nama_ruang_sekarang = $_POST['nama_ruang_sekarang'];
  $bidang_ruang_sekarang = $_POST['bidang_ruang_sekarang'];
  $tempat_ruang_sekarang = $_POST['tempat_ruang_sekarang'];
  $tgl_pembelian = $_POST['tgl_pembelian'];
  $tgl_pembukuan = $_POST['tgl_pembukuan'];
  $merk = $_POST['merk'];
  $type = $_POST['type'];
  $ukuran_CC = $_POST['ukuran_CC'];
  $kategori = $_POST['kategori'];
  $no_pabrik = $_POST['no_pabrik'];
  $no_rangka = $_POST['no_rangka'];
  $no_bpkb = $_POST['no_bpkb'];
  $bahan = $_POST['bahan'];
  $no_mesin = $_POST['no_mesin'];
  $no_polisi = $_POST['no_polisi'];
  $kondisi_barang = $_POST['kondisi_barang'];
  $masa_manfaat = $_POST['masa_manfaat'];
  $harga_awal = str_replace(['Rp ', '.'], ['', ''], $_POST['harga_awal']); // Remove currency formatting
  $harga_total = str_replace(['Rp ', '.'], ['', ''], $_POST['harga_total']); // Remove currency formatting
  $keterangan = $_POST['keterangan'];

  $update_sql = "UPDATE data_barang SET 
    id_barang_pemda = '$id_barang_pemda',
        nama_barang='$nama_barang',
        no_regristrasi='$no_regristrasi',
        kode_pemilik='$kode_pemilik',
        kode_barang='$kode_barang',
        id_ruang_asal='$id_ruang_asal',
        nama_ruang_asal='$nama_ruang_asal',
        bidang_ruang_asal='$bidang_ruang_asal',
        tempat_ruang_asal='$tempat_ruang_asal',
        id_ruang_sekarang='$id_ruang_sekarang',
        nama_ruang_sekarang='$nama_ruang_sekarang',
        bidang_ruang_sekarang='$bidang_ruang_sekarang',
        tempat_ruang_sekarang='$tempat_ruang_sekarang',
        bid_ruang='$bid_ruang',
        tgl_pembelian='$tgl_pembelian',
        tgl_pembukuan='$tgl_pembukuan',
        merk='$merk',
        type='$type',
        kategori = '$kategori',
        ukuran_CC='$ukuran_CC',
        no_pabrik='$no_pabrik',
        no_rangka='$no_rangka',
        no_bpkb='$no_bpkb',
        bahan='$bahan',
        no_mesin='$no_mesin',
        no_polisi='$no_polisi',
        kondisi_barang='$kondisi_barang',
        masa_manfaat='$masa_manfaat',
        harga_awal='$harga_awal',
        harga_total='$harga_total',
        keterangan='$keterangan'
        WHERE id_barang_pemda='$id_barang_pemda'";

  if (mysqli_query($conn, $update_sql)) {
    echo "Data barang berhasil diperbarui.";
  } else {
    echo "Gagal memperbarui data barang: " . mysqli_error($conn);
  }
}
?>

<main id="main" class="main">
  <div class="card">
    <div class="card-body" style="padding-top: 10px">
      <div class="card-title">
        <h1 style="font-size: 20px !important; margin: 0;">Edit <span style="font-size: 20px !important; margin: 0;"> | </span><span> <?php echo $row_barang['nama_barang']; ?> </span></h1>
      </div>
      <hr>

      <form id="editBarangForm" action="proses/barang/edit_barang.php" method="post" enctype="multipart/form-data">
        <div class="row" style="padding-top: 10px;">
          <div class="col-md-6">
            <input type="hidden" name="kode_barang" value="<?php echo htmlspecialchars($row_barang['id_barang_pemda']); ?>">
            <div class="row mb-2">
              <label for="id_barang_pemda" class="col-sm-3 col-form-label-kita">ID Pemda</label>
              <div class="col-sm-8">
                <input type="text" id="id_barang_pemda" name="id_barang_pemda" class="form-control" value="<?php echo htmlspecialchars($row_barang['id_barang_pemda']); ?>" readonly style="background-color: #f0f0f0;">
              </div>
            </div>

            <!-- Nama Barang -->
            <div class="row mb-2">
              <label for="nama_barang" class="col-sm-3 col-form-label-kita">Nama Aset<span style="color: red;">*</span></label>
              <div class="col-sm-8">
                <input type="text" id="nama_barang" name="nama_barang" class="form-control" value="<?php echo htmlspecialchars($row_barang['nama_barang']); ?>" required>
              </div>
            </div>

            <!-- Kode Barang -->
            <div class="row mb-2">
              <label for="kode_barang" class="col-sm-3 col-form-label-kita">Kode Aset</label>
              <div class="col-sm-8">
                <input type="text" id="kode_barang" name="kode_barang" class="form-control readonly-input" value="<?php echo htmlspecialchars($row_barang['kode_barang']); ?>" readonly style="background-color: #f0f0f0;">
              </div>
            </div>

            <!--pemilik-->
            <div class="row mb-2">
              <label for="kode_pemilik" class="col-sm-3 col-form-label-kita">Pemilik</label>
              <div class="col-sm-8">
                <!-- Hidden input for kode_pemilik -->
                <input type="hidden" id="kode_pemilik" name="kode_pemilik" value="<?php echo htmlspecialchars($row_barang['kode_pemilik']); ?>">

                <!-- Display input with kode_pemilik and nama_pemilik -->
                <input type="text" id="pemilik" name="pemilik_display" class="form-control readonly-input" value="<?php echo htmlspecialchars($row_barang['kode_pemilik'] . ' - ' . $nama_pemilik); ?>" readonly style="background-color: #f0f0f0;">
              </div>
            </div>

            <!-- No. Registrasi -->
            <div class="row mb-2">
              <label for="no_regristrasi" class="col-sm-3 col-form-label-kita">No. Reg</label>
              <div class="col-sm-8">
                <input type="text" id="no_regristrasi" name="no_regristrasi" class="form-control readonly-input" value="<?php echo htmlspecialchars($row_barang['no_regristrasi']); ?>" readonly style="background-color: #f0f0f0;">
              </div>
            </div>

            <!-- Lokasi Asal -->
            <div class="row mb-2">
              <label for="lokasi_asal" class="col-sm-3 col-form-label-kita">Ruang Asal</label>
              <div class="col-sm-8">
                <input type="text" id="lokasi_asal" class="form-control readonly-input" value="<?php echo $row_barang['id_ruang_asal'] . ' - ' . $row_barang['bidang_ruang_asal']; ?>" readonly style="background-color: #f0f0f0;">
              </div>
            </div>

            <!-- Hidden Inputs for Lokasi Asal -->
            <input type="hidden" name="id_ruang_asal" value="<?php echo $row_barang['id_ruang_asal']; ?>">
            <input type="hidden" name="nama_ruang_asal" value="<?php echo $row_barang['nama_ruang_asal']; ?>">
            <input type="hidden" name="bidang_ruang_asal" value="<?php echo $row_barang['bidang_ruang_asal']; ?>">
            <input type="hidden" name="tempat_ruang_asal" value="<?php echo $row_barang['tempat_ruang_asal']; ?>">



            <!-- Lokasi Sekarang -->
            <div class="row mb-2">
              <label for="lokasi_sekarang" class="col-sm-3 col-form-label-kita">Ruang Sekarang<span style="color: red;">*</span></label>
              <div class="col-sm-8">
                <select id="lokasi_sekarang" name="lokasi_sekarang" class="form-select" onchange="handleLocationChange()" required>
                  <option value="">Pilih Lokasi Sekarang</option>
                  <?php foreach ($locations as $location) : ?>
                    <option value="<?php echo htmlspecialchars($location['id_lokasi']); ?>" data-nama="<?php echo htmlspecialchars($location['nama_lokasi']); ?>" data-bid="<?php echo htmlspecialchars($location['bid_lokasi']); ?>" data-tempat="<?php echo htmlspecialchars($location['tempat_lokasi']); ?>" <?php echo ($location['id_lokasi'] == $row_barang['id_ruang_sekarang']) ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars($location['id_lokasi'] . ' - ' . $location['bid_lokasi']); ?>
                    </option>
                  <?php endforeach; ?>
                  <option value="other">Tambah lokasi Baru (Masuk ke Tambah Ruang)...</option>
                </select>
              </div>
            </div>

            <!-- Hidden inputs untuk menyimpan data lokasi sekarang -->
            <input type="hidden" id="id_ruang_sekarang" name="id_ruang_sekarang" value="<?php echo htmlspecialchars($row_barang['id_ruang_sekarang']); ?>">
            <input type="hidden" id="nama_ruang_sekarang" name="nama_ruang_sekarang" value="<?php echo htmlspecialchars($row_barang['nama_ruang_sekarang']); ?>">
            <input type="hidden" id="bid_ruang_sekarang" name="bid_ruang_sekarang" value="<?php echo htmlspecialchars($row_barang['bidang_ruang_sekarang']); ?>">
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


            <!-- Kategori (Opsional) -->
            <div class="row mb-2">
              <label for="kategori" class="col-sm-3 col-form-label-kita">Kategori</label>
              <div class="col-sm-8">
                <select id="kategori" name="kategori" class="form-select" onchange="handleCategoryChange()">
                  <option value="">Pilih Kategori</option>
                  <option value="kendaraan" <?php echo ($row_barang['kategori'] == 'kendaraan') ? 'selected' : ''; ?>>Kendaraan</option>
                  <option value="peralatan" <?php echo ($row_barang['kategori'] == 'peralatan') ? 'selected' : ''; ?>>Peralatan</option>
                  <option value="mesin" <?php echo ($row_barang['kategori'] == 'mesin') ? 'selected' : ''; ?>>Mesin</option>
                  <option value="elektronik" <?php echo ($row_barang['kategori'] == 'elektronik') ? 'selected' : ''; ?>>Elektronik</option>
                </select>
              </div>
            </div>
            <!-- Harga Awal -->
            <div class="row mb-2">
              <label for="harga_awal" class="col-sm-3 col-form-label-kita">Harga<span style="color: red;">*</span></label>
              <div class="col-sm-8">
                <div class="input-group">
                  <span class="input-group-text">Rp</span>
                  <input type="text" id="harga_awal" name="harga_awal" class="form-control" value="<?php echo htmlspecialchars($row_barang['harga_awal']); ?>" readonly style="background-color: #f0f0f0;">
                </div>
              </div>
            </div>
            <!-- Tanggal Pembelian -->
            <div class="row mb-2">
              <label for="tgl_pembelian" class="col-sm-3 col-form-label-kita">Tgl Pembelian<span style="color: red;">*</span></label>
              <div class="col-sm-8">
                <input type="date" id="tgl_pembelian" name="tgl_pembelian" class="form-control" value="<?php echo htmlspecialchars($row_barang['tgl_pembelian']); ?>" readonly style="background-color: #f0f0f0;">
              </div>
            </div>
            <input type="hidden" name="tgl_pembukuan" value="<?php echo htmlspecialchars($row_barang['tgl_pembukuan']); ?>">
            <!-- Masa Manfaat -->
            <div class="row mb-2">
              <label for="masa_manfaat" class="col-sm-3 col-form-label-kita">Masa Manfaat</label>
              <div class="col-sm-8">
                <div class="input-group">
                  <input type="number" id="masa_manfaat" name="masa_manfaat" class="form-control" value="<?php echo htmlspecialchars($row_barang['masa_manfaat']); ?>">
                  <span class="input-group-text">Bulan</span>
                </div>
              </div>
            </div>
            <!-- Kondisi Barang -->
            <div class="row mb-2">
              <label for="kondisi_barang" class="col-sm-3 col-form-label-kita">Kondisi<span style="color: red;">*</span></label>
              <div class="col-sm-8">
                <select name="kondisi_barang" class="form-select" required>
                  <option value="Baik" <?php echo ($row_barang['kondisi_barang'] == 'Baik') ? 'selected' : ''; ?>>Baik</option>
                  <option value="Kurang Baik" <?php echo ($row_barang['kondisi_barang'] == 'Kurang Baik') ? 'selected' : ''; ?>>Kurang Baik</option>
                  <option value="Rusak Berat" <?php echo ($row_barang['kondisi_barang'] == 'Rusak Berat') ? 'selected' : ''; ?>>Rusak berat</option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <!-- Merk (Opsional) -->
            <div class="row mb-2">
              <label for="merk" class="col-sm-3 col-form-label-kita">Merk</label>
              <div class="col-sm-8">
                <input type="text" id="merk" name="merk" class="form-control" value="<?php echo isset($row_barang['merk']) ? htmlspecialchars($row_barang['merk']) : ''; ?>">
              </div>
            </div>

            <!-- Type (Opsional) -->
            <div class="row mb-2">
              <label for="type" class="col-sm-3 col-form-label-kita">Tipe</label>
              <div class="col-sm-8">
                <input type="text" id="type" name="type" class="form-control" value="<?php echo isset($row_barang['type']) ? htmlspecialchars($row_barang['type']) : ''; ?>">
              </div>
            </div>

            <!-- Bahan (Opsional) -->
            <div class="row mb-2">
              <label for="bahan" class="col-sm-3 col-form-label-kita">Bahan</label>
              <div class="col-sm-8">
                <input type="text" id="bahan" name="bahan" class="form-control" value="<?php echo htmlspecialchars($row_barang['bahan']); ?>">
              </div>
            </div>

            <!-- Ukuran/CC (Opsional) -->
            <div class="row mb-2">
              <label for="ukuran_CC" class="col-sm-3 col-form-label-kita">Ukuran / CC</label>
              <div class="col-sm-8">
                <input type="text" id="ukuran_CC" name="ukuran_CC" class="form-control" value="<?php echo isset($row_barang['ukuran_CC']) ? htmlspecialchars($row_barang['ukuran_CC']) : ''; ?>">
              </div>
            </div>

            <!-- No. Pabrik (Opsional) -->
            <div class="row mb-2">
              <label for="no_pabrik" class="col-sm-3 col-form-label-kita">No. Pabrik</label>
              <div class="col-sm-8">
                <input type="text" id="no_pabrik" name="no_pabrik" class="form-control" value="<?php echo isset($row_barang['no_pabrik']) ? htmlspecialchars($row_barang['no_pabrik']) : ''; ?>">
              </div>
            </div>

            <!-- No. Rangka (Opsional) -->
            <div class="row mb-2">
              <label for="no_rangka" class="col-sm-3 col-form-label-kita">No. Rangka</label>
              <div class="col-sm-8">
                <input type="text" id="no_rangka" name="no_rangka" class="form-control" value="<?php echo isset($row_barang['no_rangka']) ? htmlspecialchars($row_barang['no_rangka']) : ''; ?>">
              </div>
            </div>

            <!-- no_mesin (Opsional) -->
            <div class="row mb-2">
              <label for="no_mesin" class="col-sm-3 col-form-label-kita">No. mesin</label>
              <div class="col-sm-8">
                <input type="text" id="no_mesin" name="no_mesin" class="form-control" value="<?php echo isset($row_barang['no_mesin']) ? htmlspecialchars($row_barang['no_mesin']) : ''; ?>">
              </div>
            </div>

            <!-- No. BPKB (Opsional) -->
            <div class="row mb-2">
              <label for="no_bpkb" class="col-sm-3 col-form-label-kita">No. BPKB</label>
              <div class="col-sm-8">
                <input type="text" id="no_bpkb" name="no_bpkb" class="form-control" value="<?php echo isset($row_barang['no_bpkb']) ? htmlspecialchars($row_barang['no_bpkb']) : ''; ?>">
              </div>
            </div>

            <!-- no_polisi (Opsional) -->
            <div class="row mb-2">
              <label for="no_polisi" class="col-sm-3 col-form-label-kita">No. Polisi</label>
              <div class="col-sm-8">
                <input type="text" id="no_polisi" name="no_polisi" class="form-control" value="<?php echo isset($row_barang['no_polisi']) ? htmlspecialchars($row_barang['no_polisi']) : ''; ?>">
              </div>
            </div>



            <div class="row mb-2">
              <label for="keterangan" class="col-sm-3 col-form-label-kita">keterangan</label>
              <div class="col-sm-8">
                <textarea name="keterangan" class="form-control" id="keterangan" value="<?php echo isset($row_barang['keterangan']) ? htmlspecialchars($row_barang['keterangan']) : ''; ?>"></textarea>
              </div>
            </div>

            <input type="hidden" name="harga_total" value="<?php echo htmlspecialchars($row_barang['harga_total']); ?>">

            <!-- Foto Barang -->
            <div class="row mb-2">
              <label for="foto_barang" class="col-sm-3 col-form-label-kita">Foto Barang:</label>
              <div class="col-sm-8">
                <?php if (!empty($row_barang['foto_barang'])) : ?>
                  <img src="images/<?php echo htmlspecialchars($row_barang['foto_barang']); ?>" alt="Foto Barang" style="max-width: 200px;">
                <?php endif; ?>
                <input type="file" id="foto_barang" name="foto_barang" class="form-control">
                <small class="text-muted">Unggah file gambar (JPEG, PNG)</small>
              </div>
            </div>

            <!-- Tombol Submit -->
            <div class="row mb-4" style="padding-top: 20px;">
              <div class="col-sm-8 offset-sm-3 text-end">
                <button type="submit" class="btn btn-primary" id="submitButton">Perbaharui</button>
                <a href="Data_barang.php" class="btn btn-secondary">Batal</a>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div><!-- End Form Edit Barang -->
</main><!-- End #main -->

<?php include("component/footer.php"); ?>

<!-- JavaScript untuk Konfirmasi SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('editBarangForm').addEventListener('submit', function(event) {
    event.preventDefault();

    Swal.fire({
      title: 'Konfirmasi',
      text: 'Apakah Anda yakin ingin merubah data ini?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, update!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('editBarangForm').submit();
      }
    });
  });
</script>

<!-- Menangani Pesan Error dari Session -->
<?php
if (isset($_SESSION['error'])) {
  echo "<script>
        Swal.fire({
            title: 'Error!',
            text: '" . $_SESSION['error'] . "',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>";
  // Hapus error setelah ditampilkan
  unset($_SESSION['error']);
}
?>