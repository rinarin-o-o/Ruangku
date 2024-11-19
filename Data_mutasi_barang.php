<<<<<<< HEAD
<?php
include("component/header.php");
include("koneksi/koneksi.php");

// Set batas per halaman dan halaman yang aktif
$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$start = ($page - 1) * $limit;

// Inisialisasi variabel untuk pencarian
$search_query = "";
$search_params = [];
$param_types = "";

if (!empty($_GET['query'])) {
  $search = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';
  $search_query = "WHERE id_mutasi LIKE ? OR id_barang_pemda LIKE ? OR kode_barang LIKE ? OR nama_barang LIKE ?";
  $search_params = [$search, $search, $search, $search];
  $param_types = "ssss";
}

// Query untuk mengambil data dengan pencarian dan filter
$sql = "SELECT * FROM mutasi_barang $search_query LIMIT ?, ?";
$count_sql = "SELECT COUNT(*) AS total FROM mutasi_barang $search_query";

// Menambahkan batas limit dan offset ke parameter
$search_params[] = $start;
$search_params[] = $limit;
$param_types .= "ii";

// Jalankan query utama
$stmt = mysqli_prepare($conn, $sql);
if ($param_types) {
  mysqli_stmt_bind_param($stmt, $param_types, ...$search_params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Query untuk menghitung total record
$count_stmt = mysqli_prepare($conn, $count_sql);
if ($param_types && strlen($param_types) > 2) {
  // Exclude last two 'i' types for limit and offset in count query
  mysqli_stmt_bind_param($count_stmt, substr($param_types, 0, -2), ...array_slice($search_params, 0, -2));
}
mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);

// Range untuk pagination
$range = 2;
$start_page = max(1, $page - $range);
$end_page = min($total_pages, $page + $range);
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Data Mutasi Barang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
        <li class="breadcrumb-item">Riwayat</li>
        <li class="breadcrumb-item active">Mutasi Barang</li>
      </ol>
    </nav>
  </div>

  <div class="card">
    <div class="card-body" style="padding-top: 30px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="flex-grow-1 d-flex justify-content-center">
          <div class="search-bar position-relative">
            <form class="search-form d-flex align-items-center" method="GET" action="">
              <input type="text" id="search-input" name="query" placeholder="Cari" class="form-control pe-5" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>" oninput="toggleClearButton()">
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
              window.location.href = 'Data_mutasi_barang.php?limit=<?= $limit; ?>&page=<?= $page; ?>';
            }
            document.addEventListener('DOMContentLoaded', toggleClearButton);
          </script>
        </div>
      </div>
      <div class="table-responsive" style="padding-top: 15px;">
        <!-- Tabel Data -->
        <table class="table table-bordered" style="font-size: 12px;">
          <thead class="table-secondary text-center">
            <tr>
              <th>ID Mutasi</th>
              <th>ID Pemda</th>
              <th>Nama Aset</th>
              <th>Lokasi Sebelumnya</th>
              <th>Lokasi Sekarang</th>
              <th>Jenis Mutasi</th>
              <th>Tgl Mutasi</th>
              <th>PJ</th>
              <th>Ket</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0) : ?>
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr class="text-center">
                  <td><?= $row['id_mutasi'] ?></td>
                  <td><?= $row['id_barang_pemda'] ?></td>
                  <td><?= $row['nama_barang'] ?></td>
                  <td><?= $row['ruang_asal'] ?></td>
                  <td><?= $row['ruang_tujuan'] ?></td>
                  <td><?= $row['jenis_mutasi'] ?></td>
                  <td><?= $row['tgl_mutasi'] ?></td>
                  <td><?= $row['penanggungjawab'] ?></td>
                  <td><?= $row['keterangan'] ?></td>
                  <td><a href="frm_edit_mutasi.php?id_mutasi=<?= $row['id_mutasi'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a></td>
                </tr>
              <?php endwhile; ?>
            <?php else : ?>
              <tr>
                <td colspan="10" class="text-center">Tidak ada data yang ditemukan</td>
              </tr>
            <?php endif; ?>
            <?php mysqli_close($conn); ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <?php if ($total_pages > 1) : ?>
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= max(1, $page - 1) ?>&limit=<?= $limit ?>" aria-label="Previous">&laquo;</a>
            </li>
            <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
              <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>&limit=<?= $limit ?>" aria-label="Next">&raquo;</a>
            </li>
          </ul>
        </nav>
      <?php endif; ?>
    </div>
  </div>
</main>

=======
<?php
include("component/header.php");
include("koneksi/koneksi.php");

// Set batas per halaman dan halaman yang aktif
$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$start = ($page - 1) * $limit;

// Inisialisasi variabel untuk pencarian
$search_query = "";
$search_params = [];
$param_types = "";

if (!empty($_GET['query'])) {
  $search = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';
  $search_query = "WHERE id_mutasi LIKE ? OR id_barang_pemda LIKE ? OR kode_barang LIKE ? OR nama_barang LIKE ?";
  $search_params = [$search, $search, $search, $search];
  $param_types = "ssss";
}

// Query untuk mengambil data dengan pencarian dan filter
$sql = "SELECT * FROM mutasi_barang $search_query LIMIT ?, ?";
$count_sql = "SELECT COUNT(*) AS total FROM mutasi_barang $search_query";

// Menambahkan batas limit dan offset ke parameter
$search_params[] = $start;
$search_params[] = $limit;
$param_types .= "ii";

// Jalankan query utama
$stmt = mysqli_prepare($conn, $sql);
if ($param_types) {
  mysqli_stmt_bind_param($stmt, $param_types, ...$search_params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Query untuk menghitung total record
$count_stmt = mysqli_prepare($conn, $count_sql);
if ($param_types && strlen($param_types) > 2) {
  // Exclude last two 'i' types for limit and offset in count query
  mysqli_stmt_bind_param($count_stmt, substr($param_types, 0, -2), ...array_slice($search_params, 0, -2));
}
mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);

// Range untuk pagination
$range = 2;
$start_page = max(1, $page - $range);
$end_page = min($total_pages, $page + $range);
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Data Mutasi Barang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
        <li class="breadcrumb-item">Riwayat</li>
        <li class="breadcrumb-item active">Mutasi Barang</li>
      </ol>
    </nav>
  </div>

  <div class="card">
    <div class="card-body" style="padding-top: 30px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="flex-grow-1 d-flex justify-content-center">
          <div class="search-bar position-relative">
            <form class="search-form d-flex align-items-center" method="GET" action="">
              <input type="text" id="search-input" name="query" placeholder="Cari" class="form-control pe-5" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>" oninput="toggleClearButton()">
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
              window.location.href = 'Data_mutasi_barang.php?limit=<?= $limit; ?>&page=<?= $page; ?>';
            }
            document.addEventListener('DOMContentLoaded', toggleClearButton);
          </script>
        </div>
      </div>
      <div class="table-responsive" style="padding-top: 15px;">
        <!-- Tabel Data -->
        <table class="table table-bordered" style="font-size: 12px;">
          <thead class="table-secondary text-center">
            <tr>
              <th>ID Mutasi</th>
              <th>ID Pemda</th>
              <th>Nama Aset</th>
              <th>Lokasi Sebelumnya</th>
              <th>Lokasi Sekarang</th>
              <th>Jenis Mutasi</th>
              <th>Tgl Mutasi</th>
              <th>PJ</th>
              <th>Ket</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0) : ?>
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr class="text-center">
                  <td><?= $row['id_mutasi'] ?></td>
                  <td><?= $row['id_barang_pemda'] ?></td>
                  <td><?= $row['nama_barang'] ?></td>
                  <td><?= $row['ruang_asal'] ?></td>
                  <td><?= $row['ruang_tujuan'] ?></td>
                  <td><?= $row['jenis_mutasi'] ?></td>
                  <td><?= $row['tgl_mutasi'] ?></td>
                  <td><?= $row['penanggungjawab'] ?></td>
                  <td><?= $row['keterangan'] ?></td>
                  <td><a href="frm_edit_mutasi.php?id_mutasi=<?= $row['id_mutasi'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a></td>
                </tr>
              <?php endwhile; ?>
            <?php else : ?>
              <tr>
                <td colspan="10" class="text-center">Tidak ada data yang ditemukan</td>
              </tr>
            <?php endif; ?>
            <?php mysqli_close($conn); ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <?php if ($total_pages > 1) : ?>
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= max(1, $page - 1) ?>&limit=<?= $limit ?>" aria-label="Previous">&laquo;</a>
            </li>
            <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
              <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>&limit=<?= $limit ?>" aria-label="Next">&raquo;</a>
            </li>
          </ul>
        </nav>
      <?php endif; ?>
    </div>
  </div>
</main>

>>>>>>> 8794dfa5ca3bdc204900f670156ef4a33b0cc6d6
<?php include("component/footer.php"); ?>