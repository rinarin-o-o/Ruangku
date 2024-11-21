<?php
include("component/header.php");
include("proses/lokasi/get data/get_lokasi.php");
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Daftar Ruang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
        <li class="breadcrumb-item">Inventaris</li>
        <li class="breadcrumb-item active">Ruang dan Lokasi</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <div class="card">
    <div class="card-body" style="padding-top: 20px;">
      <div class="d-flex justify-content-between align-items-center mb-2" style="padding-top: 10px; padding-bottom: 10px">
        <div class="flex-grow-1 d-flex justify-content-center">
          <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="GET" action="">
              <input type="text" name="query" placeholder="Cari Ruang" title="Cari Ruangan" class="form-control me-2" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
              <button type="submit" title="Cari" class="btn btn-outline-primary">
                <i class="bi bi-search"></i>
              </button>
            </form>
          </div> <!-- End search -->
        </div>
        <div>
          <a href="frm_tambah_lokasi.php" class="btn btn-primary btn-sm" title="Tambah Data Ruang">+
          </a>
        </div> <!-- End tambah -->
      </div> <!-- End atas -->
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
      </div> <!-- End data etri -->
      <?php
      echo "<p class='text-muted'>$showing_text</p>";
      ?>
      <div class="table-responsive">
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
      </div>  <!-- end table -->
    </div>
  </div> <!-- card lokasi -->
</main>

<?php include("component/footer.php"); ?>