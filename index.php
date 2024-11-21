<?php
include('koneksi/koneksi.php'); // Include the database connection

// KENDARAAN
$queryKendaraan = "SELECT COUNT(DISTINCT kategori) AS total_kendaraan 
                   FROM data_barang 
                   WHERE kategori = 'kendaraan'";
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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Ruangku - Dinkominfotik</title>
  <meta name="description" content="">
  <meta name="keywords" content="">


  <!-- Favicons -->
  <link href="assets/assets/img/logo.png" rel="icon">
  <link href="assets/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/assets/css/main.css" rel="stylesheet">
  <style>
    .hero-content {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .floating-button {
      position: fixed;
      bottom: 60px;
      /* Jarak dari bawah */
      right: 25px;
      /* Jarak dari kanan */
      z-index: 1000;
      /* Pastikan di atas elemen lain */
      background-color: #007bff;
      /* Warna tombol */
      border-radius: 50%;
      /* Membuat tombol bulat */
      width: 60px;
      /* Lebar tombol */
      height: 60px;
      /* Tinggi tombol */
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
      /* Efek bayangan */
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-bottom: 20px;
    }

    .info-card .card-body {
      padding: 20px;
      text-align: center;
    }

    .info-card .card-title {
      font-size: 18px;
      font-weight: bold;
      color: #333;
      margin-bottom: 10px;
    }

    .info-card .card-icon {
      width: 50px;
      height: 50px;
      background: #f1f1f1;
      color: #555;
      font-size: 24px;
      margin-right: 15px;
    }

    .info-card .card-icon i {
      line-height: 50px;
    }

    .info-card h6 {
      font-size: 24px;
      font-weight: bold;
      color: #007bff;
    }

    .info-card .text-muted {
      font-size: 12px;
      color: #888;
    }


    .floating-button:hover {
      background-color: #0056b3;
      /* Warna saat hover */
      transform: scale(1.1);
      /* Perbesar sedikit saat hover */
    }

    .floating-button i {
      font-size: 24px;
      /* Ukuran ikon */
      color: white;
      /* Warna ikon */
    }
  </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="#" class="logo d-flex align-items-center me-auto me-xl-0">
        <img src="assets/assets/img/logo.png" alt="">
        <h1 class="sitename" style="font: weight 200px;">Ruang<span style="color: #72a7df;">Ku</span></h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#about">Tentang</a></li>
          <li><a href="#features">Fitur</a></li>
          <li><a href="#testimonial">Data</a></li>
          <li><a href="#contact">Kontak</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="login_admin.php">Login</a>

    </div>
  </header>

  <main class="main">

    <div class="floating-button">
      <a href="scan.php">
        <i class="bi bi-camera-fill" title="Scan QRCODE"></i>
      </a>
    </div>

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-content" data-aos="fade-up" data-aos-delay="200">

              <h1 class="mb-4">
                Selamat Datang <br>di <br>
                <span>Ruang<span style="color: #72a7df;">Ku</span></span>
              </h1>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
              <img src="assets/assets/img/itong.png" alt="Hero Image" class="img-fluid">
            </div>
          </div>
        </div>


      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 align-items-center justify-content-between">

          <div class="col-xl-5" data-aos="fade-up" data-aos-delay="200" style="text-align: justify;">
            <span class="about-meta">Tentang</span>
            <h2 class="about-title">Apa itu Ruang<span style="color: #72a7df;">Ku</span><span>?</span></h2>
            <p class="about-description">
              RuangKu adalah aplikasi berbasis web yang dirancang untuk membantu pengelolaan aset kelompok peralatan dan mesin di Dinas Komunikasi, Informatika, dan Statistik Kabupaten Brebes. Aplikasi ini hadir untuk mempermudah pencatatan dan pelacakan aset agar lebih praktis dan terorganisir. Dengan teknologi seperti pemindaian QR Code, RuangKu membuat proses inventarisasi jadi lebih cepat dan mudah, tanpa perlu repot dengan dokumen manual.
            </p>
          </div>


          <div class="col-xl-6" data-aos="fade-up" data-aos-delay="300">
            <div class="image-wrapper">
              <div class="images position-relative" data-aos="zoom-out" data-aos-delay="400">
                <img src="assets/assets/img/about-5.jpeg" alt="Business Meeting" class="img-fluid main-image rounded-4">
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Features Section -->
    <section id="features" class="features section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Fitur</h2>
      </div><!-- End Section Title -->
      <section id="features-cards" class="features-cards section">
        <div class="container">
          <div class="row gy-4">
            <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
              <div class="feature-box orange">
                <i class="bi bi-gear"></i>

                <h4>Mempermudah Pengelolaan Aset</h4>
                <p>Mencatat dan memantau aset dengan lebih rapi dan efisien.</p>
              </div>
            </div><!-- End Feature Box-->

            <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
              <div class="feature-box blue">
                <i class="bi bi-qr-code"></i>
                <h4>Memanfaatkan Teknologi Modern</h4>
                <p>Menggunakan fitur QR Code untuk inventarisasi ruangan dan mempermudah pelacakan barang.</p>
              </div>
            </div><!-- End Feature Box-->

            <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
              <div class="feature-box green">
                <i class="bi bi-easel"></i>
                <h4>Mudah dan Efisien</h4>
                <p>Proses inventaris jadi lebih cepat tanpa perlu banyak langkah yang rumit.</p>
              </div>
            </div><!-- End Feature Box-->
          </div>
        </div>
      </section><!-- /Features Cards Section -->


    </section><!-- /Features Section -->

    <!-- Testimonials Section -->
    <section id="testimonial" class="testimonials section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Data</h2>
      </div><!-- End Section Title -->
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <!-- Barang/Aset Card -->
          <div class="col-xxl-3 col-md-4">
            <div class="card info-card customers-card">
              <div class="card-body-kita">
                <h5 class="card-title">Barang/Aset</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: #007bff;">
                    <i class="bi bi-box" style="color: white;"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo $totalBarang; ?></h6>
                    <span class="text-muted small pt-2 ps-1">Barang/Aset</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Barang/Aset Card -->

          <!-- Kendaraan Card -->
          <div class="col-xxl-3 col-md-4">
            <div class="card info-card revenue-card">
              <div class="card-body-kita">
                <h5 class="card-title">Kendaraan</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: #28a745;">
                    <i class="bi bi-bus-front" style="color: white;"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo $totalKendaraan; ?></h6>
                    <span class="text-muted small pt-2 ps-1">Kendaraan</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Kendaraan Card -->

          <!-- Ruangan Card -->
          <div class="col-xxl-3 col-md-4">
            <div class="card info-card sales-card">
              <div class="card-body-kita">
                <h5 class="card-title">Ruangan</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: #ffc107;">
                    <i class="bi bi-house-door" style="color: white;"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo $totalRuang; ?></h6>
                    <span class="text-muted small pt-2 ps-1">Ruang</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Ruangan Card -->

        </div>


      </div>

    </section>
    </section><!-- /Testimonials Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Kontak</h2>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4 g-lg-5">
          <div class="col-lg-5">
            <div class="info-box" data-aos="fade-up" data-aos-delay="200">

              <div class="info-item" data-aos="fade-up" data-aos-delay="300">
                <div class="icon-box">
                  <i class="bi bi-geo-alt"></i>
                </div>
                <div class="content">
                  <h4>Lokasi</h4>
                  <p>Jl. MT Haryono Jl. Saditan Baru No.76, RW.01, Saditan, Brebes,</p>
                  <p>Kec. Brebes, Kabupaten Brebes, Jawa Tengah 52212</p>
                </div>
              </div>

              <div class="info-item" data-aos="fade-up" data-aos-delay="400">
                <div class="icon-box">
                  <i class="bi bi-telephone"></i>
                </div>
                <div class="content">
                  <h4>Phone</h4>
                  <p>(0283) 672907</p>
                </div>
              </div>

              <div class="info-item" data-aos="fade-up" data-aos-delay="500">
                <div class="icon-box">
                  <i class="bi bi-envelope"></i>
                </div>
                <div class="content">
                  <h4>Email</h4>
                  <p>dinkominfotik@brebeskab.go.id</p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="contact-form">
              <h3>Hubungi Kami</h3>
              <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, kami siap membantu Anda. Jangan ragu untuk menghubungi kami kapan saja.</p>

              <form id="emailForm" onsubmit="sendEmail(); return false;">
                <div class="row gy-4">

                  <div>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nama" required>
                  </div>

                  <div>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                  </div>

                  <div>
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subjek" required>
                  </div>

                  <div>
                    <textarea class="form-control" name="message" id="message" rows="6" placeholder="Pesan" required></textarea>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn">Kirim</button>
                  </div>

                </div>
              </form>
            </div>
          </div>

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer">
    <div class="container footer-top">
      <div class="row gy-4">
        <!-- Informasi Kontak -->
        <div class="col-lg-6 col-md-6 footer-about">
          <a href="#" class="logo d-flex align-items-center">
            <span class="sitename">Ruangku</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Dinas Komunikasi Informatika dan Statistika</p>
            <p>Jl. MT Haryono No. 76 Brebes - 52212</p>
            <p class="mt-3"><strong>Phone:</strong> <span>(0283) 672907</span></p>
            <p><strong>Email:</strong> <span>dinkominnfotik@brebeskab.go.id</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="https://twitter.com/pemkab_brebes"><i class="bi bi-twitter-x"></i></a>
            <a href="https://www.facebook.com/dinaskominfotik.brebes"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/dinkominfotik.brebes?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="bi bi-instagram"></i></a>
            <a href="https://www.youtube.com/@HBtvku"><i class="bi bi-youtube"></i></a>
          </div>
        </div>

        <!-- Google Maps -->
        <div class="col-lg-6 col-md-6">
          <div class="map-container" style="height: 300px; border-radius: 10px; overflow: hidden;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.634239616585!2d109.0277981141409!3d-7.201891272473284!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fd7c0ba97bb45%3A0x342231017c2d70c!2sJl.%20MT.%20Haryono%20No.76%2C%20Brebes%2C%20Kabupaten%20Brebes%2C%20Jawa%20Tengah%2052212!5e0!3m2!1sen!2sid!4v1693393429167!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <div class="container copyright text-center mt-4">
      &copy; 2024 <strong><span>Informatika UNIMUS</span></strong>
      <span> - </span>
      <strong><span>Dinkominfotik Brebes</span></strong>
    </div>
  </footer>


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/assets/vendor/aos/aos.js"></script>
  <script src="assets/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="assets/assets/js/main.js"></script>

  <script>
    function sendEmail() {
      // Ambil nilai dari input form
      const name = document.getElementById('name').value;
      const subject = document.getElementById('subject').value;
      const message = document.getElementById('message').value;

      // Buat URL mailto
      const mailtoLink = `mailto:arohasarinah@gmail.com?subject=${encodeURIComponent(subject)}&body=Name: ${encodeURIComponent(name)}%0A%0A${encodeURIComponent(message)}`;

      // Buka tautan di Gmail
      window.location.href = mailtoLink;
    }
  </script>

</body>

</html>