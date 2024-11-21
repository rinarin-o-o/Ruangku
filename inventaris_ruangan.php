<?php
include("component/header.php");
include("proses/inventaris/get data/get_inventaris_ruangan.php");
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
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="kir-tab" data-bs-toggle="tab" data-bs-target="#kir" type="button" role="tab" aria-controls="kir" aria-selected="true">Daftar Barang / Aset</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="qrcode-tab" data-bs-toggle="tab" data-bs-target="#qrcode" type="button" role="tab" aria-controls="qrcode" aria-selected="false">QRCode</button>
        </li>
      </ul>

      <div class="tab-content pt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="kir" role="tabpanel" aria-labelledby="kir-tab">
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
                $no = $start + 1;
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
                  <?php $no++; ?>
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
                $max_pagination = 5;
                $half_range = floor($max_pagination / 2);
                $start_page = max(1, $page - $half_range);
                $end_page = min($total_pages, $page + $half_range);
                if ($end_page - $start_page + 1 < $max_pagination) {
                  $start_page = max(1, $end_page - $max_pagination + 1);
                }
                if ($end_page - $start_page + 1 < $max_pagination) {
                  $end_page = min($total_pages, $start_page + $max_pagination - 1);
                }
                ?>
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                  <a class="page-link" href="?page=<?= max(1, $page - 1) ?>&limit=<?= $limit ?>&id_lokasi=<?= urlencode($id_lokasi) ?>&tanggal_mulai=<?= urlencode($tanggal_mulai) ?>&tanggal_akhir=<?= urlencode($tanggal_akhir) ?>&query=<?= urlencode($_GET['query'] ?? '') ?>" aria-label="Previous">&laquo;</a>
                </li>
                <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                  <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>&id_lokasi=<?= urlencode($id_lokasi) ?>&tanggal_mulai=<?= urlencode($tanggal_mulai) ?>&tanggal_akhir=<?= urlencode($tanggal_akhir) ?>&query=<?= urlencode($_GET['query'] ?? '') ?>"><?= $i ?></a>
                  </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                  <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>&limit=<?= $limit ?>&id_lokasi=<?= urlencode($id_lokasi) ?>&tanggal_mulai=<?= urlencode($tanggal_mulai) ?>&tanggal_akhir=<?= urlencode($tanggal_akhir) ?>&query=<?= urlencode($_GET['query'] ?? '') ?>" aria-label="Next">&raquo;</a>
                </li>
              </ul>
            </nav>
          <?php endif; ?>

        </div> <!-- end tab kir -->

        <div class="tab-pane fade" id="qrcode" role="tabpanel" aria-labelledby="qrcode-tab" style="padding-top: 20px;" style="padding-bottom: 10px;">
          <?php
          $folder = "proses/inventaris/qrcodes/ruang/";
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
            </div>
          </div>
        </div> <!-- end tab qrcode -->
      </div>
</main>
<?php include("component/footer.php"); ?>