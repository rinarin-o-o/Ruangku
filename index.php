<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Ruangku - Dinkominfotik</title>
  <meta name="description" content="Aplikasi inventarisasi untuk pengelolaan aset di Dinas Komunikasi, Informatika, dan Statistik Kabupaten Brebes.">
  <meta name="keywords" content="Inventarisasi, Aset, Dinkominfotik, Kabupaten Brebes">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- Custom Styles -->
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #555;
    }

    .header {
      background: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: fixed;
      width: 100%;
      z-index: 1000;
      transition: all 0.3s;
    }

    .logo .sitename {
      font-weight: 700;
      color: #4CAF50;
    }

    .navmenu {
      margin-left: auto;
    }

    .navmenu ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    .navmenu ul li {
      position: relative;
    }

    .navmenu ul li a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
      transition: color 0.3s;
    }

    .navmenu ul li a:hover {
      color: #4CAF50;
    }


    .hero {
  position: relative;
  padding-top: 100px;
  padding-bottom: 60px;
  background-image: url('assets/img/gedung.png'); /* Ganti dengan path gambar yang baru */
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  color: white;
  z-index: 2; /* Agar konten tetap di atas overlay */
}

/* Overlay untuk filter blur putih */
.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.6); /* Putih transparan */
  backdrop-filter: blur(10px); /* Menambahkan efek blur */
  z-index: -1; /* Menurunkan z-index overlay agar konten di atasnya */
}

    .hero h1 {
      font-size: 3rem;
      color: #333;
      margin-bottom: 20px;
    }

    .hero p {
      font-size: 1.2rem;
      color: #555;
      margin-bottom: 30px;
    }

    .btn-get-started {
      background-color: #4CAF50;
      color: #fff;
      padding: 12px 25px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 600;
      transition: background-color 0.3s;
      margin-right: 15px;
    }

    .btn-get-started:hover {
      background-color: #45a049;
    }

    .btn-watch-video {
      display: flex;
      align-items: center;
      background-color: #fff;
      color: #4CAF50;
      padding: 12px 25px;
      border: 2px solid #007bff;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 600;
      transition: background-color 0.3s, color 0.3s;
    }

    .btn-watch-video:hover {
      background-color: #4CAF50;
      color: #fff;
    }

    .scroll-top {
      background: #4CAF50;
      color: #fff;
      border-radius: 50%;
      width: 45px;
      height: 45px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: fixed;
      bottom: 30px;
      right: 30px;
      opacity: 0.7;
      transition: opacity 0.3s;
      z-index: 1000;
    }

    .scroll-top:hover {
      opacity: 1;
      background: #45a049;
    }

    .preloader {
      background: #fff;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .preloader #preloader {
      border: 5px solid #f3f3f3;
      border-top: 5px solid #4CAF50;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2.5rem;
      }

      .hero p {
        font-size: 1rem;
      }

      .navmenu ul {
        flex-direction: column;
        background: #fff;
        position: absolute;
        top: 60px;
        right: 0;
        width: 200px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        display: none;
      }

      .navmenu ul.active {
        display: flex;
      }

      .mobile-nav-toggle {
        display: block;
        cursor: pointer;
        font-size: 1.5rem;
        color: #333;
      }
    }

    /* Tombol Scan */
#scan-btn {
  position: fixed;
  width: 50px; /* Ukuran tombol */
  height: 50px; /* Ukuran tombol */
  bottom: 77px; /* Posisi tombol di bawah */
  right: 20px;  /* Posisi tombol di sebelah kanan */
  background-color: #007bff; /* Ganti dengan warna sesuai desain */
  padding: 10px 20px;
  border-radius: 50%;
  color: white;
  font-size: 20px;
  z-index: 999; /* Pastikan tombol tetap di atas konten lain */
  display: flex;
  justify-content: center;
  align-items: center;
}


/* Tombol Scroll Top */
#scroll-top {
  position: fixed;
  bottom: 29px; /* Posisi tombol di bawah */
  right: 22px;  /* Posisi tombol di sebelah kanan */
  background-color: #007bff; /* Ganti dengan warna sesuai desain */
  padding: 10px 20px;
  border-radius: 50%;
  color: white;
  font-size: 20px;
  z-index: 999; /* Pastikan tombol tetap di atas konten lain */
}

  </style>
</head>

<body class="index-page">

  <!-- Preloader -->
  <div class="preloader" id="preloader">
    <div id="preloader"></div>
  </div>

  <header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="#" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Ruangku</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        <ul>
          <li><a href="#hero">Home</a></li>
          <li><a href="#features">Features</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="main">

          <section id="hero" class="hero section">
          <div class="container">
            <div class="row gy-4 align-items-center">
              <div class="col-lg-6 order-2 order-lg-1" data-aos="fade-right">
                <h1>Ruangku</h1>
                <p>Aplikasi inventarisasi untuk pengelolaan aset di Dinas Komunikasi, Informatika, dan Statistik Kabupaten Brebes.</p>
                <div class="d-flex">
                  <a href="../Admin/login_admin.php" class="btn-get-started">masuk sebagai admin</a>
                  <a href="../user/home_user.php" class="btn-get-started">masuk sebagai tamu</a>
                  <a href="scan.php" class="btn-get-started">Scan</a>
                </div>
              </div>
              <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
                <img src="assets/img/bebek.png" class="img-fluid animated" alt="Hero Image">
              </div>
            </div>
          </div>
          <!-- Overlay untuk filter blur putih -->
          <div class="hero-overlay"></div>
        </section><!-- /Hero Section -->



    <!-- Additional Sections (Features, About, Contact) -->
    <section id="features" class="features section">
      <div class="container">
        <div class="section-header" data-aos="fade-up">
          <h2>Fitur Utama</h2>
          <p>Beberapa fitur unggulan dari aplikasi Ruangku.</p>
        </div>
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="icon-box">
              <i class="bi bi-box-seam"></i>
              <h3>Manajemen Aset</h3>
              <p>Mengelola data aset secara efektif dan efisien.</p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box">
              <i class="bi bi-bar-chart"></i>
              <h3>Pelaporan</h3>
              <p>Membuat laporan aset dengan berbagai format.</p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="icon-box">
              <i class="bi bi-shield-lock"></i>
              <h3>Keamanan Data</h3>
              <p>Menjaga keamanan dan kerahasiaan data aset.</p>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Features Section -->

    <section id="about" class="about section">
      <div class="container">
        <div class="row gy-4 align-items-center">
          <div class="col-lg-6" data-aos="fade-right">
            <img src="assets/img/unimus.png" class="img-fluid" alt="About Image">
          </div>
          <div class="col-lg-6" data-aos="fade-left">
            <h2>Tentang Ruangku</h2>
            <p>Ruangku adalah aplikasi yang dirancang khusus untuk membantu Dinas Komunikasi, Informatika, dan Statistik Kabupaten Brebes dalam mengelola aset secara terstruktur dan efisien.</p>
            <ul>
              <li><i class="bi bi-check-circle"></i> Pengelolaan aset yang mudah dan cepat.</li>
              <li><i class="bi bi-check-circle"></i> Integrasi dengan sistem lain.</li>
              <li><i class="bi bi-check-circle"></i> Dukungan teknis 24/7.</li>
            </ul>
          </div>
        </div>
      </div>
    </section><!-- /About Section -->

    <section id="contact" class="contact section">
      <div class="container">
        <div class="section-header" data-aos="fade-up">
          <h2>Hubungi Kami</h2>
          <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi kami.</p>
        </div>
         <div class="row gy-4">
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
        <div class="info-box">
          <i class="bi bi-geo-alt"></i>
          <h3>Alamat</h3>
          <p>Jl. MT Haryono Jl. Saditan Baru No.76, RW.01, Saditan, Brebes, Kec. Brebes, Kabupaten Brebes, Jawa Tengah 52212</p>
          <!-- Google Maps Iframe -->
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3409.2318623268425!2d109.04513!3d-6.878082999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fbba01cf899f3%3A0x267b1ae3742d444e!2sDINKOMINFOTIK%20BREBES!5e1!3m2!1sid!2sid!4v1731555712084!5m2!1sid!2sid" width="1340" height="580" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </section><!-- /Contact Section -->
    
<!-- Additional Sections (About, Contact) -->
<section id="contact" class="contact section">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="info-box">
          <i class="bi bi-envelope"></i>
          <h3>Email</h3>
          <p>dinkominfotik@brebeskab.go.id</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="info-box">
          <i class="bi bi-phone"></i>
          <h3>Telepon</h3>
          <p>(0283) 672907</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="info-box">
          <i class="bi bi-clock"></i>
          <h3>Jam Operasional</h3>
          <p>Senin - Jumat: 07.00 - 16.00 WIB</p>
        </div>
      </div>
    </div>
  </div>
</section><!-- /Contact Section -->

<!-- Footer Section -->
<footer id="footer" class="footer">
  <div class="footer-top" style="background-color: #007bff;">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-6 col-md-6">
          <h3 style="color: #fff;">Ruangku</h3>
          <p style="color: #fff;">Terima kasih telah menggunakan aplikasi Ruangku. Kami berkomitmen untuk membantu pengelolaan aset yang lebih baik dan efisien di Dinas Komunikasi, Informatika, dan Statistik Kabupaten Brebes.</p>
        </div>
        <div class="col-lg-3 col-md-6">
          <h4 style="color: #fff;">Kontak</h4>
          <ul class="list-unstyled">
            <li><i class="bi bi-geo-alt"></i>Jl. MT Haryono Jl. Saditan Baru No.76, RW.01, Saditan, Brebes, Kec. Brebes, Kabupaten Brebes, Jawa Tengah 52212</li>
            <li><i class="bi bi-envelope"></i> info@dinkominfotik.brebes.go.id</li>
            <li><i class="bi bi-phone"></i> (0283) 672907 </li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6">
          <h4 style="color: #fff;">Ikuti Kami</h4>
          <ul class="social-links list-unstyled">
            <li><a href="https://www.facebook.com/dinaskominfotik.brebes" class="bi bi-facebook" target="_blank" style="color: #fff;"> Facebook</a></li>
            <li><a href="https://twitter.com/pemkab_brebes" class="bi bi-twitter" target="_blank" style="color: #fff;"> Twitter</a></li>
            <li><a href="https://www.instagram.com/dinkominfotik.brebes?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="bi bi-instagram" target="_blank" style="color: #fff;"> Instagram</a></li>
            <li><a href="https://wa.me/+628164885500" class="bi bi-whatsapp" target="_blank" style="color: #fff;"> Whatsapp</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  
  <div class="footer-bottom text-center py-4" style="background-color: #333;">
    <p style="color: #fff;">&copy;2024 Dinas Komunikasi, Informatika, dan Statistik Kabupaten Brebes</p>
  </div>
</footer><!-- /Footer Section -->



<!-- Tombol Scan (hanya ikon kamera) -->
<a href="scan.php" class="glightbox btn-watch-video d-flex align-items-center" id="scan-btn">
  <i class="bi bi-camera"></i>
</a>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>


  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- Initialize AOS -->
  <script>
    AOS.init({
      duration: 800,
      easing: 'slide',
      once: true
    });

    // Toggle Mobile Menu
    document.querySelector('.mobile-nav-toggle').addEventListener('click', function () {
      document.querySelector('.navmenu ul').classList.toggle('active');
    });

    // Preloader
    window.addEventListener('load', function () {
      document.querySelector('.preloader').style.display = 'none';
    });
  </script>

</body>

</html>
