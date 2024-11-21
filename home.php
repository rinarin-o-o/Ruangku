<?php
include('component/header.php');
include('proses/dashboard/get_data.php');
?>

<body>
<main id="main" class="main">
<div class="floating-button">
    <a href="scan2.php">
        <i class="bi bi-camera-fill" title="Pindai QR Code"></i>
    </a>
</div>

    <div class="pagetitle">
      <h1>Dashboard</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Barang -->
        <div class="col-xxl-3 col-md-4">
          <div class="card info-card customers-card">
            <div class="card-body-kita">
              <h5 class="card-title">Barang</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-box"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo $totalBarang; ?></h6>
                  <span class="text-muted small pt-2 ps-1">Barang</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Barang -->
        <!-- Kendaraan -->
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
        </div><!-- End Kendaraan -->
        <!-- Ruangan -->
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
        </div><!-- End Ruangan -->

      </div><!-- End Row -->
    </section>

</main>
<?php include('component/footer.php'); ?>
