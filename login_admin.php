<?php
session_start();
require_once 'koneksi/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Ruangku - Login Admin</title>

  <!-- Favicons -->
  <link href="images/favicon.png" rel="icon">
  <link href="images/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="css/style.css" rel="stylesheet">
  <!--<link href="css/kita.css" rel="stylesheet">-->

  <style>
    /* Gambar Background pada Body */
    body {
      background: rgba(179, 200, 207, 0.85) url('images/bg2.jpeg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      font-size: 13px;
    }

    /* Form Login dengan Latar Transparan */
    .register {
      background: rgba(255, 255, 255, 0.50);
      /* Background semi-transparan */
      padding: 20px;
      padding-top: 5px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .login {
      background: rgba(255, 255, 255, 0.69);
      /* Background semi-transparan */
      border-radius: 12px;
      padding: 20px;
      padding-top: 5px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .logo {
      background: rgba(255, 255, 255, 0);
      /* Background semi-transparan */
      border-radius: 12px;
      padding: 20px;
      padding-top: 5px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0);
    }

    /* Logo Styling */
    .logo img {
      max-height: 30px;
    }

    .copyright {
      font-size: 12px;
      text-align: center;
      padding-top: 20px;
    }

    /* Mengatur Input Field */
    button[type="submit"],
    input[type="text"],
    input[type="password"] {
      font-size: inherit;
      /* Mengikuti ukuran font dari body */
      border: 1px solid #ced4da;
      border-radius: 5px;
      padding: 5px 10px;
      /* Padding lebih kecil */
      height: 35px;
      /* Mengurangi tinggi input */
      width: 100%;
      box-sizing: border-box;
      /* Agar padding tidak menambah ukuran */
    }

    /* Styling untuk Input Group */
    .input-group-text {
      font-size: inherit;
      border: 1px solid #ced4da;
      border-radius: 5px 0 0 5px;
      height: 35px;
      /* Sama dengan tinggi input */
      padding: 5px 10px;
      /* Menyesuaikan padding */
    }

    .dinko-text {
      font-size: 1.2em;
      line-height: 1.2;
      color: #333;
      /* Warna default */
    }

    .dinko-text .highlight {
      color: #0d6efd;
    }
  </style>
</head>

<body>
  <main>
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <!-- Logo -->
            <div class="logo-container text-center py-1" style="padding-top: 0px;">
              <div class="logo d-flex align-items-center justify-content-center gap-1" style="padding-bottom: 5px;">
                <img src="images/logo.png" alt="Logo DinkoRoom" class="img-fluid">
                <span class="dinko-text">
                  Ruang<span class="highlight">Ku</span><br>
                </span>
              </div>
              <p>Dinkominfotik Kab. Brebes</p>
            </div>



            <!-- Card Login -->
            <!-- Card Login -->
            <div class="card mb-4 login">
              <div class="card-body">
                <div class="pt-3 pb-3">
                  <h5 class="card-title text-center" style="font-weight: 600; font-size: 18px !important;">Login Admin</h5>
                </div>


                <form action="proses/login.php" method="POST" class="row g-3 needs-validation" novalidate>
                  <div class="col-12">
                    <label for="yourUsername" class="form-label">Username</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text">@</span>
                      <input type="text" name="username" class="form-control" id="yourUsername" required>
                      <div class="invalid-feedback">Harap masukkan Username!</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="yourPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="yourPassword" required>
                    <div class="invalid-feedback">Harap masukkan Password!</div>
                  </div>

                  <div class="col-12" style="padding-top: 20px;">
                    <div class="d-flex justify-content-center">
                      <button class="btn btn-primary w-75" type="submit">Login</button>
                    </div>
                  </div>
                </form>


              </div>
            </div>

            <!-- Copyright -->
            <div class="copyright">
              &copy; 2024 <strong>Informatika UNIMUS</strong>
            </div>

          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Vendor JS Files -->
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>

</body>

</html>