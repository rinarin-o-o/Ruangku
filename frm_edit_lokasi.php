<?php
include('component/header.php');
include("proses/lokasi/get data/get_data_edit_lokasi.php");
?>

<main id="main" class="main">
    <div class="card">
        <div class="card-body" style="padding-top: 10px; padding-left: 30px;">
            <div class="card-title">
                <h1 style="font-size: 20px !important; margin: 0;">Edit <span style="font-size: 20px !important; margin: 0;"> | </span><span> <?php echo $row['bid_lokasi']; ?> </span></h1>
            </div>
            <hr>

            <form id="editLocationForm" action="proses/lokasi/edit_lokasi.php" method="POST">
                <div class="row" style="padding-top: 10px;">
                    <div class="col-md-6">
                        <!-- kategori -->
                        <div class="row mb-2">
                            <label for="kategori_lokasi" class="col-sm-3 col-form-label">Kategori <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <select name="kategori_lokasi" class="form-select" aria-label="Default select example" required>
                                    <option value="Ruangan" <?php echo ($row['kategori_lokasi'] == 'Ruangan') ? 'selected' : ''; ?>>Ruangan</option>
                                </select>
                            </div>
                        </div>
                        <!-- kode ruag -->
                        <div class="row mb-2">
                            <label for="id_lokasi" class="col-sm-3 col-form-label">Kode Ruang <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="id_lokasi" class="form-control" value="<?php echo htmlspecialchars($row['id_lokasi']); ?>" readonly>
                            </div>
                        </div>
                        <!-- ama ruang -->
                        <div class="row mb-2">
                            <label for="bid_lokasi" class="col-sm-3 col-form-label">Nama Ruang <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="bid_lokasi" class="form-control" value="<?php echo isset($row['bid_lokasi']) ? htmlspecialchars($row['bid_lokasi']) : ''; ?>">
                            </div>
                        </div>
                    </div> <!-- End kolom -->
                    <div class="col-md-6">
                        <!-- kode lokasi -->
                        <div class="row mb-2">
                            <label for="nama_lokasi" class="col-sm-3 col-form-label">Kode Lokasi</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama_lokasi" class="form-control" value="<?php echo htmlspecialchars($row['nama_lokasi']); ?>">
                            </div>
                        </div>
                        <!-- nama lokasi -->
                        <div class="row mb-2">
                            <label for="tempat_lokasi" class="col-sm-3 col-form-label">Lokasi <span style="color: red;">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="tempat_lokasi" class="form-control" value="<?php echo htmlspecialchars($row['tempat_lokasi']); ?>" required>
                            </div>
                        </div>
                        <!-- keterangan -->
                        <div class="row mb-4">
                            <label for="desk_lokasi" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <textarea name="desk_lokasi" class="form-control"><?php echo isset($row['desk_lokasi']) ? htmlspecialchars($row['desk_lokasi']) : ''; ?></textarea>
                            </div>
                        </div>
                        <!-- tombol -->
                        <div class="row mb-4">
                            <div class="col-sm-8 offset-sm-3 text-end">
                                <button type="submit" class="btn btn-primary" id="submitButton">Perbaharui</button>
                                <a href="lokasi.php" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- End form -->
</main>

<?php include("component/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('editLocationForm').addEventListener('submit', function(event) {
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
                document.getElementById('editLocationForm').submit();
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