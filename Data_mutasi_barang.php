<?php
include("component/header.php");
include("koneksi/koneksi.php");

// Jika session 'success' ada, tampilkan pesan SweetAlert
if (isset($_SESSION['success']) && $_SESSION['success']) {
  echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil diperbarui! 🎉',
                    icon: 'success',
                    confirmButtonText: 'Oke'
                });
            });
          </script>";
  // Hapus session 'success' agar tidak tampil lagi setelah refresh
  unset($_SESSION['success']);
}

// Pagination settings
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit; // Starting record

// Initialize month and year variables
$selected_month = isset($_POST['month']) ? mysqli_real_escape_string($conn, $_POST['month']) : '';
$selected_year = isset($_POST['year']) ? mysqli_real_escape_string($conn, $_POST['year']) : '';

?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Data Mutasi Barang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Data</li>
        <li class="breadcrumb-item active">Mutasi Barang</li>
      </ol>
    </nav>
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
  </div><!-- End Select Bulan dan Tahun -->

  <!-- Data Table -->
  <table class="table table-bordered">
    <thead class="table-secondary text-center">
      <tr>
        <th scope="col">ID Mutasi</th>
        <th scope="col">ID Barang</th>
        <th scope="col">Kode Barang</th>
        <th scope="col">Nama Barang</th>
        <th scope="col">Lokasi Sebelumnya</th>
        <th scope="col">Lokasi Sekarang</th>
        <th scope="col">Jenis Mutasi</th>
        <th scope="col">Tanggal Mutasi</th>
        <th scope="col">PenanggungJawab</th>
        <th scope="col">Keterangan</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Search Query
      $search_query = "";
      if (isset($_POST['query']) && !empty($_POST['query'])) {
        $search = mysqli_real_escape_string($conn, $_POST['query']);
        $search_query = " WHERE kode_barang LIKE '%$search%' OR nama_barang LIKE '%$search%'";
      }

      // Constructing date filter query
      $date_filter_query = "";
      if (!empty($selected_month) && !empty($selected_year)) {
        if (!empty($search_query)) {
          $date_filter_query = " AND MONTH(tgl_mutasi) = '$selected_month' AND YEAR(tgl_mutasi) = '$selected_year'";
        } else {
          $date_filter_query = " WHERE MONTH(tgl_mutasi) = '$selected_month' AND YEAR(tgl_mutasi) = '$selected_year'";
        }
      }

      // Fetching the total number of records for pagination
      $query_count = "SELECT COUNT(*) AS total_records FROM mutasi_barang" . $search_query . $date_filter_query;
      $result_count = mysqli_query($conn, $query_count);
      $total_records = mysqli_fetch_assoc($result_count)['total_records'];
      $total_pages = ceil($total_records / $limit);

      // Fetching data with sorting, pagination, and optional search
      $query = "SELECT id_mutasi, id_barang_pemda, kode_barang, nama_barang, ruang_asal, ruang_tujuan, jenis_mutasi, tgl_mutasi, penanggungjawab, keterangan 
                FROM mutasi_barang
                $search_query
                $date_filter_query
                ORDER BY tgl_mutasi DESC 
                LIMIT $start, $limit";
      $result = mysqli_query($conn, $query);

      // Displaying fetched data
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr class='text-center'>
                      <td>{$row['id_mutasi']}</td>
                      <td>{$row['id_barang_pemda']}</td>
                      <td>{$row['kode_barang']}</td>
                      <td>{$row['nama_barang']}</td>
                      <td>{$row['ruang_asal']}</td>
                      <td>{$row['ruang_tujuan']}</td>
                      <td>{$row['jenis_mutasi']}</td>
                      <td>{$row['tgl_mutasi']}</td>
                      <td>{$row['penanggungjawab']}</td>
                      <td>{$row['keterangan']}</td>
                      <td> <a href='frm_edit_mutasi.php?id_mutasi={$row['id_mutasi']}' class='btn btn-warning btn-sm' title='Edit'>
                      <i class='bi bi-pencil'></i>
                    </a>
                            </td>
                    </tr>";
        }
      } else {
        echo "<tr><td colspan='10' class='text-center'>No data available</td></tr>";
      }

      mysqli_close($conn);
      ?>
    </tbody>
  </table>

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

<!-- Modal Edit Mutasi -->
<div class="modal fade" id="modalEditMutasi" tabindex="-1" aria-labelledby="editMutasi" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Data Mutasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editMutasiForm">
          <input type="hidden" id="edit_id_mutasi" name="id_mutasi">
          <div class="mb-3">
            <label for="jenis_mutasi" class="form-label">Jenis Mutasi</label>
            <input type="text" class="form-control" id="edit_jenis_mutasi" name="jenis_mutasi" required>
          </div>
          <div class="mb-3">
            <label for="tgl_mutasi" class="form-label">Tanggal Mutasi</label>
            <input type="date" class="form-control" id="edit_tgl_mutasi" name="tgl_mutasi" required>
          </div>
          <div class="mb-3">
            <label for="penanggungjawab" class="form-label">Penanggung Jawab</label>
            <input type="text" class="form-control" id="edit_penanggungjawab" name="penanggungjawab" required>
          </div>
          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3" required></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div><!-- End Modal Edit Mutasi -->

<script>
  // Function to open the edit modal and populate the fields
  function openEditModal(id_mutasi) {
    console.log(id_mutasi);
    // Use AJAX to fetch data based on id_mutasi
    $.ajax({
      url: 'get_mutasi_data.php',
      type: 'POST',
      data: {
        id_mutasi: id_mutasi
      },
      dataType: 'json',
      success: function(data) {
        console.log(data); // Pastikan data yang dikembalikan benar
        $('#edit_id_mutasi').val(data.id_mutasi);
        $('#edit_jenis_mutasi').val(data.jenis_mutasi);
        $('#edit_tgl_mutasi').val(data.tgl_mutasi);
        $('#edit_penanggungjawab').val(data.penanggungjawab);
        $('#edit_keterangan').val(data.keterangan);
        $('#modalEditMutasi').modal('show');
      },
      error: function(xhr, status, error) {
        console.error("Error: " + error); // Cek jika ada error
      }
    });

  }

  // Handle form submission for editing
  $('#editMutasiForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the form from submitting the default way
    $.ajax({
      url: 'proses/mutasi/edit_mutasi.php', // URL to your update script
      type: 'POST',
      data: $(this).serialize(), // Serialize the form data
      success: function(response) {
        // Handle success (e.g., refresh the table or show a success message)
        location.reload(); // Reload the page to see changes
      },
      error: function(xhr, status, error) {
        // Handle error
        alert("Terjadi kesalahan: " + error);
      }
    });
  });
</script>

<?php include("component/footer.php"); ?>