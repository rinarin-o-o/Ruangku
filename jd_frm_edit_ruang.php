<?php
ob_start();
include("component/header.php");
include('koneksi/koneksi.php'); // Include DB connection

// Check if the 'id_jadwal_ruang' is passed in the URL
if (!isset($_GET['id_jadwal_ruang'])) {
    // Redirect to the location list page if id_jadwal_ruang is not set
    header('Location: jadwal_ruang.php');
    exit;
}

$id_jadwal_ruang = $_GET['id_jadwal_ruang'];

// Fetch existing location data
$sql = "SELECT * FROM jadwal_ruang WHERE id_jadwal_ruang = '$id_jadwal_ruang'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
} else {
    // Redirect to the location list page if no data found
    header('Location: jadwal_ruang.php');
    exit;
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Penggunaan ruang</h1>
    </div>

    <div class="card">
        <div class="card-body" style="padding-top: 50px; padding-left: 100px; padding-right: 50px;">
            <form id="editJdruangForm" action="proses/jadwal/jd_edit_ruang.php" method="POST">

                <input type="hidden" name="id_jadwal_ruang" value="<?php echo $row['id_jadwal_ruang']; ?>">

                <div class="row mb-2">
                    <label for="nama_lokasi" class="col-sm-3 col-form-label">Ruang</label>
                    <div class="col-sm-8">
                        <input type="text" name="nama_lokasi" class="form-control" value="<?php echo htmlspecialchars($row['nama_lokasi']); ?>" readonly style="background-color: #f0f0f0;">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="waktu_penggunaan" class="col-sm-3 col-form-label">Jadwal Pakai</label>
                    <div class="col-sm-4">
                        <input type="date" name="tgl_mulai" class="form-control" value="<?php echo isset($row['tgl_mulai']) ? htmlspecialchars($row['tgl_mulai']) : ''; ?>">
                    </div>
                    <div class="col-sm-4">
                        <input type="time" name="waktu_mulai" class="form-control" value="<?php echo isset($row['waktu_mulai']) ? htmlspecialchars($row['waktu_mulai']) : ''; ?>">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="waktu_selesai" class="col-sm-3 col-form-label">Jadwal Selesai</label>
                    <div class="col-sm-4">
                        <input type="date" name="tgl_selesai" class="form-control" value="<?php echo isset($row['tgl_selesai']) ? htmlspecialchars($row['tgl_selesai']) : ''; ?>">
                    </div>
                    <div class="col-sm-4">
                        <input type="time" name="waktu_selesai" class="form-control" value="<?php echo isset($row['waktu_selesai']) ? htmlspecialchars($row['waktu_selesai']) : ''; ?>">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="acara" class="col-sm-3 col-form-label">Kegiatan</label>
                    <div class="col-sm-8">
                        <input type="text" name="acara" class="form-control" value="<?php echo isset($row['acara']) ? htmlspecialchars($row['acara']) : ''; ?>">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="pengguna" class="col-sm-3 col-form-label">Pengguna</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="pengguna" class="form-control" value="<?php echo isset($row['pengguna']) ? htmlspecialchars($row['pengguna']) : ''; ?>">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="penanggungjawab" class="col-sm-3 col-form-label">Penanggungjawab</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="penanggungjawab" class="form-control" value="<?php echo isset($row['penanggungjawab']) ? htmlspecialchars($row['penanggungjawab']) : ''; ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-8 offset-sm-3 text-end">
                        <button type="submit" class="btn btn-primary" id="submitButton">Perbaharui</button>
                        <a href="jadwal_ruang.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>




            </form><!-- End Edit Location Form -->
        </div>
    </div>

</main><!-- End Main Content -->

<?php include("component/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('editJdruangForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting immediately

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
                // If confirmed, submit the form
                document.getElementById('editJdruangForm').submit();
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