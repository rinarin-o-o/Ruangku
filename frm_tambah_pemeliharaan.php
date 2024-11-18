<?php
include('component/header.php');
include('koneksi/koneksi.php');

// Periksa apakah parameter 'id_barang_pemda' tersedia di URL
if (isset($_GET['id_barang_pemda'])) {
    $id_barang_pemda = $_GET['id_barang_pemda'];

    // Ambil data barang berdasarkan id_barang_pemda yang diterima
    $query_barang = "SELECT id_barang_pemda, kode_barang, nama_barang, no_regristrasi FROM data_barang WHERE id_barang_pemda = ?";
    $stmt = $conn->prepare($query_barang);
    $stmt->bind_param("s", $id_barang_pemda);
    $stmt->execute();
    $result_barang = $stmt->get_result();
    $row = $result_barang->fetch_assoc();
} else {
    // Jika parameter tidak tersedia, arahkan pengguna kembali ke halaman lain atau tampilkan pesan error
    echo "ID Barang Pemda tidak ditemukan!";
    exit;
}

// Buat ID Pemeliharaan baru secara otomatis
$query_max_id = "SELECT MAX(id_pemeliharaan) AS max_id FROM data_pemeliharaan";
$result_max_id = mysqli_query($conn, $query_max_id);
$row_max_id = mysqli_fetch_assoc($result_max_id);
if ($row_max_id['max_id']) {
    $last_id = $row_max_id['max_id'];
    $number = (int)substr($last_id, 3) + 1;
} else {
    $number = 1;
}
$new_id_pemeliharaan = 'MNT' . str_pad($number, 8, '0', STR_PAD_LEFT);
?>

<main id="main" class="main">
    <div class="card">
        <div class="card-body" style="padding-top: 10px;">
            <div class="card-title">
                <h1 style="font-size: 20px !important; margin: 0;">
                    Tambah Pemeliharaan
                    <span style="font-size: 20px !important; margin: 0;"> | </span>
                    <span>
                        <?php
                        echo $row['no_regristrasi'] . ' - ' . $row['nama_barang'];
                        ?>
                    </span>
                </h1>
            </div>
            <hr>
            <form method="POST" action="proses/pemeliharaan/tambah_pemeliharaan.php">
                <div class="row">
                    <div class="col-md-6">
                        <!-- ID Pemeliharaan Otomatis -->
                        <div class="row mb-2">
                            <label for="id_pemeliharaan" class="col-sm-3 col-form-label">ID Pemeliharaan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="id_pemeliharaan" name="id_pemeliharaan" value="<?php echo $new_id_pemeliharaan; ?>" readonly style="background-color: #f0f0f0;">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="id_barang_pemda" class="col-sm-3 col-form-label">ID Pemda</label>
                            <div class="col-sm-8">
                                <input type="text" id="id_barang_pemda" name="id_barang_pemda" class="form-control readonly-input" value="<?php echo htmlspecialchars($row['id_barang_pemda']); ?>" readonly style="background-color: #f0f0f0;">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="kode_barang" class="col-sm-3 col-form-label">Kode Aset</label>
                            <div class="col-sm-8">
                                <input type="text" id="kode_barang" name="kode_barang" class="form-control readonly-input" value="<?php echo htmlspecialchars($row['kode_barang']); ?>" readonly style="background-color: #f0f0f0;">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="nama_barang" class="col-sm-3 col-form-label">Nama Aset</label>
                            <div class="col-sm-8">
                                <input type="text" id="nama_barang" name="nama_barang" class="form-control readonly-input" value="<?php echo htmlspecialchars($row['nama_barang']); ?>" readonly style="background-color: #f0f0f0;">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="no_regristrasi" class="col-sm-3 col-form-label">No. Reg</label>
                            <div class="col-sm-8">
                                <input type="text" id="no_regristrasi" name="no_regristrasi" class="form-control readonly-input" value="<?php echo htmlspecialchars($row['no_regristrasi']); ?>" readonly style="background-color: #f0f0f0;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-2">
                            <label for="desk_pemeliharaan" class="col-sm-3 col-form-label">Desk. Kerusakan</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="desk_pemeliharaan"></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="perbaikan" class="col-sm-3 col-form-label">Desk. Perbaikan</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="perbaikan"></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="tgl_perbaikan" class="col-sm-3 col-form-label">Tgl Perbaikan<span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="tgl_perbaikan" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="lama_perbaikan" class="col-sm-3 col-form-label">Lama Perbaikan</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="lama_perbaikan">
                                    <span class="input-group-text">Hari</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="biaya_perbaikan" class="col-sm-3 col-form-label">Biaya Perbaikan<span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="biaya_perbaikan" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-8 offset-sm-3 text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="detail_barang.php?id_barang_pemda=<?php echo $row['id_barang_pemda']; ?>" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main><!-- End Main Content -->

<?php include("component/footer.php"); ?>