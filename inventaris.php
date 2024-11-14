<?php
include('koneksi/koneksi.php'); // Include DB connection
include("component/header.php");

// Fetch room data
$query = "
    SELECT *
    FROM lokasi
    WHERE kategori_lokasi = 'Ruangan'
";

$result = mysqli_query($conn, $query);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Inventaris Ruang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
                <li class="breadcrumb-item">Inventaris</li>
                <li class="breadcrumb-item active">Inventaris Ruang</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="card">
        <div class="card-body">
            <div class="col-lg-12" style="padding-top: 30px;">
                <div class="row">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id_lokasi = $row['id_lokasi'];
                            $nama_ruang = $row['bid_lokasi'];
                    ?>
                            <div class="col-xxl-5 col-md-3 mb-4">
                                <a href="inventaris_ruangan.php?id_lokasi=<?php echo urlencode($id_lokasi); ?>">
                                    <div class="card info-card sales-card h-100" style="background-color: #ffffff; border: 1px solid #7eb4e3; box-shadow: 2px 5px 2px rgba(0, 0, 0, 0.2);">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center me-3">
                                                    <i class="bi bi-house-door" style="font-size: 1.5rem !important; color:#53a1e5 !important;"></i> <!-- Sesuaikan ukuran -->
                                                </div>


                                                <div>
                                                    <p class="card-title mb-0 small-font" style="font-size: 14px; color: #000000;">
                                                        <?php echo htmlspecialchars($id_lokasi) . ' - ' . htmlspecialchars($nama_ruang); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </a>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p>Tidak ada ruangan yang ditemukan</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include("component/footer.php"); ?>