<?php
include("component/header.php");
include('koneksi/koneksi.php'); // Include DB connection

// Pagination settings
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit; // Starting record

// Handle search query
$search_query = "";
$search_params = []; // Store bind parameters
$param_types = ""; // Store bind types

// Check if search query is set
if (!empty($_GET['query'])) {
  $search = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';
  $search_query = "WHERE id_barang_pemda LIKE ? OR kode_barang LIKE ? OR nama_barang LIKE ?";
  array_push($search_params, $search, $search, $search);
  $param_types .= "sss";
}

// Fetch data from the data_barang table with limit and offset
$sql = "SELECT id_barang_pemda, kondisi_barang, keterangan, harga_awal, no_regristrasi, 
               tgl_pembelian, kode_barang, harga_total, nama_barang 
        FROM data_barang 
        $search_query 
        LIMIT ?, ?";

// Prepare the SQL statement
$stmt = mysqli_prepare($conn, $sql);

// Append pagination types and values
$param_types .= "ii";
array_push($search_params, $start, $limit);

// Bind the parameters dynamically
mysqli_stmt_bind_param($stmt, $param_types, ...$search_params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Get the total number of records
$count_sql = "SELECT COUNT(*) AS total FROM data_barang $search_query";
$count_stmt = mysqli_prepare($conn, $count_sql);

// Bind parameters for the count query if search is applied
if (!empty($search_query)) {
  mysqli_stmt_bind_param($count_stmt, substr($param_types, 0, -2), ...array_slice($search_params, 0, -2)); // Only bind search params
}

mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);
?>

<main id="main" class="main">
  <!-- Page content -->
  <div class="pagetitle">
    <h1>Daftar Barang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="data_barang.php">Dashboard</a></li>
        <li class="breadcrumb-item">Data</li>
        <li class="breadcrumb-item active">Data Barang</li>
      </ol>
    </nav>
  </div>

  <div class="card">
    <div class="card-body" style="padding-top: 20px;">
      <div class="d-flex justify-content-between align-items-center mb-2" style="padding-top: 10px; padding-bottom: 10px">
        <div class="flex-grow-1 d-flex justify-content-center">
          <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="GET" action="">
              <input type="text" name="query" placeholder="Cari Aset" title="Cari Aset" class="form-control me-2" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
              <button type="submit" title="Cari" class="btn btn-outline-primary">
                <i class="bi bi-search"></i>
              </button>
            </form>
          </div>
        </div>
        <div>
          <a href="frm_tambah_barang.php" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Tambah Data Aset">+</a>
        </div>
      </div>

      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="data_barang-tab" data-bs-toggle="tab" data-bs-target="#data_barang" type="button" role="tab" aria-controls="data_barang" aria-selected="true">Semua Barang</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="barang_kurang_baik-tab" data-bs-toggle="tab" data-bs-target="#barang-kurang" type="button" role="tab" aria-controls="barang-kurang" aria-selected="false">
            Kurang Baik</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="barang_rusak-tab" data-bs-toggle="tab" data-bs-target="#barang-rusak" type="button" role="tab" aria-controls="barang-rusak" aria-selected="false">
            Rusak</button>
        </li>
      </ul>
      <div class="tab-content pt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="data_barang" role="tabpanel" aria-labelledby="data_barang-tab">
          <div class="d-flex justify-content-between align-items-center mb-2" style="padding-top: 10px; padding-bottom: 10px">
            <!-- Dropdown for entries per page -->
            <div>
              <form method="GET" action="">
                <label for="entries" class="me-2">Data Entri</label>
                <select name="limit" id="entries" onchange="this.form.submit()" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                  <option value="10" <?= ($limit == 10) ? 'selected' : ''; ?>>10</option>
                  <option value="25" <?= ($limit == 25) ? 'selected' : ''; ?>>25</option>
                  <option value="50" <?= ($limit == 50) ? 'selected' : ''; ?>>50</option>
                  <option value="100" <?= ($limit == 100) ? 'selected' : ''; ?>>100</option>
                </select>
                <input type="hidden" name="query" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
              </form>
            </div>

            <!-- Existing Export Button -->
            <div>
              <a href="proses/barang/export_barang_xls.php" class="btn btn-outline-success btn-sm" title="Export Data Aset">
                <i class="bi bi-file-earmark-excel"></i> Export
              </a>
            </div>
          </div>


          <?php
          $end = min($start + $limit, $total_records); // Calculates the last record number displayed
          $showing_text = "Showing " . ($start + 1) . " to " . $end . " of " . $total_records . " entries";
          echo "<p class='text-muted'>$showing_text</p>";
          ?>

          <div class="table-responsive">
            <!-- Data Table -->
            <table class="table table-bordered" style="font-size: 14px;">
              <thead class="table-secondary text-center">
                <tr>
                  <th scope="col">No. Reg</th>
                  <th scope="col">Tanggal Perolehan</th>
                  <th scope="col">Kode Barang</th>
                  <th scope="col">Uraian Aset</th>
                  <th scope="col">Harga Beli</th>
                  <th scope="col">Kondisi</th>
                  <th scope="col">Detail</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='text-center'>
                      <td>{$row['no_regristrasi']}</td>
                      <td>" . date('d/m/Y', strtotime($row['tgl_pembelian'])) . "</td>
                      <td>{$row['kode_barang']}</td>
                      <td>{$row['nama_barang']}</td>
                      <td>Rp " . number_format($row['harga_awal'], 2, ',', '.') . "</td>
                      <td>{$row['kondisi_barang']}</td>
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
                    <a class="page-link" href="?page=<?= ($page > 1) ? ($page - 1) : 1 ?>&limit=<?= $limit ?>" aria-label="Sebelumnya" title="Sebelumnya">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>

                  <?php
                  $visible_pages = 3; // Number of pages to display in range
                  $start_page = max(1, $page - floor($visible_pages / 2));
                  $end_page = min($total_pages, $page + floor($visible_pages / 2));

                  if ($page <= ceil($visible_pages / 2)) {
                    $end_page = min($total_pages, $visible_pages);
                  }
                  if ($page > $total_pages - floor($visible_pages / 2)) {
                    $start_page = max(1, $total_pages - $visible_pages + 1);
                  }

                  if ($start_page > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';

                  for ($i = $start_page; $i <= $end_page; $i++) {
                    echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">';
                    echo '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
                    echo '</li>';
                  }

                  if ($end_page < $total_pages) {
                    if ($end_page < $total_pages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                  }
                  ?>

                  <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= ($page < $total_pages) ? ($page + 1) : $total_pages ?><?= isset($_GET['filter']) ? '&filter=' . $_GET['filter'] : '' ?>" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul>
              </nav>
            <?php endif; ?>
          </div>
        </div>
      </div><!-- End Tab 1 -->

      <div class="tab-pane fade" id="barang-kurang" role="tabpanel" aria-labelledby="barang_kurang_baik-tab">
        <!-- Table Section -->
        <div class="table-responsive">
          <table class="table table-bordered" style="font-size: 14px;">
            <thead class="table-secondary text-center">
              <tr>
                <th scope="col">No. Reg</th>
                <th scope="col">Tanggal Perolehan</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Uraian Aset</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Kondisi</th>
                <th scope="col">Detail</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Query untuk mendapatkan data barang kurang
              $sql_kurang = "SELECT * 
                      FROM data_barang 
                      WHERE kondisi_barang = 'Kurang Baik' 
                      LIMIT ?, ?";
              $stmt_kurang = mysqli_prepare($conn, $sql_kurang);
              mysqli_stmt_bind_param($stmt_kurang, "ii", $start, $limit);
              mysqli_stmt_execute($stmt_kurang);
              $result_kurang = mysqli_stmt_get_result($stmt_kurang);

              if (mysqli_num_rows($result_kurang) > 0) {
                while ($row_kurang = mysqli_fetch_assoc($result_kurang)) {

                  echo "<tr class='text-center'>
                    <td>{$row_kurang['no_regristrasi']}</td>
                    <td>" . date('d/m/Y', strtotime($row_kurang['tgl_pembelian'])) . "</td>
                    <td>{$row_kurang['kode_barang']}</td>
                    <td>{$row_kurang['nama_barang']}</td>
                    <td>Rp " . number_format($row_kurang['harga_awal'], 2, ',', '.') . "</td>
                    <td>{$row_kurang['kondisi_barang']}</td>
                    <td><a href='detail_barang.php?id_barang_pemda={$row_kurang['id_barang_pemda']}' class='text-primary'>Detail</a></td>
                  </tr>";
                }
              } else {
                echo "<tr><td colspan='7' class='text-center'>Tidak ada data yang ditemukan.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div><!-- End Tab 2 -->

      <div class="tab-pane fade" id="barang-rusak" role="tabpanel" aria-labelledby="barang_rusak-tab">
        <!-- Table Section -->
        <div class="table-responsive">
          <table class="table table-bordered" style="font-size: 14px;">
            <thead class="table-secondary text-center">
              <tr>
                <th scope="col">No. Reg</th>
                <th scope="col">Tanggal Perolehan</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Uraian Aset</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Kondisi</th>
                <th scope="col">Detail</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Query untuk mendapatkan data barang rusak
              $sql_rusak = "SELECT * 
                      FROM data_barang 
                      WHERE kondisi_barang = 'Rusak Berat' 
                      LIMIT ?, ?";
              $stmt_rusak = mysqli_prepare($conn, $sql_rusak);
              mysqli_stmt_bind_param($stmt_rusak, "ii", $start, $limit);
              mysqli_stmt_execute($stmt_rusak);
              $result_rusak = mysqli_stmt_get_result($stmt_rusak);

              if (mysqli_num_rows($result_rusak) > 0) {
                while ($row_rusak = mysqli_fetch_assoc($result_rusak)) {
                  echo "<tr class='text-center'>
                    <td>{$row_rusak['no_regristrasi']}</td>
                    <td>" . date('d/m/Y', strtotime($row_rusak['tgl_pembelian'])) . "</td>
                    <td>{$row_rusak['kode_barang']}</td>
                    <td>{$row_rusak['nama_barang']}</td>
                    <td>Rp " . number_format($row_rusak['harga_awal'], 2, ',', '.') . "</td>
                    <td>{$row_rusak['kondisi_barang']}</td>
                    <td><a href='detail_barang.php?id_barang_pemda={$row_rusak['id_barang_pemda']}' class='text-primary'>Detail</a></td>
                  </tr>";
                }
              } else {
                echo "<tr><td colspan='7' class='text-center'>Tidak ada data yang ditemukan.</td></tr>";
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