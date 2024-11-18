<?php include("component/header.php"); ?>
<?php include("koneksi/koneksi.php");

$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$start = ($page - 1) * $limit;

$search_query = "";
$search_params = [];
$param_types = "";

if (!empty($_GET['query'])) {
    $search = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';
    $search_query = "WHERE dp.id_pemeliharaan LIKE ? OR dp.id_barang_pemda LIKE ? OR dp.kode_barang LIKE ? OR db.nama_barang LIKE ?";
    $search_params = [$search, $search, $search, $search];
    $param_types = "ssss";
}

$sql = "SELECT dp.*, db.no_regristrasi, db.nama_barang, db.harga_awal, db.harga_total 
        FROM data_pemeliharaan dp
        JOIN data_barang db ON dp.id_barang_pemda = db.id_barang_pemda
        $search_query
        LIMIT ?, ?";

$count_sql = "SELECT COUNT(*) AS total 
              FROM data_pemeliharaan dp
              JOIN data_barang db ON dp.id_barang_pemda = db.id_barang_pemda
              $search_query";

$search_params[] = $start;
$search_params[] = $limit;
$param_types .= "ii";

// Prepare and execute the SELECT query
$stmt = mysqli_prepare($conn, $sql);
if ($param_types) {
    mysqli_stmt_bind_param($stmt, $param_types, ...$search_params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Prepare and execute the COUNT query
$count_stmt = mysqli_prepare($conn, $count_sql);
if ($param_types && strlen($param_types) > 2) {
    mysqli_stmt_bind_param($count_stmt, substr($param_types, 0, -2), ...array_slice($search_params, 0, -2));
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
    <h1>Data Pemeliharaan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
        <li class="breadcrumb-item">Riwayat</li>
        <li class="breadcrumb-item active">Pemeliharaan</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  
  <div class="card">
    <div class="card-body" style="padding-top: 20px;">
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
              window.location.href = 'Data_pemeliharaan.php?limit=<?= $limit; ?>&page=<?= $page; ?>';
            }
            document.addEventListener('DOMContentLoaded', toggleClearButton);
          </script>
        </div>
      </div>

      <div class="table-responsive" style="padding-top: 15px;">
        <table class="table table-bordered" style="font-size: 14px;">
          <thead class="table-secondary text-center">
            <tr>
              <th scope="col">ID Pemeliharaan</th>
              <th scope="col">ID Pemda</th>
              <th scope="col">No. Reg</th>
              <th scope="col">Nama Aset</th>
              <th scope="col">Desk Pemeliharaan / Kerusakan</th>
              <th scope="col">Perbaikan</th>
              <th scope="col">Tgl Perbaikan</th>
              <th scope="col">Lama Perbaikan</th>
              <th scope="col">Biaya Perbaikan</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='text-center'>
                        <td>{$row['id_pemeliharaan']}</td>
                        <td>{$row['id_barang_pemda']}</td>
                        <td>{$row['no_regristrasi']}</td>
                        <td>{$row['nama_barang']}</td>
                        <td>{$row['desk_pemeliharaan']}</td>
                        <td>{$row['perbaikan']}</td>
                        <td>{$row['tgl_perbaikan']}</td>
                        <td>{$row['lama_perbaikan']}</td>
                        <td>Rp " . number_format($row['biaya_perbaikan'], 2, ',', '.') . "</td>
                        <td>
                          <a href='frm_edit_pemeliharaan.php?id_pemeliharaan={$row['id_pemeliharaan']}' class='btn btn-warning btn-sm' data-bs-toggle='tooltip' title='Edit'>
                            <i class='bi bi-pencil'></i>
                          </a>
                          <button class='btn btn-danger btn-sm btn-hapus' data-id_pemeliharaan='{$row['id_pemeliharaan']}' title='Hapus'>
                            <i class='bi bi-trash'></i>
                          </button>
                        </td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='10' class='text-center'>Tidak ada data yang ditemukan</td></tr>";
            }
            ?>
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
</main><!-- End Main Content -->

<?php include("component/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    // Event handler for delete button
    $('.btn-hapus').on('click', function() {
      var id_pemeliharaan = $(this).data('id_pemeliharaan');

      Swal.fire({
        title: 'Apakah kamu yakin?',
        text: "Data ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'proses/pemeliharaan/hapus_pemeliharaan.php?id_pemeliharaan=' + id_pemeliharaan;
        }
      });
    });
  });
</script> 
