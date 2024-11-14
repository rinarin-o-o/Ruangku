<?php
include("component/header.php");
include 'koneksi/koneksi.php'; // Koneksi ke database

$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 20;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$start = ($page - 1) * $limit;

$search_query = "";
$search_params = [];
$param_types = "";

if (!empty($_GET['query'])) {
  $search = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';
  $search_query = "WHERE b.nama_barang LIKE ? OR b.kode_barang LIKE ? OR b.id_barang_pemda LIKE ?";
  $search_params = [$search, $search, $search, $search];
  $param_types = "ssss";
}

// ambil id_lokasi dan nama_lokasi dari parameter URL
$id_lokasi = isset($_GET['id_lokasi']) ? $_GET['id_lokasi'] : 0;
$id_lokasi = isset($_GET['id_lokasi']) ? $_GET['id_lokasi'] : 0;

$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '';

// Query untuk mendapatkan nama_lokasi berdasarkan id_lokasi
$query_lokasi = "SELECT bid_lokasi FROM lokasi WHERE id_lokasi = ?";
$stmt_lokasi = mysqli_prepare($conn, $query_lokasi);
mysqli_stmt_bind_param($stmt_lokasi, "s", $id_lokasi);
mysqli_stmt_execute($stmt_lokasi);
$result_lokasi = mysqli_stmt_get_result($stmt_lokasi);
$nama_ruang = mysqli_fetch_assoc($result_lokasi)['bid_lokasi'] ?? '';

// Query untuk mendapatkan data barang dengan atau tanpa tanggal
if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
  $query = "SELECT b.id_barang_pemda, b.kode_barang, b.nama_barang, b.kategori, b.merk, b.no_pabrik, b.ukuran_CC, 
              b.bahan, b.tgl_pembelian, b.harga_awal, b.kondisi_barang 
              FROM data_barang b
              WHERE b.id_ruang_sekarang = ? 
              AND b.tgl_pembelian BETWEEN ? AND ? $search_query
              LIMIT ?, ?";
  $param_types = "sssii"; // tambahkan 's' untuk parameter tanggal
  $search_params = array_merge([$id_lokasi, $tanggal_mulai, $tanggal_akhir], $search_params, [$start, $limit]);
} else {
  $query = "SELECT b.id_barang_pemda, b.kode_barang, b.nama_barang, b.kategori, b.merk, b.no_pabrik, b.ukuran_CC, 
              b.bahan, b.tgl_pembelian, b.harga_awal, b.kondisi_barang  
              FROM data_barang b
              WHERE b.id_ruang_sekarang = ? $search_query
              LIMIT ?, ?";
  $param_types = "sii";
  $search_params = array_merge([$id_lokasi], $search_params, [$start, $limit]);
}

// Mempersiapkan statement
$stmt = mysqli_prepare($conn, $query);

// Menambahkan bind param secara dinamis
if (!empty($param_types) && !empty($search_params)) {
  mysqli_stmt_bind_param($stmt, $param_types, ...$search_params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Get total records for pagination
$count_sql = "SELECT COUNT(*) AS total FROM data_barang b WHERE b.id_ruang_sekarang = ? $search_query";
$count_stmt = mysqli_prepare($conn, $count_sql);
$count_param_types = "s";
$count_search_params = [$id_lokasi];
if (!empty($search_query)) {
  $count_param_types .= "s";
  $count_search_params[] = $search;
}
mysqli_stmt_bind_param($count_stmt, $count_param_types, ...$count_search_params);
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
    <h1>Inventaris Ruangan</h1>
  </div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title" style="font-size: 18px !important;"><?= htmlspecialchars($nama_ruang) ?></h5>
      <div class="d-flex justify-content-between mb-3">
        <div style="font-size: 14px !important;">
          Kode Ruang: <?= htmlspecialchars($id_lokasi) ?>
        </div>
        <div style="font-size: 14px !important;">
          Tanggal: <?= !empty($tanggal_mulai) ? date('d/m/Y', strtotime($tanggal_mulai)) : date('d/m/Y') ?>
        </div>
      </div>
      <!-- Default Tabs -->
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Daftar Barang / Aset</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">QRCode</button>
        </li>
      </ul>

      <div class="tab-content pt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="d-flex gap-2 mb-3" style="padding-top: 10px;">
            <a href="proses/inventaris/export_kir_xls.php?id_lokasi=<?= $id_lokasi ?>&nama_lokasi=<?= urlencode($nama_ruang) ?>" class="btn btn-outline-success btn-sm">
              <i class="bi bi-file-earmark-excel"></i> Cetak KIR
            </a>

            <a href="proses/inventaris/export_label_kir_pdf.php?id_lokasi=<?= $id_lokasi ?>" class="btn btn-outline-warning btn-sm">
              <i class="bi bi-printer"></i> Cetak Label Barang
            </a>
          </div>
          
          <div class="table-responsive">
            <table class="table table-bordered align-middle text-center mb-4" style="font-size: 12px;">
              <thead class="table-secondary align-middle text-center">
                <tr>
                  <th>No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Merk</th>
                  <th>No. Pabrik</th>
                  <th>Ukuran</th>
                  <th>Bahan</th>
                  <th>Tanggal Pembelian</th>
                  <th>Harga Beli</th>
                  <th>Kondisi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Before the while loop, initialize the $no variable
                $no = $start + 1; // Start counting from the current record number based on pagination

                while ($row = mysqli_fetch_assoc($result)) : ?>
                  <tr class='text-center'>
                    <td><?= $no ?></td>
                    <td><?= htmlspecialchars($row['kode_barang'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['nama_barang'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['merk'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['no_pabrik'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['ukuran_CC'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['bahan'] ?? '') ?></td>
                    <td><?= isset($row['tgl_pembelian']) ? date('d/m/Y', strtotime($row['tgl_pembelian'])) : '-' ?></td>
                    <td>Rp <?= isset($row['harga_awal']) ? number_format($row['harga_awal'], 2, ',', '.') : '0,00' ?></td>
                    <td><?= htmlspecialchars($row['kondisi_barang'] ?? '') ?></td>
                  </tr>
                  <?php $no++; // Increment the counter for the next row 
                  ?>
                <?php endwhile; ?>

                <?php if (mysqli_num_rows($result) == 0) : ?>
                  <tr>
                    <td colspan="10">Tidak ada data yang ditemukan</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <?php if ($total_pages > 1) : ?>
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-center">
                <?php
                // Tentukan jumlah halaman yang ingin ditampilkan
                $max_pagination = 5;

                // Tentukan range halaman berdasarkan halaman aktif
                $half_range = floor($max_pagination / 2);
                $start_page = max(1, $page - $half_range);
                $end_page = min($total_pages, $page + $half_range);

                // Koreksi jika halaman di awal lebih sedikit dari jumlah yang ditentukan
                if ($end_page - $start_page + 1 < $max_pagination) {
                  $start_page = max(1, $end_page - $max_pagination + 1);
                }

                // Koreksi jika halaman di akhir lebih sedikit dari jumlah yang ditentukan
                if ($end_page - $start_page + 1 < $max_pagination) {
                  $end_page = min($total_pages, $start_page + $max_pagination - 1);
                }
                ?>

                <!-- Tombol Previous -->
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                  <a class="page-link" href="?page=<?= max(1, $page - 1) ?>&limit=<?= $limit ?>&id_lokasi=<?= urlencode($id_lokasi) ?>&tanggal_mulai=<?= urlencode($tanggal_mulai) ?>&tanggal_akhir=<?= urlencode($tanggal_akhir) ?>&query=<?= urlencode($_GET['query'] ?? '') ?>" aria-label="Previous">&laquo;</a>
                </li>

                <!-- Halaman yang Ditampilkan -->
                <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                  <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>&id_lokasi=<?= urlencode($id_lokasi) ?>&tanggal_mulai=<?= urlencode($tanggal_mulai) ?>&tanggal_akhir=<?= urlencode($tanggal_akhir) ?>&query=<?= urlencode($_GET['query'] ?? '') ?>"><?= $i ?></a>
                  </li>
                <?php endfor; ?>

                <!-- Tombol Next -->
                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                  <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>&limit=<?= $limit ?>&id_lokasi=<?= urlencode($id_lokasi) ?>&tanggal_mulai=<?= urlencode($tanggal_mulai) ?>&tanggal_akhir=<?= urlencode($tanggal_akhir) ?>&query=<?= urlencode($_GET['query'] ?? '') ?>" aria-label="Next">&raquo;</a>
                </li>
              </ul>
            </nav>
          <?php endif; ?>


        </div>

        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab" style="padding-top: 20px;" style="padding-bottom: 10px;">
          <?php
          $folder = "proses/inventaris/qrcodes/ruang/"; // Pastikan ada trailing slash
          $kode = $id_lokasi;
          $filename = $folder . "inventaris_" . $nama_ruang . ".png";

          require_once('proses/qrcode/qrlib.php');
          QRcode::png($kode, $filename, "M", 10, 2);
          ?>
          <div class="d-flex justify-content-center mb-4">
            <div class="card" style="width: 300px; background-color: #f8f9fa; border: 1px solid #007bff;">
              <div class="card-body text-center">
                <h5 class="card-title" style="color: #007bff;">Inventaris <?= htmlspecialchars($nama_ruang) ?></h5>
                <img src="<?= $filename ?>" class="card-img-bottom" alt="QR Code" style="width: 100%; height: auto;">
              </div>
            </div><!-- End Card with an image on bottom -->
          </div>
        </div>
      </div>



</main>

<?php include("component/footer.php"); ?>