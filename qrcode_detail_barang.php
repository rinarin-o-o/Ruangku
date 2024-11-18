<?php
include('koneksi/koneksi.php');
include('component/style.php');

$id_barang_pemda = isset($_GET['id_barang_pemda']) ? $_GET['id_barang_pemda'] : '';

$sql = "SELECT * FROM data_barang WHERE id_barang_pemda = '$id_barang_pemda'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    $kode_pemilik = $row['kode_pemilik'];
    $sql_pemilik = "SELECT nama_pemilik FROM pemilik WHERE kode_pemilik = '$kode_pemilik'";
    $result_pemilik = mysqli_query($conn, $sql_pemilik);
    $row_pemilik = mysqli_fetch_assoc($result_pemilik);

    $nama_pemilik = isset($row_pemilik['nama_pemilik']) ? $row_pemilik['nama_pemilik'] : 'Pemilik tidak ditemukan';
} else {
    echo "Data barang tidak ditemukan.";
    exit;
}

$id_ruang_sekarang = $row['id_ruang_sekarang'];
$queryruang = "SELECT bid_lokasi FROM lokasi WHERE id_lokasi = '$id_ruang_sekarang'";
$resultruang = mysqli_query($conn, $queryruang);

if (mysqli_num_rows($resultruang) > 0) {
    $rowruang = mysqli_fetch_assoc($resultruang);
} else {
    $rowruang['bidang_lokasi'] = 'Lokasi tidak ditemukan';
}

?>
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="#" class="logo d-flex align-items-center" style="margin-left: 20px;">
            <img src="images/logo.png" alt="" style="width:auto; height:40px;">
            <span class="d-inline-block">Ruang<span style="color: #72a7df;">Ku</span></span>
        </a>
    </div>
</header>
<main class="container py-4 mt-5">
    <div class="card">
        <div class="card-body" style="padding-top: 10px;">
            <div class="card-title">
                <h1 style="font-size: 20px !important; margin: 0;">Detail <span style="font-size: 20px !important; margin: 0;"> | </span><span> <?php echo $row['nama_barang']; ?> </span></h1>
            </div>
            <hr>

            <form>
                <div class="row" style="padding-top: 10px;">
                    <div class="col-md-6" style="padding-right: 10px;">
                        <div class="row mb-2">
                            <!-- ID Pemda -->
                            <label for="id_barang_pemda" class="col-sm-3 col-form-label">ID Pemda</label>
                            <div class="col-sm-8">
                                <input type="text" id="id_barang_pemda" class="form-control" value="<?php echo $row['id_barang_pemda']; ?>" readonly style="font-weight: bold;">
                            </div>
                        </div>
                        <!-- Nama Barang -->
                        <div class="row mb-2">
                            <label for="nama_barang" class="col-sm-3 col-form-label">Nama Aset</label>
                            <div class="col-sm-8">
                                <input type="text" id="nama_barang" class="form-control" value="<?php echo $row['nama_barang']; ?>" readonly style="font-weight: bold;">
                            </div>
                        </div>
                        <!-- Kode Barang -->
                        <div class="row mb-2">
                            <label for="kode_barang" class="col-sm-3 col-form-label">Kode Aset</label>
                            <div class="col-sm-8">
                                <input type="text" id="kode_barang" class="form-control" value="<?php echo $row['kode_barang']; ?>" readonly>
                            </div>
                        </div>
                        <!-- Kode Pemilik dan Nama Pemilik -->
                        <div class="row mb-2">
                            <label for="kode_pemilik" class="col-sm-3 col-form-label">Pemilik</label>
                            <div class="col-sm-8">
                                <input type="text" id="pemilik" class="form-control readonly-input" value="<?php echo htmlspecialchars($row['kode_pemilik'] . ' - ' . $nama_pemilik); ?>" readonly>
                            </div>
                        </div>

                        <!-- No. Registrasi -->
                        <div class="row mb-2">
                            <label for="no_regristrasi" class="col-sm-3 col-form-label">No. Reg</label>
                            <div class="col-sm-8">
                                <input type="text" id="no_regristrasi" class="form-control" value="<?php echo $row['no_regristrasi']; ?>" readonly>
                            </div>
                        </div>

                        <!-- Lokasi Asal -->
                        <div class="row mb-2">
                            <label for="lokasi_asal" class="col-sm-3 col-form-label">Ruang Asal</label>
                            <div class="col-sm-8">
                                <input type="text" id="lokasi_asal" class="form-control" value="<?php echo $row['id_ruang_asal'] . ' - ' . $row['bidang_ruang_asal']; ?>" readonly>
                            </div>
                        </div>

                        <!-- Lokasi Sekarang -->
                        <div class="row mb-2">
                            <label for="lokasi_sekarang" class="col-sm-3 col-form-label">Ruang Sekarang</label>
                            <div class="col-sm-8">
                                <input type="text" id="lokasi_sekarang" class="form-control" value="<?php echo htmlspecialchars($id_ruang_sekarang . ' - ' . $row['bidang_ruang_sekarang']); ?>" readonly>
                            </div>
                        </div>
                        <!-- Kategori -->
                        <div class="row mb-2">
                            <label for="kategori" class="col-sm-3 col-form-label">Kategori</label>
                            <div class="col-sm-8">
                                <input type="text" id="kategori" class="form-control" value="<?php echo $row['kategori']; ?>" readonly>
                            </div>
                        </div>
                        <!-- Harga -->
                        <div class="row mb-2">
                            <label for="harga_awal" class="col-sm-3 col-form-label">Harga</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" id="harga_awal" class="form-control" value="<?php echo number_format($row['harga_awal'], 2, ',', '.'); ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- Tanggal Pembelian -->
                        <div class="row mb-2">
                            <label for="tgl_pembelian" class="col-sm-3 col-form-label">Tgl Pembelian</label>
                            <div class="col-sm-8">
                                <input type="text" id="tgl_pembelian" class="form-control" value="<?php echo date('d/m/Y', strtotime($row['tgl_pembelian'])); ?>" readonly>
                            </div>
                        </div>
                        <!-- Tanggal Pembukuan
            <div class="row mb-2">
              <label for="tgl_pembukuan" class="col-sm-3 col-form-label">Tanggal Pembukuan:</label>
              <div class="col-sm-8">
                <input type="text" id="tgl_pembukuan" class="form-control" value="<?php echo date('d/m/Y', strtotime($row['tgl_pembukuan'])); ?>" readonly>
              </div>
            </div>
--> <!-- Masa Nabaat -->
                        <div class="row mb-2">
                            <label for="masa_manfaat" class="col-sm-3 col-form-label">Masa Manfaat</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" id="masa_manfaat" class="form-control" value="<?php echo $row['masa_manfaat']; ?>" readonly>
                                    <span class="input-group-text">Bulan</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="kondisi_barang" class="col-sm-3 col-form-label">Kondisi</label>
                            <div class="col-sm-8">
                                <input type="text" id="kondisi_barang" class="form-control" value="<?php echo $row['kondisi_barang']; ?>" readonly>
                            </div>
                        </div>
                        <?php
                        // Query untuk mengambil semua data pemeliharaan terkait dengan barang
                        $query_pemeliharaan = "SELECT * FROM data_pemeliharaan WHERE id_barang_pemda = $id_barang_pemda";
                        $result_pemeliharaan = mysqli_query($conn, $query_pemeliharaan);

                        // Hitung total data pemeliharaan
                        $total_pemeliharaan = mysqli_num_rows($result_pemeliharaan);
                        $index = 1; // Inisialisasi penghitung
                        ?>

                        <div class="row mb-2">
                            <label for="harga_total" class="col-sm-3 col-form-label">Pemeliharaan</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" id="harga_total" class="form-control" value="<?php echo number_format($row['harga_total'], 2, ',', '.'); ?>" readonly>
                                </div>
                            </div>

                            <div class="col-sm-3 d-flex justify-content-end align-items-center" style="padding-right: 50px;">
                                <a href="frm_tambah_pemeliharaan.php?id_barang_pemda=<?php echo $id_barang_pemda; ?>" class="btn btn-primary btn-sm me-2" title="Tambah Pemeliharaan">
                                    +
                                </a>

                                <a href="javascript:void(0);" id="togglePemeliharaanButton" onclick="togglePemeliharaan()" class="btn btn-outline-info btn-sm" title="Riwayat Pemeliharaan">
                                    <i class="bi bi-clock-history"></i>
                                </a>
                            </div>

                            <!-- Card Riwayat Pemeliharaan -->
                            <div class="d-none d-flex justify-content mb-3" id="PemeliharaanSection">
                                <div class="col-sm-3"></div> <!-- Offset agar sejajar dengan input -->
                                <div class="col-sm-8">
                                    <div class="card-body" style="font-size: 12px; background-color: #f7faff; border: 1px; padding-bottom:0;">
                                        <h5 class="card-title">
                                            Riwayat Pemeliharaan <span>| <?php echo $row['nama_barang']; ?></span>
                                        </h5>
                                        <div class="activity position-relative" style="margin-left: 20px;">

                                            <?php while ($row_pemeliharaan = mysqli_fetch_assoc($result_pemeliharaan)) : ?>
                                                <div class="activity-item d-flex mb-3 position-relative">
                                                    <div class="activity-label" style="width: 100px;">
                                                        <?php echo $row_pemeliharaan['tgl_perbaikan']; ?>
                                                    </div>
                                                    <i class="bi bi-circle-fill activity-badge text-secondary align-self-start mx-2"></i>
                                                    <div class="activity-content">
                                                        <?php echo $row_pemeliharaan['perbaikan']; ?> -
                                                        <span class="text-muted">
                                                            Rp <?php echo number_format($row_pemeliharaan['biaya_perbaikan'], 2, ',', '.'); ?>
                                                        </span>
                                                    </div>

                                                    <!-- Garis timeline hanya jika bukan elemen terakhir -->
                                                    <?php if ($index < $total_pemeliharaan) : ?>
                                                        <div class="timeline-line" style="position: absolute; left: 113px; top: 15px; width: 2px; height: 110%; 
                          background-color: #b8b8b9;">
                                                        </div>
                                                    <?php endif; ?>
                                                </div><!-- End activity item -->
                                                <?php $index++; // Increment penghitung 
                                                ?>
                                            <?php endwhile; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function togglePemeliharaan() {
                                    var PemeliharaanSection = document.getElementById("PemeliharaanSection");
                                    var toggleButton = document.getElementById("togglePemeliharaanButton");

                                    PemeliharaanSection.classList.toggle("d-none"); // Toggle visibility

                                    if (PemeliharaanSection.classList.contains("d-none")) {
                                        // Saat tersembunyi, kembali ke tombol info dengan ikon jam
                                        toggleButton.className = "btn btn-outline-info btn-sm";
                                        toggleButton.innerHTML = '<i class="bi bi-clock-history"></i>';
                                    } else {
                                        // Saat tampil, ubah jadi tombol danger dengan ikon X
                                        toggleButton.className = "btn btn-danger btn-sm";
                                        toggleButton.innerHTML = '<i class="bi bi-x-circle" title="Close"></i>';
                                    }
                                }
                            </script>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Merk -->
                        <div class="row mb-2">
                            <label for="merk" class="col-sm-3 col-form-label">Merk</label>
                            <div class="col-sm-8">
                                <input type="text" id="merk" class="form-control" value="<?php echo $row['merk']; ?>" readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="type" class="col-sm-3 col-form-label">Tipe</label>
                            <div class="col-sm-8">
                                <input type="text" id="type" class="form-control" value="<?php echo $row['type']; ?>" readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="bahan" class="col-sm-3 col-form-label">Bahan</label>
                            <div class="col-sm-8">
                                <input type="text" id="bahan" class="form-control" value="<?php echo $row['bahan']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="ukuran_CC" class="col-sm-3 col-form-label">Ukuran / CC</label>
                            <div class="col-sm-8">
                                <input type="text" id="ukuran_CC" class="form-control" value="<?php echo $row['ukuran_CC']; ?>" readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="no_pabrik" class="col-sm-3 col-form-label">No. Pabrik</label>
                            <div class="col-sm-8">
                                <input type="text" id="no_pabrik" class="form-control" value="<?php echo $row['no_pabrik']; ?>" readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="no_rangka" class="col-sm-3 col-form-label">No. Rangka</label>
                            <div class="col-sm-8">
                                <input type="text" id="no_rangka" class="form-control" value="<?php echo $row['no_rangka']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="no_mesin" class="col-sm-3 col-form-label">No. Mesin</label>
                            <div class="col-sm-8">
                                <input type="text" id="no_mesin" class="form-control" value="<?php echo $row['no_mesin']; ?>" readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="no_bpkb" class="col-sm-3 col-form-label">No. BPKB</label>
                            <div class="col-sm-8">
                                <input type="text" id="no_bpkb" class="form-control" value="<?php echo $row['no_bpkb']; ?>" readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="no_polisi" class="col-sm-3 col-form-label">No. Polisi</label>
                            <div class="col-sm-8">
                                <input type="text" id="no_polisi" class="form-control" value="<?php echo $row['no_polisi']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="keterangan" class="col-sm-3 col-form-label">Keterangan:</label>
                            <div class="col-sm-8">
                                <textarea id="keterangan" class="form-control" rows="3" readonly><?php echo $row['keterangan']; ?></textarea>
                            </div>
                        </div>

                        <!-- Foto Toggle Section -->
                        <div class="row mb-4">
                            <label class="col-sm-3 col-form-label">Foto:</label>
                            <div class="col-sm-8">
                                <a href="javascript:void(0);" id="togglePhotoLink" onclick="togglePhoto()" style="font-size: 15px;">Lihat Foto...</a>
                            </div>
                        </div>
                        <div id="photoSection" style="display:none;" class="row mb-3">
                            <div class="col-sm-3 offset-sm-3">
                                <?php if (!empty($row['foto_barang'])) : ?>
                                    <img src="images/<?php echo $row['foto_barang']; ?>" alt="Foto Barang" class="img-fluid" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;">
                                <?php else : ?>
                                    <p style="font-size: 15px;">None</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-11 text-end">
                                <a href="qrcode_login.php?id_barang_pemda=<?php echo $row['id_barang_pemda']; ?>">
                                    Data tidak sesuai? Klik di sini untuk mengedit.
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- End Item Details -->
</main>
<footer class="text-center fixed-bottom" style="background-color: white; padding: 5px 5px; height:30px; font-size: 12px; border-top: 1px solid #e0e0e0; transition: all 0.3s;">
    &copy; 2024 <strong><span>Informatika UNIMUS</span></strong>
    <span> - </span>
    <strong><span>Dinkominfotik Brebes</span></strong>
</footer>

<script>
    function togglePhoto() {
        var photoSection = document.getElementById("photoSection");
        var toggleLink = document.getElementById("togglePhotoLink");
        if (photoSection.style.display === "none") {
            photoSection.style.display = "block";
            toggleLink.innerHTML = "Tutup Foto...";
        } else {
            photoSection.style.display = "none";
            toggleLink.innerHTML = "Lihat Foto...";
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Event handler for delete button
        $('.btn-hapus').on('click', function(e) {
            e.preventDefault(); // Prevent the default anchor behavior
            var id_barang_pemda = $(this).data('id_barang_pemda'); // Get the id_barang_pemda from data attribute

            // SweetAlert confirmation dialog
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data barang akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'proses/barang/hapus_barang.php?id_barang_pemda=' + id_barang_pemda;
                }
            });
        });
    });
</script>