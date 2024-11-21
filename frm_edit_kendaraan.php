<?php
include('component/header.php');
include('proses/barang/get data/get_data_edit_barang.php');
?>

<main id="main" class="main">
    <div class="card">
        <div class="card-body" style="padding-top: 10px">
            <div class="card-title">
                <h1 style="font-size: 20px !important; margin: 0;">Detail Penggunaan <span style="font-size: 20px !important; margin: 0;"> | </span><span> <?php echo $row_barang['nama_barang']; ?> </span></h1>
            </div>

            <!-- Tab Navigation -->
            <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link w-100 active" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button" role="tab" aria-controls="edit" aria-selected="true">Edit Pengguna</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link w-100" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button" role="tab" aria-controls="riwayat" aria-selected="false">Riwayat Penggunaan</button>
                </li>
            </ul>
            <!-- Tab Content -->
            <div class="tab-content pt-2" id="myTabContent">
                <!-- Tab for Edit -->
                <div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                    <form id="editBarangForm" action="proses/kendaraan/edit_kendaraan.php" method="post" enctype="multipart/form-data">
                        <div class="row" style="padding-top: 10px;">
                            <div class="col-md-6">

                                <input type="hidden" name="kode_barang" value="<?php echo htmlspecialchars($row_barang['kode_barang']); ?>">
                                <input type="hidden" name="kode_pemilik" value="<?php echo htmlspecialchars($row_barang['kode_pemilik']); ?>">
                                <input type="hidden" name="no_regristrasi" value="<?php echo htmlspecialchars($row_barang['no_regristrasi']); ?>">
                                <input type="hidden" name="id_ruang_asal" value="<?php echo $row_barang['id_ruang_asal']; ?>">
                                <input type="hidden" name="nama_ruang_asal" value="<?php echo $row_barang['nama_ruang_asal']; ?>">
                                <input type="hidden" name="bidang_ruang_asal" value="<?php echo $row_barang['bidang_ruang_asal']; ?>">
                                <input type="hidden" name="tempat_ruang_asal" value="<?php echo $row_barang['tempat_ruang_asal']; ?>">
                                <input type="hidden" name="id_ruang_sekarang" value="<?php $row_barang['id_ruang_sekarang']; ?>">
                                <input type="hidden" name="nama_ruang_sekarang" value="<?php $row_barang['nama_ruang_sekarang']; ?>">
                                <input type="hidden" name="bid_ruang_sekarang" value="<?php $row_barang['bidang_ruang_sekarang']; ?>">
                                <input type="hidden" name="tempat_ruang_sekarang" value="<?php $row_barang['tempat_ruang_sekarang']; ?>">
                                <input type="hidden" name="kategori" value="<?php echo $row_barang['kategori']; ?>">
                                <input type="hidden" name="harga_awal" value="<?php echo $row_barang['harga_awal']; ?>">
                                <input type="hidden" name="tgl_pembelian" value="<?php echo $row_barang['tgl_pembelian']; ?>">
                                <input type="hidden" name="tgl_pembukuan" value="<?php echo $row_barang['tgl_pembukuan']; ?>">
                                <input type="hidden" name="masa_manfaat" value="<?php echo $row_barang['masa_manfaat']; ?>">
                                <input type="hidden" name="kondisi_barang" value="<?php echo $row_barang['kondisi_barang']; ?>">
                                <input type="hidden" name="foto_barang" value="<?php echo $row_barang['foto_barang']; ?>">
                                <input type="hidden" name="tgl_bayar_stnk" value="<?php echo $row_barang['tgl_bayar_stnk']; ?>">
                                <input type="hidden" name="tgl_bayar_no_polisi" value="<?php echo $row_barang['tgl_bayar_no_polisi']; ?>">
                                <input type="hidden" name="harga_total" value="<?php echo htmlspecialchars($row_barang['harga_total']); ?>">
                                <input type="hidden" name="keterangan" value="<?php echo htmlspecialchars($row_barang['keterangan']); ?>">
                                <div class="row mb-2">
                                    <label for="id_barang_pemda" class="col-sm-3 col-form-label-kita">ID Pemda</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="id_barang_pemda" name="id_barang_pemda" class="form-control" value="<?php echo htmlspecialchars($row_barang['id_barang_pemda']); ?>" readonly style="background-color: #f0f0f0;">
                                    </div>
                                </div>
                                <!-- Nama Barang -->
                                <div class="row mb-2">
                                    <label for="nama_barang" class="col-sm-3 col-form-label-kita">Nama Aset</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="nama_barang" name="nama_barang" class="form-control" value="<?php echo htmlspecialchars($row_barang['nama_barang']); ?>" readonly style="background-color: #f0f0f0;">
                                    </div>
                                </div>
                                <!-- Merk -->
                                <div class="row mb-2">
                                    <label for="merk" class="col-sm-3 col-form-label-kita">Merk</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="merk" name="merk" class="form-control" value="<?php echo isset($row_barang['merk']) ? htmlspecialchars($row_barang['merk']) : ''; ?>">
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
                                <div class="row mb-2">
                                    <label for="pengguna" class="col-sm-3 col-form-label-kita">Pengguna</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="pengguna" name="pengguna" class="form-control" value="<?php echo isset($row_barang['pengguna']) ? htmlspecialchars($row_barang['pengguna']) : ''; ?>">
                                    </div>
                                </div>
                            </div> <!-- end kolom -->
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <label for="masa_stnk" class="col-sm-3 col-form-label-kita">Masa STNK<span style="color: red;">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="date" id="masa_stnk" name="masa_stnk" class="form-control" value="<?php echo htmlspecialchars($row_barang['masa_stnk']); ?>">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="masa_no_polisi" class="col-sm-3 col-form-label-kita">Masa No. Polisi<span style="color: red;">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="date" id="masa_no_polisi" name="masa_no_polisi" class="form-control" value="<?php echo htmlspecialchars($row_barang['masa_no_polisi']); ?>">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="status_stnk" class="col-sm-3 col-form-label-kita">Status Pajak</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="status_stnk" name="status_stnk" class="form-control" value="<?php echo isset($row_barang['status_stnk']) ? htmlspecialchars($row_barang['status_stnk']) : ''; ?>" readonly style="background-color: #f0f0f0;">
                                    </div>
                                </div>

                                <div class="row mb-2" id="foto_stnk_row" style="display: none;">
                                    <label for="foto_stnk" class="col-sm-3 col-form-label-kita">Pembayaran</label>
                                    <div class="col-sm-8">
                                        <input type="file" id="foto_stnk" name="foto_stnk" class="form-control" style="margin-top: 10px;">
                                        <small class="text-muted">Unggah bukti pembayaran perpanjangan STNK</small>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label for="status_no_polisi" class="col-sm-3 col-form-label-kita">Status Aktif</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="status_no_polisi" name="status_no_polisi" class="form-control" value="<?php echo isset($row_barang['status_no_polisi']) ? htmlspecialchars($row_barang['status_no_polisi']) : ''; ?>" readonly style="background-color: #f0f0f0;">
                                    </div>
                                </div>

                                <div class="row mb-2" id="foto_no_polisi_row" style="display: none;">
                                    <label for="foto_no_polisi" class="col-sm-3 col-form-label-kita">Pembayaran</label>
                                    <div class="col-sm-8">
                                        <input type="file" id="foto_no_polisi" name="foto_no_polisi" class="form-control" style="margin-top: 10px;">
                                        <small class="text-muted">Unggah bukti pembayaran perpanjangan masa berlaku</small>
                                    </div>
                                </div>

                                <!-- Tombol Submit -->
                                <div class="row mb-4" style="padding-top: 20px;">
                                    <div class="col-sm-8 offset-sm-3 text-end">
                                        <button type="submit" class="btn btn-primary" id="submitButton">Perbaharui</button>
                                        <a href="kendaraan.php" class="btn btn-secondary">Batal</a>
                                    </div>
                                </div>
                            </div> <!-- end kolom -->
                        </div> <!-- end row -->
                    </form>
                </div>
            </div> <!-- end tab -->
            <!-- Tab for Riwayat Penggunaan -->
            <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                <div class="row" style="padding-top: 10px;">
                    <div class="col-md-6">
                        <div class="row mb-2">
                            <div class="col-sm-11">
                                <div class="card-body" style="font-size: 12px; background-color: #f7faff; border: 1px; padding-bottom:5px;">
                                    <h5 class="card-title">
                                        Riwayat Penggunaan <span>| <?php echo $row_barang['nama_barang'] . ' ' . $row_barang['merk']; ?></span>
                                    </h5>
                                    <div class="activity position-relative" style="margin-left: 20px;">
                                        <?php
                                        $id_barang_pemda = $row_barang['id_barang_pemda'];
                                        $query_mutasi_kendaraan = "SELECT * FROM mutasi_kendaraan WHERE id_barang_pemda = '$id_barang_pemda'";
                                        $result_mutasi_kendaraan = mysqli_query($conn, $query_mutasi_kendaraan);
                                        $total_mutasi_kendaraan = mysqli_num_rows($result_mutasi_kendaraan);
                                        $index = 1;

                                        if ($total_mutasi_kendaraan > 0) {
                                            while ($row_mutasi_kendaraan = mysqli_fetch_assoc($result_mutasi_kendaraan)) {
                                                $format_date = date('d-m-Y', strtotime($row_mutasi_kendaraan['tgl_mutasi_kendaraan']));
                                        ?>
                                                <div class="activity-item d-flex mb-3 position-relative">
                                                    <div class="activity-label" style="width: 100px;">
                                                        <?php echo $format_date; ?>
                                                    </div>
                                                    <i class="bi bi-circle-fill activity-badge text-secondary align-self-start mx-2"></i>
                                                    <div class="activity-content">
                                                        <?php echo ($row_mutasi_kendaraan['pengguna_sekarang']); ?>
                                                    </div>
                                                    <?php if ($index < $total_mutasi_kendaraan) { ?>
                                                        <div class="timeline-line" style="position: absolute; left: 113px; top: 15px; width: 2px; height: 110%; background-color: #b8b8b9;"></div>
                                                    <?php } ?>
                                                </div>
                                        <?php
                                                $index++;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <?php if (!empty($row_barang['foto_barang'])) : ?>
                                    <img src="assets/images/<?php echo htmlspecialchars($row_barang['foto_barang']); ?>" alt="Foto Barang" class="img-fluid" style="max-width: 50%; height: auto; border: 1px solid #ddd; margin-bottom: 15px;">
                                    <input type="file" id="fileInput" name="foto_barang" style="display: none;" onchange="uploadPhoto(this)">
                                    <div>
                                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('fileInput').click();">Ganti Foto</button>
                                    </div>
                                <?php else : ?>
                                    <div style="border: 2px dashed #ccc; padding: 20px; border-radius: 10px; display: inline-block; text-align: center; width: 100%;">
                                        <i class="bi bi-image" style="font-size: 50px; color: #ccc;"></i>
                                        <p style="margin-top: 10px; font-size: 15px; color: #666;">Tambahkan foto</p>
                                        <input type="file" id="fileInput" name="foto_barang" style="display: none;" onchange="uploadPhoto(this)">
                                        <!-- Tambahkan tipe button -->
                                        <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click();">Unggah Foto</button>
                                    </div>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Tab Content -->
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusStnkInput = document.getElementById('status_stnk');
        const statusNoPolisiInput = document.getElementById('status_no_polisi');
        const fotoStnkRow = document.getElementById('foto_stnk_row');
        const fotoNoPolisiRow = document.getElementById('foto_no_polisi_row');

        // Function to toggle visibility
        function toggleVisibility() {
            // Toggle foto_stnk based on status_stnk value
            if (statusStnkInput.value.trim().toLowerCase() === 'belum lunas') {
                fotoStnkRow.style.display = 'flex';
            } else {
                fotoStnkRow.style.display = 'none';
            }

            // Toggle foto_no_polisi based on status_no_polisi value
            if (statusNoPolisiInput.value.trim().toLowerCase() === 'tidak aktif') {
                fotoNoPolisiRow.style.display = 'flex';
            } else {
                fotoNoPolisiRow.style.display = 'none';
            }
        }

        // Initialize visibility on page load
        toggleVisibility();

        // Add event listeners for dynamic updates
        statusStnkInput.addEventListener('input', toggleVisibility);
        statusNoPolisiInput.addEventListener('input', toggleVisibility);
    });
</script>

<script>
    // Fungsi untuk mengunggah file secara otomatis setelah dipilih
    function uploadPhoto(input) {
        if (input.files && input.files[0]) {
            const formData = new FormData();
            formData.append('foto_barang', input.files[0]);
            formData.append('id_barang_pemda', "<?php echo $row_barang['id_barang_pemda']; ?>");

            // Debugging untuk memastikan data dikirim dengan benar
            console.log('File:', input.files[0]);
            console.log('ID Barang Pemda:', "<?php echo $row_barang['id_barang_pemda']; ?>");

            fetch('proses/elektronik/edit_foto_elektronik.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Foto berhasil diunggah!');
                        location.reload();
                    } else {
                        alert('Gagal mengunggah foto: ' + data.message);
                    }
                })
                .catch(error => {
                    location.reload();
                });
        }
    }
</script>