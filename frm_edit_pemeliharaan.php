<?php
include('component/header.php');
include('koneksi/koneksi.php');

// Cek jika ada id_barang di URL
if (isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];
    
    // Ambil data barang berdasarkan id_barang
    $query_barang = "SELECT * FROM data_barang WHERE id_barang_pemda = '$id_barang'";
    $result_barang = mysqli_query($conn, $query_barang);
    $barang = mysqli_fetch_assoc($result_barang);
} else {
    // Jika tidak ada id_barang, arahkan ke halaman lain atau tampilkan pesan error
    header('Location: Data_barang.php');
    exit;
}

// Tampilkan pesan error atau success jika ada
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
} elseif (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>Data berhasil disimpan!</div>";
    unset($_SESSION['success']);
}

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

                <!-- Barang yang Dipilih -->
                <div class="row mb-2">
                    <label for="barang" class="col-sm-3 col-form-label">Barang</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="barang" name="barang" value="<?php echo $barang['nama_barang']; ?>" readonly>
                    </div>
                </div>

                <!-- Hidden input untuk mengirimkan data barang -->
                <input type="hidden" name="id_barang_pemda" value="<?php echo $barang['id_barang_pemda']; ?>">
                <input type="hidden" name="kode_barang" value="<?php echo $barang['kode_barang']; ?>">
                <input type="hidden" name="no_regristrasi" value="<?php echo $barang['no_regristrasi']; ?>">

                <!-- Form Pemeliharaan -->
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
