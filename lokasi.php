<?php
include("component/header.php");
include('koneksi/koneksi.php');

// Halaman
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search_query = "";
$search_params = [];
$param_types = "";

// Mengecek apakah ada input pencarian
if (!empty($_GET['query'])) {
  $search = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';
  $search_query = "WHERE id_lokasi LIKE ? OR nama_lokasi LIKE ? OR bid_lokasi LIKE ? OR tempat_lokasi LIKE ?";
  array_push($search_params, $search, $search, $search, $search);
  $param_types .= "ssss"; // Tambahkan empat "s" untuk empat LIKE parameter
}

// Query SQL utama
$sql = "SELECT * FROM lokasi $search_query LIMIT ?, ?";
$stmt = mysqli_prepare($conn, $sql);

// Tambahkan tipe untuk dua parameter limit dan offset
$param_types .= "ii";
array_push($search_params, $start, $limit);

// Bind parameter sesuai dengan tipe dan jumlah
mysqli_stmt_bind_param($stmt, $param_types, ...$search_params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


$count_sql = "SELECT COUNT(*) AS total FROM lokasi $search_query";
$count_stmt = mysqli_prepare($conn, $count_sql);

if (!empty($search_query)) {
  mysqli_stmt_bind_param($count_stmt, substr($param_types, 0, -2), ...array_slice($search_params, 0, -2)); // Only bind search params
}

mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);


?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Daftar Ruang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
        <li class="breadcrumb-item">Data</li>
        <li class="breadcrumb-item active">Lokasi</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <div class="card">
    <div class="card-body" style="padding-top: 20px;">
      <div class="d-flex justify-content-between align-items-center mb-2" style="padding-top: 10px; padding-bottom: 10px">
        <div class="flex-grow-1 d-flex justify-content-center">
          <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="GET" action="">
              <input type="text" name="query" placeholder="Cari Aset" title="Cari Ruangan" class="form-control me-2" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
              <button type="submit" title="Cari" class="btn btn-outline-primary">
                <i class="bi bi-search"></i>
              </button>
            </form>
          </div>
        </div>
        <div>
          <a href="frm_tambah_lokasi.php" class="btn btn-primary btn-sm" title="Tambah Data Ruang">+
          </a>
        </div>
      </div>
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

      <?php
      $end = min($start + $limit, $total_records); // Calculates the last record number displayed
      $showing_text = "Menampilkan " . ($start + 1) . " hingga " . $end . " dari " . $total_records . " entri";
      echo "<p class='text-muted'>$showing_text</p>";
      ?>
      <div class="table-responsive">
        <!-- Data Table -->
        <table class="table table-bordered" style="font-size: 14px;">
          <thead class="table-secondary text-center">
            <tr>
              <th scope="col" style="width: 5%;">No</th>
              <th scope="col" style="width: 10%;">Kode Ruang</th>
              <th scope="col" style="width: 20%;">Nama Ruang</th>
              <th scope="col" style="width: 15%;">Kode Lokasi</th>
              <th scope="col" style="width: 20%;">Lokasi</th>
              <th scope="col" style="width: 20%;">Deskripsi</th>
              <th scope="col" style="width: 10%;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $offset = $start;
            $no = $offset + 1;
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr class='text-center'>";
              echo "<th scope='row'>{$no}</th>";
              echo "<td>{$row['id_lokasi']}</td>";
              echo "<td>{$row['bid_lokasi']}</td>";
              echo "<td>{$row['nama_lokasi']}</td>";
              echo "<td>{$row['tempat_lokasi']}</td>";
              echo "<td>{$row['desk_lokasi']}</td>";
              echo "<td>
          <a href='frm_edit_lokasi.php?id_lokasi={$row['id_lokasi']}' class='btn btn-warning btn-sm' title='Edit'>
            <i class='bi bi-pencil'></i>
          </a>
          <button class='btn btn-danger btn-sm btn-hapus' data-id_lokasi='{$row['id_lokasi']}' title='Hapus'>
            <i class='bi bi-trash'></i>
          </button>
        </td>";
              echo "</tr>";
              $no++;
            }
            ?>


          </tbody>
        </table>
        <?php if ($total_records > $limit) : ?>
          <nav aria-label="Page navigation example" class="d-flex justify-content-center">
            <ul class="pagination">
              <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= ($page > 1) ? ($page - 1) : 1 ?><?= isset($_GET['filter']) ? '&filter=' . $_GET['filter'] : '' ?>" aria-label="Sebelumnya" title="Sebelumnya">
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
  </div>

</main><!-- End Main Content -->

<?php include("component/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    // Event handler untuk tombol hapus
    $('.btn-hapus').on('click', function() {
      // Ambil id_lokasi dari atribut data
      var id_lokasi = $(this).data('id_lokasi');

      // Tampilkan popup SweetAlert2
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
          // Redirect ke halaman hapus
          window.location.href = 'proses/lokasi/hapus_lokasi.php?id_lokasi=' + id_lokasi;
        }
      });
    });
  });
</script>