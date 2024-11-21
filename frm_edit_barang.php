<?php
include('component/header.php');
include('proses/barang/get data/get_data_edit_barang.php');
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
                <input type="hidden" id="kode_pemilik" name="kode_pemilik" value="<?php echo htmlspecialchars($row_barang['kode_pemilik']); ?>"> <!-- Hidden input kode_pemilik -->
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
            <!-- Hidden Input  Lokasi Asal -->
            <input type="hidden" name="id_ruang_asal" value="<?php echo $row_barang['id_ruang_asal']; ?>">
            <input type="hidden" name="nama_ruang_asal" value="<?php echo $row_barang['nama_ruang_asal']; ?>">
            <input type="hidden" name="bidang_ruang_asal" value="<?php echo $row_barang['bidang_ruang_asal']; ?>"> <input type="hidden" name="tempat_ruang_asal" value="<?php echo $row_barang['tempat_ruang_asal']; ?>">
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
            <!-- Hidden input lokasi sekarang -->
            <input type="hidden" id="id_ruang_sekarang" name="id_ruang_sekarang" value="<?php echo htmlspecialchars($row_barang['id_ruang_sekarang']); ?>">
            <input type="hidden" id="nama_ruang_sekarang" name="nama_ruang_sekarang" value="<?php echo htmlspecialchars($row_barang['nama_ruang_sekarang']); ?>">
            <input type="hidden" id="bid_ruang_sekarang" name="bid_ruang_sekarang" value="<?php echo htmlspecialchars($row_barang['bidang_ruang_sekarang']); ?>">
            <input type="hidden" id="tempat_ruang_sekarang" name="tempat_ruang_sekarang" value="<?php echo htmlspecialchars($row_barang['tempat_ruang_sekarang']); ?>">
            <!-- Kategori -->
            <div class="row mb-2">
              <label for="kategori" class="col-sm-3 col-form-label-kita">Kategori</label>
              <div class="col-sm-8">
                <select id="kategori" name="kategori" class="form-select" onchange="handleCategoryChange()">
                  <option value="">Pilih Kategori</option>
                  <option value="Barang Tetap" <?php echo ($row_barang['kategori'] == 'Barang Tetap') ? 'selected' : ''; ?>>Barang Tetap</option>
                  <option value="Barang Bergerak (Peralatan)" <?php echo ($row_barang['kategori'] == 'Barang Bergerak (Peralatan)') ? 'selected' : ''; ?>>Barang Bergerak (Peralatan)</option>
                  <option value="Barang Bergerak (Elektronik)" <?php echo ($row_barang['kategori'] == 'Barang Bergerak (Elektronik)') ? 'selected' : ''; ?>>Barang Bergerak (Elektronik)</option>
                  <option value="Barang Bergerak (Kendaraan)" <?php echo ($row_barang['kategori'] == 'Barang Bergerak (Kendaraan)') ? 'selected' : ''; ?>>Barang Bergerak (Kendaraan)</option>
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
          </div> <!-- end kolom -->
          <div class="col-md-6">
            <!-- Merk -->
            <div class="row mb-2">
              <label for="merk" class="col-sm-3 col-form-label-kita">Merk</label>
              <div class="col-sm-8">
                <input type="text" id="merk" name="merk" class="form-control" value="<?php echo isset($row_barang['merk']) ? htmlspecialchars($row_barang['merk']) : ''; ?>">
              </div>
            </div>
            <!-- Type -->
            <div class="row mb-2">
              <label for="type" class="col-sm-3 col-form-label-kita">Tipe</label>
              <div class="col-sm-8">
                <input type="text" id="type" name="type" class="form-control" value="<?php echo isset($row_barang['type']) ? htmlspecialchars($row_barang['type']) : ''; ?>">
              </div>
            </div>
            <!-- Bahan -->
            <div class="row mb-2">
              <label for="bahan" class="col-sm-3 col-form-label-kita">Bahan</label>
              <div class="col-sm-8">
                <input type="text" id="bahan" name="bahan" class="form-control" value="<?php echo htmlspecialchars($row_barang['bahan']); ?>">
              </div>
            </div>
            <!-- Ukuran/CC -->
            <div class="row mb-2">
              <label for="ukuran_CC" class="col-sm-3 col-form-label-kita">Ukuran / CC</label>
              <div class="col-sm-8">
                <input type="text" id="ukuran_CC" name="ukuran_CC" class="form-control" value="<?php echo isset($row_barang['ukuran_CC']) ? htmlspecialchars($row_barang['ukuran_CC']) : ''; ?>">
              </div>
            </div>
            <!-- No. Pabrik -->
            <div class="row mb-2">
              <label for="no_pabrik" class="col-sm-3 col-form-label-kita">No. Pabrik</label>
              <div class="col-sm-8">
                <input type="text" id="no_pabrik" name="no_pabrik" class="form-control" value="<?php echo isset($row_barang['no_pabrik']) ? htmlspecialchars($row_barang['no_pabrik']) : ''; ?>">
              </div>
            </div>
            <!-- No. Rangka -->
            <div class="row mb-2">
              <label for="no_rangka" class="col-sm-3 col-form-label-kita">No. Rangka</label>
              <div class="col-sm-8">
                <input type="text" id="no_rangka" name="no_rangka" class="form-control" value="<?php echo isset($row_barang['no_rangka']) ? htmlspecialchars($row_barang['no_rangka']) : ''; ?>">
              </div>
            </div>
            <!-- no_mesin -->
            <div class="row mb-2">
              <label for="no_mesin" class="col-sm-3 col-form-label-kita">No. mesin</label>
              <div class="col-sm-8">
                <input type="text" id="no_mesin" name="no_mesin" class="form-control" value="<?php echo isset($row_barang['no_mesin']) ? htmlspecialchars($row_barang['no_mesin']) : ''; ?>">
              </div>
            </div>
            <!-- No. BPKB -->
            <div class="row mb-2">
              <label for="no_bpkb" class="col-sm-3 col-form-label-kita">No. BPKB</label>
              <div class="col-sm-8">
                <input type="text" id="no_bpkb" name="no_bpkb" class="form-control" value="<?php echo isset($row_barang['no_bpkb']) ? htmlspecialchars($row_barang['no_bpkb']) : ''; ?>">
              </div>
            </div>
            <!-- no_polisi -->
            <div class="row mb-2">
              <label for="no_polisi" class="col-sm-3 col-form-label-kita">No. Polisi</label>
              <div class="col-sm-8">
                <input type="text" id="no_polisi" name="no_polisi" class="form-control" value="<?php echo isset($row_barang['no_polisi']) ? htmlspecialchars($row_barang['no_polisi']) : ''; ?>">
              </div>
            </div>
            <input type="hidden" name="masa_stnk" value="<?php echo htmlspecialchars($row_barang['masa_stnk'] ?? ''); ?>">
            <input type="hidden" name="masa_no_polisi" value="<?php echo htmlspecialchars($row_barang['masa_no_polisi'] ?? ''); ?>">
            <input type="hidden" name="status_stnk" value="<?php echo htmlspecialchars($row_barang['status_stnk'] ?? ''); ?>">
            <input type="hidden" name="status_no_polisi" value="<?php echo htmlspecialchars($row_barang['status_no_polisi'] ?? ''); ?>">
            <input type="hidden" name="pengguna" value="<?php echo htmlspecialchars($row_barang['pengguna'] ?? ''); ?>">
            <input type="hidden" name="tgl_bayar_stnk" value="<?php echo htmlspecialchars($row_barang['tgl_bayar_stnk'] ?? ''); ?>">
            <input type="hidden" name="tgl_bayar_no_polisi" value="<?php echo htmlspecialchars($row_barang['tgl_bayar_no_polisi'] ?? ''); ?>">

            <!-- keterangan -->
            <div class="row mb-2">
              <label for="keterangan" class="col-sm-3 col-form-label-kita">keterangan</label>
              <div class="col-sm-8">
                <textarea name="keterangan" class="form-control" id="keterangan" value="<?php echo isset($row_barang['keterangan']) ? htmlspecialchars($row_barang['keterangan']) : ''; ?>"></textarea>
              </div>
            </div>
            <!-- hidden input pemeliharaan -->
            <input type="hidden" name="harga_total" value="<?php echo htmlspecialchars($row_barang['harga_total']); ?>">
            <!-- Foto Barang -->
            <div class="row mb-2">
              <label for="foto_barang" class="col-sm-3 col-form-label-kita">Foto Barang:</label>
              <div class="col-sm-8">
                <?php if (!empty($row_barang['foto_barang'])) : ?>
                  <img src="assets/images/<?php echo htmlspecialchars($row_barang['foto_barang']); ?>" alt="Foto Barang" style="max-width: 200px; margin-bottom: 10px;">
                <?php endif; ?>
                <input type="file" id="foto_barang" name="foto_barang" class="form-control" style="margin-top: 10px;">
                <small class="text-muted">Unggah file gambar (JPEG, JPG, PNG)</small>
              </div>
            </div>

            <!-- Tombol Submit -->
            <div class="row mb-4" style="padding-top: 20px;">
              <div class="col-sm-8 offset-sm-3 text-end">
                <button type="submit" class="btn btn-primary" id="submitButton">Perbaharui</button>
                <a href="Data_barang.php" class="btn btn-secondary">Batal</a>
              </div>
            </div>
          </div> <!-- end kolom -->
        </div> <!-- end row -->
      </form>
    </div>
  </div><!-- End card Edit Barang -->
</main>

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