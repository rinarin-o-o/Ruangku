<?php
include('component/header.php');
include('proses/barang/get data/get_data_tambah_barang.php');
?>

<main id="main" class="main">
    <div class="card">
        <div class="card-body" style="padding-top: 15px;">
            <div class="card-title">
                <h1 style="font-size: 20px !important; margin: 0;">Tambah Aset/Barang</h1>
                <hr>
            </div>
            <form method="POST" action="proses/barang/tambah_barang.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6" style="padding-right: 10px;">
                        <!-- ID Barang -->
                        <div class="row mb-2">
                            <label for="id_barang_pemda" class="col-sm-3 col-form-label">ID Pemda <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="id_barang_pemda" name="id_barang_pemda" class="form-control" required>
                            </div>
                        </div>
                        <!-- nama Barang -->
                        <div class="row mb-2">
                            <label for="nama_barang" class="col-sm-3 col-form-label">Nama Aset <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="nama_barang" class="form-control" id="nama_barang" required>
                            </div>
                        </div>
                        <!-- kode Barang -->
                        <div class="row mb-2">
                            <label for="kode_barang" class="col-sm-3 col-form-label">Kode Aset <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="kode_barang" class="form-control" id="kode_barang" required>
                            </div>
                        </div>
                        <!-- pemilik -->
                        <div class="row mb-2">
                            <label for="kode_pemilik" class="col-sm-3 col-form-label">Pemilik <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <select id="kode_pemilik" name="kode_pemilik" class="form-select" required>
                                    <option value="">Pilih Kode Pemilik</option>
                                    <?php foreach ($pemilikya as $pemilik) : ?>
                                        <option value="<?php echo htmlspecialchars($pemilik['kode_pemilik']); ?>">
                                            <?php echo htmlspecialchars($pemilik['kode_pemilik'] . ' - ' . $pemilik['nama_pemilik']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- no reg -->
                        <div class="row mb-2">
                            <label for="no_regristrasi" class="col-sm-3 col-form-label">No. Reg <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="no_regristrasi" name="no_regristrasi" class="form-control" id="no_regristrasi" requred>
                            </div>
                        </div>
                        <!-- Lokasi Sekarang -->
                        <div class="row mb-2">
                            <label for="lokasi_sekarang" class="col-sm-3 col-form-label">Ruang: <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <select id="lokasi_sekarang" name="lokasi_sekarang" class="form-select" onchange="handleLocationChange()" required>
                                    <option value="" disabled selected>Pilih Ruang</option>
                                    <?php foreach ($locations as $location) : ?>
                                        <option value="<?php echo htmlspecialchars($location['id_lokasi']); ?>" data-nama="<?php echo htmlspecialchars($location['nama_lokasi']); ?>" data-bidang="<?php echo htmlspecialchars($location['bid_lokasi']); ?>" data-tempat="<?php echo htmlspecialchars($location['tempat_lokasi']); ?>">
                                            <?php echo htmlspecialchars($location['id_lokasi'] . ' - ' . $location['bid_lokasi']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                    <option value="other">Tambah Lokasi Baru</option>
                                </select>
                            </div>
                        </div>
                        <!-- Hidden input lokasi sekarang -->
                        <input type="hidden" id="id_ruang_sekarang" name="id_ruang_sekarang">
                        <input type="hidden" id="nama_ruang_sekarang" name="nama_ruang_sekarang">
                        <input type="hidden" id="bidang_ruang_sekarang" name="bidang_ruang_sekarang">
                        <input type="hidden" id="tempat_ruang_sekarang" name="tempat_ruang_sekarang">
                        <!-- Kategori -->
                        <div class="row mb-2">
                            <label for="kategori" class="col-sm-3 col-form-label">Kategori: <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <select id="kategori" name="kategori" class="form-select">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="Barang Tetap">Barang Tetap</option>
                                    <option value="Barang Bergerak (Peralatan)">Barang Bergerak (Peralatan)</option>
                                    <option value="Barang Bergerak (Elektronik)">Barang Bergerak (Elektronik)</option>
                                    <option value="Barang Bergerak (Kendaraan)">Barang Bergerak (Kendaraan)</option>
                                </select>
                            </div>
                        </div>
                        <!-- harga -->
                        <div class="row mb-2">
                            <label for="harga_awal" class="col-sm-3 col-form-label">Harga <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" id="harga_awal" name="harga_awal" class="form-control" id="harga_awal" step="0.01">
                                </div>
                            </div>
                        </div>
                        <!-- hidden input pemeliharaan -->
                        <input type="hidden" id="harga_total" name="harga_total" class="form-control" id="harga_total" step="0.01">
                        <!-- tgl beli -->
                        <div class="row mb-2">
                            <label for="tgl_pembelian" class="col-sm-3 col-form-label">Tgl Pembelian <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <input type="date" name="tgl_pembelian" class="form-control" id="tgl_pembelian">
                            </div>
                        </div>
                        <!-- masa manfaat -->
                        <div class="row mb-2">
                            <label for="masa_manfaat" class="col-sm-3 col-form-label">Masa Manfaat</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="number" id="masa_manfaat" name="masa_manfaat" class="form-control" id="masa_manfaat">
                                    <span class="input-group-text">Bulan</span>
                                </div>
                            </div>
                        </div>
                        <!-- Kondisi barang -->
                        <div class="row mb-2">
                            <label for="kondisi_barang" class="col-sm-3 col-form-label">Kondisi <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <select name="kondisi_barang" class="form-select" id="kondisi_barang" required>
                                    <option value="" disabled selected>Pilih Kondisi</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Kurang Baik">Kurang Baik</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                            </div>
                        </div>
                    </div> <!-- end kolom -->
                    <div class="col-md-6">
                        <!-- merk -->
                        <div class="row mb-2">
                            <label for="merk" class="col-sm-3 col-form-label">Merk</label>
                            <div class="col-sm-8">
                                <input type="text" name="merk" class="form-control" id="merk">
                            </div>
                        </div>
                        <!-- tipe -->
                        <div class="row mb-2">
                            <label for="type" class="col-sm-3 col-form-label">Tipe</label>
                            <div class="col-sm-8">
                                <input type="text" name="type" class="form-control" id="type">
                            </div>
                        </div>
                        <!-- bahan -->
                        <div class="row mb-2">
                            <label for="bahan" class="col-sm-3 col-form-label">Bahan</label>
                            <div class="col-sm-8">
                                <input type="text" name="bahan" class="form-control" id="bahan">
                            </div>
                        </div>
                        <!-- ukuran -->
                        <div class="row mb-2">
                            <label for="ukuran_CC" class="col-sm-3 col-form-label">Ukuran / CC</label>
                            <div class="col-sm-8">
                                <input type="text" name="ukuran_CC" class="form-control" id="ukuran_CC">
                            </div>
                        </div>
                        <!-- no pabrik -->
                        <div class="row mb-2">
                            <label for="no_pabrik" class="col-sm-3 col-form-label">No. Pabrik</label>
                            <div class="col-sm-8">
                                <input type="text" name="no_pabrik" class="form-control" id="no_pabrik">
                            </div>
                        </div>
                        <!-- no rangka -->
                        <div class="row mb-2">
                            <label for="no_rangka" class="col-sm-3 col-form-label">No. Rangka</label>
                            <div class="col-sm-8">
                                <input type="text" name="no_rangka" class="form-control" id="no_rangka">
                            </div>
                        </div>
                        <!-- no mesin -->
                        <div class="row mb-2">
                            <label for="no_mesin" class="col-sm-3 col-form-label">No. Mesin</label>
                            <div class="col-sm-8">
                                <input type="text" name="no_mesin" class="form-control" id="no_mesin">
                            </div>
                        </div>
                        <!-- no bpkb -->
                        <div class="row mb-2">
                            <label for="no_bpkb" class="col-sm-3 col-form-label">No. BPKB</label>
                            <div class="col-sm-8">
                                <input type="text" name="no_bpkb" class="form-control" id="no_bpkb">
                            </div>
                        </div>
                        <!-- no polisi -->
                        <div class="row mb-2">
                            <label for="no_polisi" class="col-sm-3 col-form-label">No. Polisi</label>
                            <div class="col-sm-8">
                                <input type="text" name="no_polisi" class="form-control" id="no_polisi">
                            </div>
                        </div>
                        <input type="hidden" id="masa_stnk" name="masa_stnk">
                        <input type="hidden" id="tgl_bayar_stnk" name="tgl_bayar_stnk">
                        <input type="hidden" id="tgl_bayar_no_stnk" name="tgl_bayar_no_stnk">
                        <input type="hidden" id="masa_no_polisi" name="masa_no_polisi">
                        <input type="hidden" id="status_stnk" name="status_stnk">
                        <input type="hidden" id="status_no_polisi" name="status_no_polisi">
                        <input type="hidden" id="pengguna" name="pengguna">
                        <!-- Keterangan -->
                        <div class="row mb-2">
                            <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <textarea name="keterangan" class="form-control" id="keterangan"></textarea>
                            </div>
                        </div>
                        <!-- foto -->
                        <div class="row mb-4">
                            <label for="foto_barang" class="col-sm-3 col-form-label">Foto Barang</label>
                            <div class="col-sm-8">
                                <input type="file" name="foto_barang" class="form-control" id="foto_barang">
                            </div>
                        </div>
                    </div>
                </div> <!-- end kolom -->
                <div class="row mb-2">
                    <div class="col-sm-11  text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="Data_barang.php" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- End form -->
</main><!-- End Main Content -->

<?php include("component/footer.php"); ?>