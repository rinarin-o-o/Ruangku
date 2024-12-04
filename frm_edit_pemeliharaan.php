<?php
ob_start();
include('component/header.php');
include('koneksi/koneksi.php');


if (!isset($_GET['id_pemeliharaan'])) {
    // Redirect to the location list page if id_pemeliharaan is not set
    header('Location: Data_pemeliharaan.php');
    exit;
}

$id_pemeliharaan = $_GET['id_pemeliharaan'];

$sql = "SELECT * FROM data_pemeliharaan WHERE id_pemeliharaan = '$id_pemeliharaan'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    // Ambil id_barang_pemda dari row
    $id_barang_pemda = $row['id_barang_pemda'];

    // Fetch no_regristrasi dari data_barang
    $sql_reg = "SELECT * FROM data_barang WHERE id_barang_pemda = '$id_barang_pemda'";
    $result_reg = mysqli_query($conn, $sql_reg);

    if (mysqli_num_rows($result_reg) == 1) {
        $row_reg = mysqli_fetch_assoc($result_reg);
    } else {
        // Jika tidak ada no_regristrasi ditemukan, bisa redirect atau handle error
        $row_reg['no_regristrasi'] = 'Tidak ada registrasi'; // Contoh penanganan
    }
} else {
    // Redirect to the location list page if no data found
    header('Location: Data_pemeliharaan.php');
    exit;
}
?>

<main id="main" class="main">

    <div class="card">
        <div class="card-body" style="padding-top: 10px;">
            <div class="card-title">
                <h1 style="font-size: 20px !important; margin: 0;">
                    Edit Pemeliharaan
                    <span style="font-size: 20px !important; margin: 0;"> | </span>
                    <span>
                        <?php
                        // Mengubah tanggal menjadi format yang diinginkan
                        $tanggal = strtotime($row['tgl_perbaikan']);
                        echo $row_reg['nama_barang'] . ' - ' . date('d F Y', $tanggal);
                        ?>
                    </span>
                </h1>
            </div>
            <hr>

            <form id="editPemeliharaanForm" method="POST" action="proses/pemeliharaan/edit_pemeliharaan.php"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-2">
                            <label for="id_pemeliharaan" class="col-sm-3 col-form-label">ID Pemeliharaan</label>
                            <div class="col-sm-8">
                                <input type="text" id="id_pemeliharaan" name="id_pemeliharaan"
                                    class="form-control readonly-input"
                                    value="<?php echo htmlspecialchars($row['id_pemeliharaan']); ?>" readonly
                                    style="background-color: #f0f0f0;">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="id_barang_pemda" class="col-sm-3 col-form-label">ID Pemda</label>
                            <div class="col-sm-8">
                                <input type="text" id="id_barang_pemda" name="id_barang_pemda"
                                    class="form-control readonly-input"
                                    value="<?php echo htmlspecialchars($row['id_barang_pemda']); ?>" readonly
                                    style="background-color: #f0f0f0;">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="kode_barang" class="col-sm-3 col-form-label">Kode Aset</label>
                            <div class="col-sm-8">
                                <input type="text" id="kode_barang" name="kode_barang"
                                    class="form-control readonly-input"
                                    value="<?php echo htmlspecialchars($row['kode_barang']); ?>" readonly
                                    style="background-color: #f0f0f0;">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="nama_barang" class="col-sm-3 col-form-label">Nama Aset</label>
                            <div class="col-sm-8">
                                <input type="text" id="nama_barang" name="nama_barang"
                                    class="form-control readonly-input"
                                    value="<?php echo htmlspecialchars($row_reg['nama_barang']); ?>" readonly
                                    style="background-color: #f0f0f0;">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="no_regristrasi" class="col-sm-3 col-form-label">No. Reg</label>
                            <div class="col-sm-8">
                                <input type="text" id="no_regristrasi" name="no_regristrasi"
                                    class="form-control readonly-input"
                                    value="<?php echo htmlspecialchars($row_reg['no_regristrasi']); ?>" readonly
                                    style="background-color: #f0f0f0;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-2">
                            <label for="desk_pemeliharaan" class="col-sm-3 col-form-label">Desk. Kerusakan</label>
                            <div class="col-sm-8">
                                <input type="text" id="desk_pemeliharaan" name="desk_pemeliharaan"
                                    class="form-control readonly-input"
                                    value="<?php echo isset($row['desk_pemeliharaan']) ? htmlspecialchars($row['desk_pemeliharaan']) : ''; ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="perbaikan" class="col-sm-3 col-form-label">Desk. Perbaikan</label>
                            <div class="col-sm-8">
                                <input type="text" id="perbaikan" name="perbaikan" class="form-control readonly-input"
                                    value="<?php echo isset($row['perbaikan']) ? htmlspecialchars($row['perbaikan']) : ''; ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="tgl_perbaikan" class="col-sm-3 col-form-label">Tgl Perbaikan</label>
                            <div class="col-sm-8">
                                <input type="date" id="tgl_perbaikan" name="tgl_perbaikan" class="form-control"
                                    value="<?php echo htmlspecialchars($row['tgl_perbaikan']); ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="lama_perbaikan" class="col-sm-3 col-form-label">Lama Perbaikan</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="number" id="lama_perbaikan" name="lama_perbaikan" class="form-control "
                                        value="<?php echo isset($row['lama_perbaikan']) ? htmlspecialchars($row['lama_perbaikan']) : ''; ?>">
                                    <span class="input-group-text">Hari</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="biaya_perbaikan" class="col-sm-3 col-form-label">Biaya Perbaikan</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" id="biaya_perbaikan" name="biaya_perbaikan"
                                        class="form-control"
                                        value="<?php echo htmlspecialchars($row['biaya_perbaikan']); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
    <label for="bukti_transaksi" class="col-sm-3 col-form-label">Bukti Transaksi</label>
    <div class="col-sm-8">
        <!-- Input untuk unggah file -->
        <input type="file" id="bukti_transaksi" name="bukti_transaksi" class="form-control"
            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
        
        <!-- Jika ada file yang sudah diunggah sebelumnya -->
        <?php if (!empty($row['bukti_transaksi'])): ?>
            <p class="mt-2">File saat ini: 
                <a href="uploads/pemeliharaan/<?php echo htmlspecialchars($row['bukti_transaksi']); ?>" target="_blank">
                    <?php echo htmlspecialchars($row['bukti_transaksi']); ?>
                </a>
            </p>

            <!-- Card untuk menampilkan pratinjau -->
            <div class="card mt-3">
                <div class="card-body">
                    <p>Pratinjau file yang diunggah:</p>
                    <?php
                    // Ambil ekstensi file
                    $file_extension = pathinfo($row['bukti_transaksi'], PATHINFO_EXTENSION);

                    // Pratinjau PDF
                    if (in_array(strtolower($file_extension), ['pdf'])) {
                        echo '<iframe src="uploads/pemeliharaan/' . htmlspecialchars($row['bukti_transaksi']) . '" width="100%" height="250px"></iframe>';
                    }
                    // Pratinjau Gambar
                    elseif (in_array(strtolower($file_extension), ['jpg', 'jpeg', 'png'])) {
                        echo '<img src="uploads/pemeliharaan/' . htmlspecialchars($row['bukti_transaksi']) . '" alt="Preview Image" class="img-fluid" />';
                    }
                    // Jika format file tidak dikenali
                    else {
                        echo '<p class="text-danger">Pratinjau tidak tersedia untuk tipe file ini.</p>';
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>


                <div class="row mb-4">
                    <div class="col-sm-8 offset-sm-3 text-end" style="padding-top:15px;">
                        <button type="submit" class="btn btn-primary">Perbaharui</button>
                        <a href="Data_pemeliharaan.php" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main><!-- End Main Content -->

<?php include("component/footer.php"); ?>

<!-- JavaScript untuk Konfirmasi SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('editPemeliharaanForm').addEventListener('submit', function (event) {
        event.preventDefault();

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Simpan perubahan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('editPemeliharaanForm').submit();
            }
        });
    });

    // Menangani Pesan Error dari Session
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
</script>