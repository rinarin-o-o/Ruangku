<!--kyaknya gk ada yang salah, tapi gk bisa ngeproses hasil edit/update-annya-->
<?php
ob_start();
include('component/header.php');
include('koneksi/koneksi.php');

$id_mutasi = $_GET['id_mutasi'];

// Fetch existing location data
$sql = "SELECT * FROM mutasi_barang WHERE id_mutasi = '$id_mutasi'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
} else {
    // Redirect to the location list page if no data found
    header('Location: Data_mutasi_barang.php');
    exit;
}
?>

<main id="main" class="main">
    <!-- Edit Location Form -->
    <div class="card">
        <div class="card-body" style="padding-top: 10px;">
            <div class="card-title">
                <h1 style="font-size: 20px !important; margin: 0;">
                    Edit Mutasi
                    <span style="font-size: 20px !important; margin: 0;"> | </span>
                    <span>
                        <?php
                        // Mengubah tanggal menjadi format yang diinginkan
                        $tanggal = strtotime($row['tgl_mutasi']);
                        echo $row['nama_barang'] . ' - ' . date('d F Y', $tanggal);
                        ?>
                    </span>
                </h1>
                <hr>
            </div>

            <form id="editMutasiForm" action="proses/mutasi/edit_mutasi.php" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-2">
                            <label for="id_barang_pemda" class="col-sm-3 col-form-label">ID Pemda</label>
                            <div class="col-sm-8">
                                <input type="text" name="id_barang_pemda" class="form-control readonly-input" value="<?php echo htmlspecialchars($row['id_barang_pemda']); ?>" readonly style="background-color: #f0f0f0;">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="kode_barang" class="col-sm-3 col-form-label">Kode Aset</label>
                            <div class="col-sm-8">
                                <input type="text" name="kode_barang" class="form-control readonly-input" value="<?php echo htmlspecialchars($row['kode_barang']); ?>" readonly style="background-color: #f0f0f0;">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="nama_barang" class="col-sm-3 col-form-label">Nama Aset</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama_barang" class="form-control readonly-input" value="<?php echo htmlspecialchars($row['nama_barang']); ?>" readonly style="background-color: #f0f0f0;">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="ruang_asal" class="col-sm-3 col-form-label">Lokasi Lama</label>
                            <div class="col-sm-8">
                                <input type="text" name="ruang_asal" class="form-control readonly-input" value="<?php echo htmlspecialchars($row['ruang_asal']); ?>" readonly style="background-color: #f0f0f0;">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="ruang_tujuan" class="col-sm-3 col-form-label">Lokasi Sekarang</label>
                            <div class="col-sm-8">
                                <input type="text" name="ruang_tujuan" class="form-control readonly-input" value="<?php echo htmlspecialchars($row['ruang_tujuan']); ?>" readonly style="background-color: #f0f0f0;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-2">
                            <label for="id_mutasi" class="col-sm-3 col-form-label">ID Mutasi</label>
                            <div class="col-sm-8">
                                <input type="text" name="id_mutasi" class="form-control readonly-input" value="<?php echo $id_mutasi; ?>" readonly style="background-color: #f0f0f0;">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="tgl_mutasi" class="col-sm-3 col-form-label">Tanggal Mutasi</label>
                            <div class="col-sm-8">
                                <input type="date" name="tgl_mutasi" class="form-control" value="<?php echo htmlspecialchars($row['tgl_mutasi']); ?>" readonly style="background-color: #f0f0f0;">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="jenis_mutasi" class="col-sm-3 col-form-label">Jenis Mutasi</label>
                            <div class="col-sm-8">
                                <input type="text" name="jenis_mutasi" class="form-control" value="<?php echo htmlspecialchars($row['jenis_mutasi'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                        <label for="penanggungjawab" class="col-sm-3 col-form-label" data-bs-toggle="tooltip" data-bs-placement="left" title="Penanggungjawab">PJ</label>
                            <div class="col-sm-8">
                                <input type="text" name="penanggungjawab" class="form-control" value="<?php echo htmlspecialchars($row['penanggungjawab'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <input type="text" name="keterangan" class="form-control" value="<?php echo htmlspecialchars($row['keterangan'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-8 offset-sm-3 text-end">
                                <button type="submit" class="btn btn-primary">Perbaharui</button>
                                <a href="Data_mutasi_barang.php" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include("component/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('editMutasiForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting immediately

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Simpan perubahan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                document.getElementById('editMutasiForm').submit();
            }
        });
    });
</script>

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
    // Reset session error after showing popup
    unset($_SESSION['error']);
}
?>