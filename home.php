<?php
include('component/header.php');
include('koneksi/koneksi.php'); // Include the database connection

// KENDARAAN
$queryKendaraan = "SELECT COUNT(DISTINCT kategori) AS total_kendaraan FROM data_barang WHERE kategori = 'kendaraan'";
$resultKendaraan = mysqli_query($conn, $queryKendaraan);
$rowKendaraan = mysqli_fetch_assoc($resultKendaraan);
$totalKendaraan = $rowKendaraan['total_kendaraan'];

// RUANGAN
$queryRuang = "SELECT COUNT(*) AS total_ruang 
              FROM lokasi 
              WHERE LOWER(TRIM(kategori_lokasi)) = 'ruangan'";
$resultRuang = mysqli_query($conn, $queryRuang);

if (!$resultRuang) {
    die('Query Error: ' . mysqli_error($conn));
}

$rowRuang = mysqli_fetch_assoc($resultRuang);
$totalRuang = $rowRuang['total_ruang'];

// BARANG (Fasilitas Umum)
$queryBarang = "SELECT COUNT(*) AS total_barang FROM data_barang";
$resultBarang = mysqli_query($conn, $queryBarang);

if (!$resultBarang) {
    die('Query Error: ' . mysqli_error($conn));
}

$rowBarang = mysqli_fetch_assoc($resultBarang);
$totalBarang = $rowBarang['total_barang'];
?>

<body>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Fasilitas Umum Card -->
        <div class="col-xxl-3 col-md-4">
          <div class="card info-card customers-card">
            <div class="card-body-kita">
              <h5 class="card-title">Barang/Aset</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-box"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo $totalBarang; ?></h6>
                  <span class="text-muted small pt-2 ps-1">Barang/Aset</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Fasilitas Umum Card -->

        <!-- Kendaraan Card -->
        <div class="col-xxl-3 col-md-4">
          <div class="card info-card revenue-card">
            <div class="card-body-kita">
              <h5 class="card-title">Kendaraan</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-bus-front"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo $totalKendaraan; ?></h6>
                  <span class="text-muted small pt-2 ps-1">Kendaraan</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Kendaraan Card -->

        <!-- Ruangan Card -->
        <div class="col-xxl-3 col-md-4">
          <div class="card info-card sales-card">
            <div class="card-body-kita">
              <h5 class="card-title">Ruangan</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-house-door"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo $totalRuang; ?></h6>
                  <span class="text-muted small pt-2 ps-1">Ruang</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Ruangan Card -->

      </div><!-- End Row -->
    </section>

</main>
<?php include('component/footer.php'); ?>
