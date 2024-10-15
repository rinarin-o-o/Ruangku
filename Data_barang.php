<!--SEARCH HANYA BISA MENGAMBIL NAMA_BARANG, SEHARUSNYA SELAIN NAMA_BARANG, ID_BARANG_PEMDA, DAN JUGA KODE_BARANG HARUS DISERRTAKAN, SELAIN ITU SEARCH PADA DAFTAR BARANG RUSAK JUGA TIDAK BISA, MALAH KE REDIRECT KE DAFTAR SEMUA BARANG
TAMBAH DATA BELUM BISA NGE REDIRECT KE PROSES TAMBAH BARANG-->

<?php
session_start();
include('koneksi/koneksi.php'); // Include DB connection

// Pagination settings
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit; // Starting record

// Handle search query
$search_query = "";
$params = []; // Store parameters dynamically
$types = "";  // Store types for bind_param

if (isset($_POST['query']) && !empty($_POST['query'])) {
    $search = mysqli_real_escape_string($conn, $_POST['query']);
    $search_query = "WHERE nama_barang LIKE ?";
    $params[] = "%$search%";
    $types .= "s"; // 's' for string type
}

// Handle filter query
$filter_query = "";
if (isset($_GET['filter']) && $_GET['filter'] === 'Rusak') {
    $filter_query = "WHERE kondisi_barang = 'Rusak'";
}

// Combine search and filter queries
if (!empty($search_query) && !empty($filter_query)) {
    $filter_query .= " AND " . substr($search_query, 6); // Remove 'WHERE' from search_query
} elseif (!empty($search_query)) {
    $filter_query = $search_query;
}

// Build the final SQL query
$sql = "SELECT id_barang_pemda, no_regristrasi, tgl_pembelian, kode_barang, harga_awal, nama_barang, kondisi_barang, keterangan 
        FROM data_barang 
        $filter_query 
        LIMIT ?, ?";

// Prepare statement
$stmt = mysqli_prepare($conn, $sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
}

// Add pagination parameters
$params[] = $start;
$params[] = $limit;
$types .= "ii"; // 'i' for integer type

// Bind all parameters dynamically
mysqli_stmt_bind_param($stmt, $types, ...$params);

// Execute the query
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Get the total number of records
$count_sql = "SELECT COUNT(*) AS total FROM data_barang $filter_query";
$count_stmt = mysqli_prepare($conn, $count_sql);
if (!empty($search_query)) {
    mysqli_stmt_bind_param($count_stmt, "s", $params[0]); // Bind search parameter if present
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
  </div>

  <div class="card">
    <div class="card-body" style="padding-top: 20px;">

      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Daftar Semua Barang</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Daftar Barang Rusak</button>
        </li>
      </ul>
      <div class="tab-content pt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="d-flex justify-content-between align-items-center mb-2" style="padding-top: 10px; padding-bottom: 10px">
            <a href="proses/barang/export_barang_xls.php" class="btn btn-outline-success btn-sm" title="Export PDF">
              <i class="bi bi-file-earmark-excel"></i> Export
            </a>
            <div class="search-bar">
              <form class="search-form d-flex align-items-center" method="POST" action="">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword" class="form-control me-2" value="<?= isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?>">
                <button type="submit" title="Search" class="btn btn-outline-primary">
                  <i class="bi bi-search"></i>
                </button>
              </form>
            </div><!-- End Search Bar -->
            <a href="frm_tambah_barang.php" class="btn btn-primary btn-sm" title="Tambah">+ Tambah</a>
          </div>


          <!-- Data Table -->
          <table class="table table-bordered" style="font-size: 14px;">
            <thead class="table-secondary text-center">
              <tr>
                <th scope="col">No. Reg</th>
                <th scope="col">Barcode</th>
                <th scope="col">Tanggal Perolehan</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Uraian Aset</th> <!-- Uraian Aset is the Nama Barang -->
                <th scope="col">Detail</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $folder = "proses/inventaris/qrcodes/barang/";
                  // Buat kode unik QR untuk setiap barang
                  $kode = "simabar " .
                    "Nomor Registrasi : " . $row['no_regristrasi'] . "\n" .
                    "Nama Barang : " . $row['nama_barang'] . "\n" .
                    "Kondisi Barang : " . $row['kondisi_barang'] . "\n" .
                    "Keterangan Barang : " . $row['keterangan'] . "\n";
                  $filename = $folder . "/qrcode_" . $row['id_barang_pemda'] . ".png"; // Tambahkan garis miring (/) sebelum 'kode'

                  // Hasilkan QR Code dalam ukuran besar untuk unduhan
                  require_once('proses/qrcode/qrlib.php');
                  QRcode::png($kode, $filename, "M", 10, 2); // Menghasilkan QR Code dengan ukuran 1000 x 1000 pixel

                  // Tampilkan hasil QR dengan ukuran kecil (misalnya 100 x 100 pixel)
                  echo "<tr class='text-center'>
                      <td>{$row['no_regristrasi']}</td>
                      <td>
                        <img src='$filename' alt='QR Code' style='width: 70px; height: 70px;'> <!-- Tampilkan ukuran kecil -->
                        <br>
                        <a href='$filename' 
                           download='{$row['nama_barang']}_QR_Code_{$row['no_regristrasi']}.png' 
                           class='breadcrumb-item'>
                          <i class='bi bi-download'></i>
                        </a>
                      </td>
                      <td>" . date('d/m/Y', strtotime($row['tgl_pembelian'])) . "</td>
                      <td>{$row['kode_barang']}</td>
                      <td>Rp " . number_format($row['harga_awal'], 2, ',', '.') . "</td>
                      <td>{$row['nama_barang']}</td>
                      <td><a href='detail_barang.php?id_barang_pemda={$row['id_barang_pemda']}' class='text-primary'>Detail</a></td>
                    </tr>";
                }
              } else {
                echo "<tr><td colspan='7' class='text-center'>No data found.</td></tr>";
              }
              ?>
            </tbody>
          </table><!-- End Data Table -->

          <?php if ($total_records > $limit) : ?>
            <nav aria-label="Page navigation example" class="d-flex justify-content-center">
              <ul class="pagination">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                  <a class="page-link" href="?page=<?= ($page > 1) ? ($page - 1) : 1 ?><?= isset($_GET['filter']) ? '&filter=' . $_GET['filter'] : '' ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                  <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?><?= isset($_GET['filter']) ? '&filter=' . $_GET['filter'] : '' ?>"><?= $i ?></a>
                  </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                  <a class="page-link" href="?page=<?= ($page < $total_pages) ? ($page + 1) : $total_pages ?><?= isset($_GET['filter']) ? '&filter=' . $_GET['filter'] : '' ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              </ul>
            </nav>
          <?php endif; ?>
        </div>
      </div><!-- End Tab 1 -->

      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <!-- Search Bar Section -->
        <div class="d-flex justify-content-center align-items-center mb-4" style="padding-top: 10px;">
          <div class="search-bar" style="width: 30%; max-width: 250px;">
            <form class="search-form d-flex align-items-center" method="POST" action="">
              <input type="text" name="query" placeholder="Search" title="Enter search keyword" class="form-control" value="<?= isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?>">
              <button type="submit" title="Search" class="btn btn-outline-primary ms-2">
                <i class="bi bi-search"></i>
              </button>
            </form>
          </div>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
          <table class="table table-bordered" style="font-size: 14px;">
            <thead class="table-secondary text-center">
              <tr>
                <th scope="col">No. Reg</th>
                <th scope="col">Barcode</th>
                <th scope="col">Tanggal Perolehan</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Uraian Aset</th>
                <th scope="col">Detail</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Query untuk mendapatkan data barang rusak
              $sql_rusak = "SELECT id_barang_pemda, no_regristrasi, tgl_pembelian, kode_barang, harga_awal, nama_barang, kondisi_barang, keterangan 
                      FROM data_barang 
                      WHERE kondisi_barang = 'Rusak' 
                      LIMIT ?, ?";
              $stmt_rusak = mysqli_prepare($conn, $sql_rusak);
              mysqli_stmt_bind_param($stmt_rusak, "ii", $start, $limit);
              mysqli_stmt_execute($stmt_rusak);
              $result_rusak = mysqli_stmt_get_result($stmt_rusak);

              if (mysqli_num_rows($result_rusak) > 0) {
                while ($row_rusak = mysqli_fetch_assoc($result_rusak)) {
                  $folder = "proses/inventaris/qrcodes/barang/";
                  $kode = "simabar " .
                    "Nomor Registrasi : " . $row_rusak['no_regristrasi'] . "\n" .
                    "Nama Barang : " . $row_rusak['nama_barang'] . "\n" .
                    "Kondisi Barang : " . $row_rusak['kondisi_barang'] . "\n" .
                    "Keterangan Barang : " . $row_rusak['keterangan'] . "\n";
                  $filename = $folder . "/rusak_qrcode_" . $row_rusak['id_barang_pemda'] . ".png";

                  require_once('proses/qrcode/qrlib.php');
                  QRcode::png($kode, $filename, "M", 10, 2);

                  echo "<tr class='text-center'>
                    <td>{$row_rusak['no_regristrasi']}</td>
                    <td>
                      <img src='$filename' alt='QR Code' style='width: 70px; height: 70px;'>
                      <br>
                      <a href='$filename' 
                         download='{$row_rusak['nama_barang']}_QR_Code_{$row_rusak['no_regristrasi']}.png' 
                         class='breadcrumb-item'>
                        <i class='bi bi-download'></i>
                      </a>
                    </td>
                    <td>" . date('d/m/Y', strtotime($row_rusak['tgl_pembelian'])) . "</td>
                    <td>{$row_rusak['kode_barang']}</td>
                    <td>Rp " . number_format($row_rusak['harga_awal'], 2, ',', '.') . "</td>
                    <td>{$row_rusak['nama_barang']}</td>
                    <td><a href='detail_barang.php?id_barang_pemda={$row_rusak['id_barang_pemda']}' class='text-primary'>Detail</a></td>
                  </tr>";
                }
              } else {
                echo "<tr><td colspan='7' class='text-center'>No data found.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div><!-- End Tab 2 -->

    </div><!-- End Tab Content -->
  </div><!-- End Card Body -->
  </div><!-- End Card -->
</main>

<?php include("component/footer.php"); ?>