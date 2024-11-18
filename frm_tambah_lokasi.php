<?php
ob_start();
include('component/header.php');
include('koneksi/koneksi.php');
?>

<main id="main" class="main">
  <div class="card">
    <div class="card-body" style="padding-top: 15px;">
      <div class="card-title">
        <h1 style="font-size: 20px !important; margin: 0;">Tambah Ruang</h1>
      </div>
      <hr>
      <form id="addLocationForm" method="POST" action="" style="padding-top: 20px;">
        <div class="row">
          <div class="col-md-6">
            <div class="row mb-2">
              <label for="kategori_lokasi" class="col-sm-3 col-form-label">Kategori <span style="color: red;">*</span></label>
              <div class="col-sm-8">
                <select name="kategori_lokasi" class="form-select" aria-label="Default select example" id="kategori_lokasi" required>
                  <option value="" disabled selected>Pilih Kategori</option>
                  <option value="ruangan">Ruangan</option>
                </select>
              </div>
            </div>


            <div class="row mb-2">
              <label for="id_lokasi" class="col-sm-3 col-form-label">Kode Ruang <span style="color: red;">*</span></label>
              <div class="col-sm-8">
                <input type="text" name="id_lokasi" class="form-control" id="id_lokasi" required>
              </div>
            </div>

            <div class="row mb-2">
              <label for="bid_lokasi" class="col-sm-3 col-form-label">Nama Ruang <span style="color: red;">*</span></label>
              <div class="col-sm-8">
                <input type="text" name="bid_lokasi" class="form-control" id="bid_lokasi" required>
              </div>
            </div>
          </div>
          <div class="col-md-6">



            <div class="row mb-2">
              <label for="nama_lokasi" class="col-sm-3 col-form-label">Kode Lokasi</label>
              <div class="col-sm-8">
                <input type="text" name="nama_lokasi" class="form-control" nama="id_lokasi">
              </div>
            </div>

            <div class="row mb-2">
              <label for="tempat_lokasi" class="col-sm-3 col-form-label">Nama Lokasi <span style="color: red;">*</span></label>
              <div class="col-sm-8">
                <input type="text" name="tempat_lokasi" class="form-control" id="tempat_lokasi" required>
              </div>
            </div>

            <div class="row mb-4">
              <label for="desk_lokasi" class="col-sm-3 col-form-label">Keterangan</label>
              <div class="col-sm-8">
                <textarea name="desk_lokasi" class="form-control" id="desk_lokasi" rows="3"></textarea>
              </div>
            </div>

            <div class="row mb-4">
              <div class="col-sm-8 offset-sm-3 text-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="lokasi.php" class="btn btn-secondary">Batal</a>
              </div>
            </div>
          </div>

      </form><!-- End form -->
    </div>
  </div>
</main><!-- End Main Content -->

<?php include("component/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('addLocationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting immediately

    Swal.fire({
      title: 'Konfirmasi',
      text: 'Apakah Anda yakin ingin menambah lokasi ini?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, tambah!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        const formData = new FormData(document.getElementById('addLocationForm'));

        fetch('proses/lokasi/tambah_lokasi.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.text())
          .then(data => {
            if (data.includes('Error')) {
              Swal.fire({
                title: 'Error!',
                text: data,
                icon: 'error',
                confirmButtonText: 'OK'
              });
            } else {
              window.location.href = 'lokasi.php';
            }
          });
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