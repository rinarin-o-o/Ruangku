<?php include("component/header.php");
include("koneksi/koneksi.php");

$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit; // Starting record

// Initialize month and year variables
$selected_month = isset($_POST['month']) ? mysqli_real_escape_string($conn, $_POST['month']) : '';
$selected_year = isset($_POST['year']) ? mysqli_real_escape_string($conn, $_POST['year']) : '';

?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Penggunaan Ruangan</h1>
  </div><!-- End Page Title -->

  <!-- Select Bulan dan Tahun dan Edit Button -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <form class="d-flex align-items-center" method="POST" action="#" id="filterForm">
      <!-- Dropdown untuk bulan -->
      <div class="dropdown-icon-wrapper position-relative">
        <select class="form-select" name="month" aria-label="Default select example">
          <option value="" disabled <?= $selected_month == '' ? 'selected' : '' ?>>Bulan</option>
          <!-- Opsi bulan -->
          <?php for ($i = 1; $i <= 12; $i++) {
            $month = sprintf("%02d", $i);
            $monthName = date("F", mktime(0, 0, 0, $i, 10));
            echo "<option value='$month' " . ($selected_month == $month ? 'selected' : '') . ">$monthName</option>";
          } ?>
        </select>
      </div>

      <!-- Dropdown untuk tahun -->
      <div class="dropdown-icon-wrapper position-relative">
        <select class="form-select" name="year" aria-label="Default select example">
          <option value="" disabled <?= $selected_year == '' ? 'selected' : '' ?>>Tahun</option>
          <?php
          $currentYear = date("Y");
          for ($i = $currentYear; $i >= 2024; $i--) {
            echo "<option value='$i' " . ($selected_year == $i ? 'selected' : '') . ">$i</option>";
          }
          ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary ms-2">Filter</button>
    </form>

    <a href="jd_frm_tambah_ruang.php" class="btn btn-primary" title ='Tambah Penggunaan'>
      <i class="bi bi-plus"></i>
    </a>
  </div><!-- End Select Bulan dan Tahun dan Edit Button -->

  <!-- Data Table -->
  <table class="table table-bordered" style="font-size: 14px;">
    <thead class="table-secondary text-center">
      <tr>
        <th scope="col">No</th>
        <th scope="col">Ruang</th>
        <th scope="col">Jadwal Pakai</th>
        <th scope="col">Jadwal Selesai</th>
        <th scope="col">Kegiatan</th>
        <th scope="col">Pengguna</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Search Query
      $search_query = "";
      if (isset($_POST['query']) && !empty($_POST['query'])) {
        $search = mysqli_real_escape_string($conn, $_POST['query']);
        $search_query = " WHERE id_jadwal_ruang LIKE '%$search%' OR nama_lokasi LIKE '%$search%' OR acara LIKE '%$search%";
      }

      // Constructing date filter query
      $date_filter_query = "";
      if (!empty($selected_month) && !empty($selected_year)) {
        if (!empty($search_query)) {
          $date_filter_query = " AND MONTH(tgl_mulai) = '$selected_month' AND YEAR(tgl_mulai) = '$selected_year'";
        } else {
          $date_filter_query = " WHERE MONTH(tgl_mulai) = '$selected_month' AND YEAR(tgl_mulai) = '$selected_year'";
        }
      }

      // Fetching the total number of records for pagination
      $query_count = "SELECT COUNT(*) AS total_records FROM jadwal_ruang" . $search_query . $date_filter_query;
      $result_count = mysqli_query($conn, $query_count);
      $total_records = mysqli_fetch_assoc($result_count)['total_records'];
      $total_pages = ceil($total_records / $limit);

      // Fetching data with sorting, pagination, and optional search
      $query = "SELECT * FROM jadwal_ruang
      $search_query
      $date_filter_query
      ORDER BY tgl_mulai DESC 
      LIMIT $start, $limit";
      $result = mysqli_query($conn, $query);

      $no = $start + 1; // Initializing the row number

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr class='text-center'>
          <td>$no</td> <!-- Displaying row number -->
          <td>{$row['nama_lokasi']}</td>
          <td>{$row['tgl_mulai']} {$row['waktu_mulai']}</td>
          <td>{$row['tgl_selesai']} {$row['waktu_selesai']}</td>
          <td>{$row['acara']}</td>
          <td>{$row['pengguna']}</td>
          <td>
          <a href='jd_frm_edit_ruang.php?id_jadwal_ruang={$row['id_jadwal_ruang']}' class='btn btn-info btn-sm' title='Selengkapnya'>
          <i class='bi bi-info-circle'></i>
 
          </a>
          <button class='btn btn-danger btn-sm btn-hapus' data-id_jadwal_ruang='{$row['id_jadwal_ruang']}' title='Hapus'>
            <i class='bi bi-trash'></i>
          </button>
        </td>
          </tr>";
          $no++; // Incrementing row number
        }
      } else {
        echo "<tr><td colspan='10' class='text-center'Tidak ada data</td></tr>";
      }

      mysqli_close($conn);

      ?>
    </tbody>
  </table><!-- End Data Table -->

   <!-- Pagination Links -->
   <?php if ($total_records > $limit) : ?>
    <nav aria-label="Page navigation example" class="d-flex justify-content-center">
      <ul class="pagination">
        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= ($page > 1) ? ($page - 1) : 1 ?>" tabindex="-1" aria-disabled="true">Sebelumnya</a>
        </li>

        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
          <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
          </li>
        <?php endfor; ?>

        <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= ($page < $total_pages) ? ($page + 1) : $total_pages ?>">Selanjutnya</a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>

</main><!-- End Main Content -->

<?php include("component/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Event handler untuk tombol hapus
    $('.btn-hapus').on('click', function() {
        // Ambil id_jadwal_ruang dari atribut data
        var id_jadwal_ruang = $(this).data('id_jadwal_ruang');

        // Tampilkan popup SweetAlert2
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Data penggunaan ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke halaman hapus
                window.location.href = 'proses/jadwal/jd_hapus_ruang.php?id_jadwal_ruang=' + id_jadwal_ruang;
            }
        });
    });
});
</script>
