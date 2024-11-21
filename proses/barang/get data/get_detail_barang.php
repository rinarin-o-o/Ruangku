<?php
include('koneksi/koneksi.php');

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
<script>
  function toggleMutasi() {
    var MutasiSection = document.getElementById("MutasiSection");
    var toggleButton = document.getElementById("togglemMutasiButton");

    MutasiSection.classList.toggle("d-none"); // Toggle visibility

    if (MutasiSection.classList.contains("d-none")) {
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
<!-- Toggle Photo Section Script -->
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
          // If user confirms, redirect to the deletion URL with id_barang_pemda
          window.location.href = 'proses/barang/hapus_barang.php?id_barang_pemda=' + id_barang_pemda;
        }
      });
    });
  });
</script>