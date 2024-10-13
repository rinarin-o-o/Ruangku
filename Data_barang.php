<?php
session_start();
include('koneksi/koneksi.php'); // Include DB connection

// Jika session 'success' ada, tampilkan pesan SweetAlert
//if (isset($_SESSION['success']) && $_SESSION['success']) {
// echo "<script>
//            document.addEventListener('DOMContentLoaded', function() {
//               Swal.fire({
//                   title: 'Berhasil!',
//                  text: 'Data berhasil diperbarui! 🎉',
//                    icon: 'success',
//                    confirmButtonText: 'Oke'
//                });
//            });
//          </script>";
// Hapus session 'success' agar tidak tampil lagi setelah refresh
//  unset($_SESSION['success']);
//}

// Pagination settings
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit; // Starting record

// Handle search query
$search_query = "";
$search_param = "";
if (isset($_POST['query']) && !empty($_POST['query'])) {
  $search = mysqli_real_escape_string($conn, $_POST['query']);
  $search_query = "WHERE nama_barang LIKE ?";
  $search_param = "%$search%";
}

// Handle filter query
$filter_query = "";
if (isset($_GET['filter']) && $_GET['filter'] === 'Rusak') {
  $filter_query = "WHERE kondisi_barang = 'Rusak'";
}

// Jika ada query pencarian, gabungkan dengan filter
if (isset($_POST['query']) && !empty($_POST['query'])) {
  $search = mysqli_real_escape_string($conn, $_POST['query']);
  $search_param = "%$search%";

  // Jika filter barang rusak aktif, tambahkan kondisi pencarian ke filter barang rusak
  if (!empty($filter_query)) {
    $filter_query .= " AND nama_barang LIKE ?";
  } else {
    $filter_query = "WHERE nama_barang LIKE ?";
  }
}

// Query untuk mendapatkan data barang
$sql = "SELECT id_barang_pemda, no_regristrasi, tgl_pembelian, kode_barang, harga_total, nama_barang, kondisi_barang, keterangan 
        FROM data_barang 
        $filter_query 
        LIMIT ?, ?";

$stmt = mysqli_prepare($conn, $sql);

// Jika ada pencarian, bind parameter untuk query pencarian
if (isset($_POST['query']) && !empty($_POST['query'])) {
  mysqli_stmt_bind_param($stmt, "sii", $search_param, $start, $limit);
} else {
  mysqli_stmt_bind_param($stmt, "ii", $start, $limit);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


// Get the total number of records
$count_sql = "SELECT COUNT(*) AS total FROM data_barang $search_query";
$count_stmt = mysqli_prepare($conn, $count_sql);
if ($search_param) {
  mysqli_stmt_bind_param($count_stmt, "s", $search_param);
}
mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);
?>

<?php include("component/header.php"); ?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Daftar Barang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
        <li class="breadcrumb-item">Data</li>
        <li class="breadcrumb-item active">Data Barang</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <!-- Search Bar and Add Button -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="data_barang.php?filter=Rusak" class="btn btn-warning">
      <i class="bi bi-filter"></i> Filter Barang Rusak
    </a>
    <form class="search-form d-flex align-items-center" method="POST" action="">
      <input type="text" name="query" placeholder="Search" title="Enter search keyword" class="form-control me-2" value="<?= isset($_POST['query']) ? htmlspecialchars($_POST['query']) : '' ?>">
      <button type="submit" title="Search" class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
    </form>
    <a href="frm_tambah_barang.php" class="btn btn-primary">
      <i class="bi bi-plus"></i> Tambah Data
    </a>
  </div><!-- End Search Bar and Add Button -->

  <!-- Data Table -->
  <table class="table table-bordered">
    <thead class="table-secondary text-center">
      <tr>
        <th scope="col">No. Reg</th>
        <th scope="col">Barcode</th>
        <th scope="col">Tanggal Perolehan</th>
        <th scope="col">Kode Barang</th>
        <th scope="col">Harga</th>
        <th scope="col">Uraian Aset</th> <!-- Uraian Aset is the Nama Barang -->
        <th scope="col">Detail</th>
      </tr>
    </thead>
    <tbody>
      <?php


      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $folder = "images/qrcodes";
          // Buat kode unik QR untuk setiap barang
          $kode = "simabar " .
            "Nomor Registrasi : " . $row['no_regristrasi'] . "\n" .
            "Nama Barang : " . $row['nama_barang'] . "\n" .
            "Kondisi Barang : " . $row['kondisi_barang'] . "\n" .
            "Keterangan Barang : " . $row['keterangan'] . "\n";
          $filename = $folder . "/kode" . $row['no_regristrasi'] . ".png"; // Tambahkan garis miring (/) sebelum 'kode'

          // Hasilkan QR Code dalam ukuran besar untuk unduhan
          require_once('proses/qrcode/qrlib.php');
          QRcode::png($kode, $filename, "M", 10, 2); // Menghasilkan QR Code dengan ukuran 1000 x 1000 pixel

          // Tampilkan hasil QR dengan ukuran kecil (misalnya 100 x 100 pixel)

          echo "<tr class='text-center'>
                  <td>{$row['no_regristrasi']}</td>
                  <td>
                    <img src='$filename' alt='QR Code' style='width: 100px; height: 100px;'> <!-- Tampilkan ukuran kecil -->
                    <br>
                    <a href='$filename' download='{$row['nama_barang']}_QR_Code_{$row['no_regristrasi']}.png' class='btn btn-success btn-sm mt-2'>Download QR Code</a>
                </td>
                  <td>" . date('d/m/Y', strtotime($row['tgl_pembelian'])) . "</td>
                  <td>{$row['kode_barang']}</td>
                  <td>Rp " . number_format($row['harga_total'], 2, ',', '.') . "</td>
                  <td>{$row['nama_barang']}</td>
                  <td><a href='detail_barang.php?id_barang_pemda={$row['id_barang_pemda']}' class='text-primary'>Detail</a></td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='6'>No data found.</td></tr>";
      }
      ?>
    </tbody>
  </table><!-- End Data Table -->

  <div class="text-start mb-3">
    <a href="proses/barang/export_barang_pdf.php" class="btn btn-success">Export to XLS</a>
  </div>

  <?php if ($total_records > $limit) : ?>
    <nav aria-label="Page navigation example" class="d-flex justify-content-center">
      <ul class="pagination">
        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= ($page > 1) ? ($page - 1) : 1 ?><?= isset($_GET['query']) ? '&query=' . urlencode($_GET['query']) : '' ?>" tabindex="-1" aria-disabled="true">Sebelumnya</a>
        </li>

        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
          <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i; ?><?= isset($_GET['query']) ? '&query=' . urlencode($_GET['query']) : '' ?>"><?= $i; ?></a>
          </li>
        <?php endfor; ?>

        <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= ($page < $total_pages) ? ($page + 1) : $total_pages ?><?= isset($_GET['query']) ? '&query=' . urlencode($_GET['query']) : '' ?>">Selanjutnya</a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>

</main>

<?php include("component/footer.php"); ?>