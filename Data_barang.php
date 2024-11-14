<?php
include("component/header.php");
include('koneksi/koneksi.php'); // Include DB connection

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit; // Starting record

$search_query = "";
$search_params = []; // Store bind parameters
$param_types = ""; // Store bind types

if (!empty($_GET['query'])) {
  $search = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';
  $search_query = "WHERE id_barang_pemda LIKE ? OR kode_barang LIKE ? OR nama_barang LIKE ?";
  array_push($search_params, $search, $search, $search);
  $param_types .= "sss";
}

$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'data_barang'; // Default to 'data_barang'

switch ($active_tab) {
  case 'barang_kurang_baik':
    $tab_condition = "WHERE kondisi_barang = 'Kurang Baik'";
    break;
  case 'barang_rusak':
    $tab_condition = "WHERE kondisi_barang = 'Rusak Berat'";
    break;
  default:
    $tab_condition = ""; // No filter for 'data_barang'
}

$sql = "SELECT id_barang_pemda, kondisi_barang, keterangan, harga_awal, no_regristrasi, 
               tgl_pembelian, kode_barang, harga_total, nama_barang 
        FROM data_barang 
        $search_query $tab_condition
        LIMIT ?, ?";

$stmt = mysqli_prepare($conn, $sql);

$param_types .= "ii";
array_push($search_params, $start, $limit);

mysqli_stmt_bind_param($stmt, $param_types, ...$search_params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$count_sql = "SELECT COUNT(*) AS total FROM data_barang $search_query $tab_condition";
$count_stmt = mysqli_prepare($conn, $count_sql);

if (!empty($search_query)) {
  mysqli_stmt_bind_param($count_stmt, substr($param_types, 0, -2), ...array_slice($search_params, 0, -2)); // Only bind search params
}

mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);

$range = 2;
$start_page = max(1, $page - $range);
$end_page = min($total_pages, $page + $range);
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Daftar Aset dan Barang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="data_barang.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Aset dan Barang</li>
      </ol>
    </nav>
  </div>

  <div class="card">
    <div class="card-body" style="padding-top: 20px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="flex-grow-1 d-flex justify-content-center">
          <div class="search-bar position-relative">
            <form class="search-form d-flex align-items-center" method="GET" action="">
              <input type="text" id="search-input" name="query" placeholder="Cari Aset" title="Cari Aset" class="form-control pe-5" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>" oninput="toggleClearButton()">
              <input type="hidden" name="tab" value="<?= $active_tab; ?>">
              <button type="button" id="clear-button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y me-5" style="display: none; padding: 0 8px; margin-right: 8px; color: #6c757d;" onclick="clearSearch()">
                <i class="bi bi-x-circle-fill"></i>
              </button>
              <button type="submit" title="Cari" class="btn btn-outline-primary ms-2">
                <i class="bi bi-search"></i>
              </button>
            </form>
          </div>

          <script>
            function toggleClearButton() {
              const searchInput = document.getElementById('search-input');
              const clearButton = document.getElementById('clear-button');
              clearButton.style.display = searchInput.value ? 'inline' : 'none';
            }

            function clearSearch() {
              const searchInput = document.getElementById('search-input');
              searchInput.value = '';
              window.location.href = 'data_barang.php?tab=<?= $active_tab; ?>&limit=<?= $limit; ?>';
            }
            document.addEventListener('DOMContentLoaded', toggleClearButton);
          </script>
        </div>
        <div>
          <a href="frm_tambah_barang.php" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Tambah Aset / Barang">+</a>
        </div>
      </div>

      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link <?= ($active_tab == 'data_barang') ? 'active' : ''; ?>" href="?tab=data_barang&limit=<?= $limit ?>&query=<?= urlencode($_GET['query'] ?? '') ?>&page=1" role="tab">Semua Barang</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link <?= ($active_tab == 'barang_kurang_baik') ? 'active' : ''; ?>" href="?tab=barang_kurang_baik&limit=<?= $limit ?>&query=<?= urlencode($_GET['query'] ?? '') ?>&page=1" role="tab">Kurang Baik</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link <?= ($active_tab == 'barang_rusak') ? 'active' : ''; ?>" href="?tab=barang_rusak&limit=<?= $limit ?>&query=<?= urlencode($_GET['query'] ?? '') ?>&page=1" role="tab">Rusak</a>
        </li>
      </ul>

      <div class="tab-content pt-2" id="myTabContent">
        <div class="tab-pane fade <?= ($active_tab == 'data_barang') ? 'show active' : ''; ?>" id="data_barang" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
              <form method="GET" action="">
                <label for="entries" class="me-2">Data Entri</label>
                <select name="limit" id="entries" onchange="this.form.submit()" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                  <option value="10" <?= ($limit == 10) ? 'selected' : ''; ?>>10</option>
                  <option value="25" <?= ($limit == 25) ? 'selected' : ''; ?>>25</option>
                  <option value="50" <?= ($limit == 50) ? 'selected' : ''; ?>>50</option>
                  <option value="100" <?= ($limit == 100) ? 'selected' : ''; ?>>100</option>
                </select>
                <input type="hidden" name="page" value="<?= $page; ?>">
                <input type="hidden" name="query" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                <input type="hidden" name="tab" value="<?= $active_tab; ?>">
              </form>
            </div>

            <div>
              <a href="proses/barang/export_barang_xls.php" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Unduh Data Aset">
                <i class="bi bi-file-earmark-excel"></i> Export
              </a>
            </div>
          </div>

          <?php
          $end = min($start + $limit, $total_records);
          echo "<p class='text-muted'>Showing " . ($start + 1) . " to " . $end . " of " . $total_records . " entries</p>";
          ?>

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="table-secondary text-center">
                <tr>
                  <th scope="col">No. Reg</th>
                  <th scope="col">Tgl Perolehan</th>
                  <th scope="col">Kode Aset</th>
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
                  echo "<tr><td colspan='7' class='text-center'>Tidak ada data yang ditemukan</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>

          <?php if ($total_pages > 1) : ?>
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-center">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                  <a class="page-link" href="?page=<?= ($page > 1) ? ($page - 1) : 1 ?>&limit=<?= $limit ?>&query=<?= urlencode($_GET['query'] ?? '') ?>&tab=<?= $active_tab ?>" aria-label="Previous" title="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
                <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                  <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>&query=<?= urlencode($_GET['query'] ?? '') ?>&tab=<?= $active_tab ?>"><?= $i ?></a>
                  </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                  <a class="page-link" href="?page=<?= ($page < $total_pages) ? ($page + 1) : $total_pages ?>&limit=<?= $limit ?>&query=<?= urlencode($_GET['query'] ?? '') ?>&tab=<?= $active_tab ?>" aria-label="Next" title="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              </ul>
            </nav>
          <?php endif; ?>
        </div>
      </div> <!-- End Tab 1 -->

      <div class="tab-pane fade <?= ($active_tab == 'barang_kurang_baik') ? 'show active' : ''; ?>" id="barang_kurang_baik-tab" role="tabpanel">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div>
            <form method="GET" action="">
              <label for="entries" class="me-2">Data Entri</label>
              <select name="limit" id="entries" onchange="this.form.submit()" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                <option value="10" <?= ($limit == 10) ? 'selected' : ''; ?>>10</option>
                <option value="25" <?= ($limit == 25) ? 'selected' : ''; ?>>25</option>
                <option value="50" <?= ($limit == 50) ? 'selected' : ''; ?>>50</option>
                <option value="100" <?= ($limit == 100) ? 'selected' : ''; ?>>100</option>
              </select>
              <input type="hidden" name="page" value="<?= $page; ?>">
              <input type="hidden" name="query" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
              <input type="hidden" name="tab" value="<?= $active_tab; ?>">
            </form>
          </div>
        </div>
        <?php
        $end = min($start + $limit, $total_records);
        echo "<p class='text-muted'>Showing " . ($start + 1) . " to " . $end . " of " . $total_records . " entries</p>";
        ?>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="table-secondary text-center">
              <tr>
                <th scope="col">No. Reg</th>
                <th scope="col">Tgl Perolehan</th>
                <th scope="col">Kode Aset</th>
                <th scope="col">Uraian Aset</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Kondisi</th>
                <th scope="col">Detail</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Default 10 records per page
              $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
              $start = ($page - 1) * $limit; // Starting record for LIMIT
              $search_query = "";
              $search_params = [];
              $param_types = "";

              if (!empty($_GET['query'])) {
                $search = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';
                $search_query = "AND (id_barang_pemda LIKE ? OR kode_barang LIKE ? OR nama_barang LIKE ?)";
                array_push($search_params, $search, $search, $search);
                $param_types .= "sss";
              }

              $sql_kurang = "SELECT * FROM data_barang WHERE kondisi_barang = 'Kurang Baik' $search_query LIMIT ?, ?";

              $stmt_kurang = mysqli_prepare($conn, $sql_kurang);

              if (!empty($_GET['query'])) {
                mysqli_stmt_bind_param($stmt_kurang, "sssii", $search, $search, $search, $start, $limit);
              } else {
                mysqli_stmt_bind_param($stmt_kurang, "ii", $start, $limit);
              }

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

              $count_sql = "SELECT COUNT(*) AS total FROM data_barang WHERE kondisi_barang = 'Kurang Baik' $search_query";
              $count_stmt = mysqli_prepare($conn, $count_sql);

              if (!empty($_GET['query'])) {
                mysqli_stmt_bind_param($count_stmt, "sss", $search, $search, $search);
              }

              mysqli_stmt_execute($count_stmt);
              $count_result = mysqli_stmt_get_result($count_stmt);
              $total_records = mysqli_fetch_assoc($count_result)['total'];
              $total_pages = ceil($total_records / $limit); // Total pages

              $range = 2;
              $start_page = max(1, $page - $range);
              $end_page = min($total_pages, $page + $range);
              ?>
            </tbody>
          </table>
        </div>

        <?php if ($total_pages > 1) : ?>
          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
              <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= ($page > 1) ? ($page - 1) : 1 ?>&limit=<?= $limit ?>&query=<?= urlencode($_GET['query'] ?? '') ?>&tab=barang_kurang_baik" aria-label="Previous" title="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                  <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>&query=<?= urlencode($_GET['query'] ?? '') ?>&tab=barang_kurang_baik"><?= $i ?></a>
                </li>
              <?php endfor; ?>
              <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= ($page < $total_pages) ? ($page + 1) : $total_pages ?>&limit=<?= $limit ?>&query=<?= urlencode($_GET['query'] ?? '') ?>&tab=barang_kurang_baik" aria-label="Next" title="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        <?php endif; ?>
      </div>

      <div class="tab-pane fade <?= ($active_tab == 'barang_rusak') ? 'show active' : ''; ?>" id="barang_rusak-tab" role="tabpanel">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="table-secondary text-center">
              <tr>
                <th scope="col">No. Reg</th>
                <th scope="col">Tgl Perolehan</th>
                <th scope="col">Kode Aset</th>
                <th scope="col">Uraian Aset</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Kondisi</th>
                <th scope="col">Detail</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Default 10 records per page
              $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
              $start = ($page - 1) * $limit; // Starting record for LIMIT
              $search_query = "";
              $search_params = [];
              $param_types = "";

              if (!empty($_GET['query'])) {
                $search = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';
                $search_query = "AND (id_barang_pemda LIKE ? OR kode_barang LIKE ? OR nama_barang LIKE ?)";
                array_push($search_params, $search, $search, $search);
                $param_types .= "sss";
              }

              $sql_rusak = "SELECT * FROM data_barang WHERE kondisi_barang = 'Rusak Berat' $search_query LIMIT ?, ?";
              $stmt_rusak = mysqli_prepare($conn, $sql_rusak);
              if (!empty($_GET['query'])) {
                mysqli_stmt_bind_param($stmt_rusak, "sssii", $search, $search, $search, $start, $limit);
              } else {
                mysqli_stmt_bind_param($stmt_rusak, "ii", $start, $limit);
              }
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
              $count_sql = "SELECT COUNT(*) AS total FROM data_barang WHERE kondisi_barang = 'Rusak Berat' $search_query";
              $count_stmt = mysqli_prepare($conn, $count_sql);
              if (!empty($_GET['query'])) {
                mysqli_stmt_bind_param($count_stmt, "sss", $search, $search, $search);
              }

              mysqli_stmt_execute($count_stmt);
              $count_result = mysqli_stmt_get_result($count_stmt);
              $total_records = mysqli_fetch_assoc($count_result)['total'];
              $total_pages = ceil($total_records / $limit); // Total pages

              $range = 2;
              $start_page = max(1, $page - $range);
              $end_page = min($total_pages, $page + $range);
              ?>
            </tbody>
          </table>
        </div>

        <?php if ($total_pages > 1) : ?>
          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
              <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= ($page > 1) ? ($page - 1) : 1 ?>&limit=<?= $limit ?>&query=<?= urlencode($_GET['query'] ?? '') ?>&tab=barang_rusak" aria-label="Previous" title="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                  <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>&query=<?= urlencode($_GET['query'] ?? '') ?>&tab=barang_rusak"><?= $i ?></a>
                </li>
              <?php endfor; ?>
              <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= ($page < $total_pages) ? ($page + 1) : $total_pages ?>&limit=<?= $limit ?>&query=<?= urlencode($_GET['query'] ?? '') ?>&tab=barang_rusak" aria-label="Next" title="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        <?php endif; ?>
      </div>

    </div>
  </div>
</main>

<?php include("component/footer.php"); ?>