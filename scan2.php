<?php
include('component/header.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <script src="./node_modules/html5-qrcode/html5-qrcode.min.js"></script>
    <style>
        #qr-reader-barang,
        #qr-reader-kir {
            width: 100%;
            height: auto;
            margin-top: 10px;
        }

        @media (max-width: 768px) {

            #qr-reader-barang,
            #qr-reader-kir {
                aspect-ratio: 1 / 1;
                /* Kamera lebih persegi untuk layar kecil */
            }
        }

        @media (max-width: 400px) {

            #qr-reader-barang,
            #qr-reader-kir {
                aspect-ratio: 4 / 3;
                /* Untuk perangkat sangat kecil */
            }
        }
    </style>
</head>

<main id="main" class="main">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title " style="font-size: 17px !important;">Pindai QR Code</h5>
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100 active" id="scan-barang-tab" data-bs-toggle="tab" data-bs-target="#scan-barang" type="button" role="tab" aria-controls="scan-barang" aria-selected="true">Barang</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="scan-kir-tab" data-bs-toggle="tab" data-bs-target="#scan-kir" type="button" role="tab" aria-controls="scan-kir" aria-selected="false">KIR</button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content pt-2" id="myTabjustifiedContent">
                <!-- Tab for Barang -->
                <div class="tab-pane fade show active" id="scan-barang" role="tabpanel" aria-labelledby="scan-barang-tab">
                    <div id="qr-reader-barang"></div>
                </div>

                <!-- Tab for KIR -->
                <div class="tab-pane fade" id="scan-kir" role="tabpanel" aria-labelledby="scan-kir-tab">
                    <div id="qr-reader-kir"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const qrCodeScannerBarang = new Html5Qrcode("qr-reader-barang");
        const qrCodeScannerKir = new Html5Qrcode("qr-reader-kir");
        let currentScanner = null; // Untuk melacak scanner aktif

        // Fungsi untuk menghitung qrbox dan fps berdasarkan lebar layar
        function getScanParameters() {
            let qrbox = 400;
            let fps = 20;

            if (window.innerWidth <= 768) {
                qrbox = 150; // Ukuran qrbox lebih kecil untuk layar lebih kecil
                fps = 10; // Kurangi fps untuk menghemat sumber daya pada perangkat kecil
            } else if (window.innerWidth <= 400) {
                qrbox = 200; // Ukuran qrbox lebih kecil lagi untuk perangkat sangat kecil
                fps = 10; // Kurangi fps lebih jauh pada perangkat kecil
            }

            return {
                qrbox,
                fps
            };
        }

        // Start scanning function for Barang
        function startScanningBarang() {
            if (currentScanner !== qrCodeScannerBarang) { // Hanya start jika belum aktif
                if (currentScanner) {
                    currentScanner.stop().catch(() => {}); // Stop scanner lain
                }

                const {
                    qrbox,
                    fps
                } = getScanParameters(); // Dapatkan parameter berdasarkan ukuran layar

                qrCodeScannerBarang.start({
                        facingMode: "environment"
                    }, {
                        fps: fps,
                        qrbox: qrbox
                    },
                    function(qrCodeMessage) {
                        window.location.href = "detail_barang.php?id_barang_pemda=" + encodeURIComponent(qrCodeMessage);
                        qrCodeScannerBarang.stop();
                    },
                    function(errorMessage) {
                        console.log(errorMessage);
                    }
                ).catch(function(error) {
                    console.error(error);
                    alert("Error starting the camera. Please try again.");
                });

                currentScanner = qrCodeScannerBarang; // Set scanner aktif
            }
        }

        // Start scanning function for KIR
        function startScanningKir() {
            if (currentScanner !== qrCodeScannerKir) { // Hanya start jika belum aktif
                if (currentScanner) {
                    currentScanner.stop().catch(() => {}); // Stop scanner lain
                }

                const {
                    qrbox,
                    fps
                } = getScanParameters(); // Dapatkan parameter berdasarkan ukuran layar

                qrCodeScannerKir.start({
                        facingMode: "environment"
                    }, {
                        fps: fps,
                        qrbox: qrbox
                    },
                    function(qrCodeMessage) {
                        window.location.href = "inventaris_ruangan.php?id_lokasi=" + encodeURIComponent(qrCodeMessage);
                        qrCodeScannerKir.stop();
                    },
                    function(errorMessage) {
                        console.log(errorMessage);
                    }
                ).catch(function(error) {
                    console.error(error);
                    alert("Error starting the camera. Please try again.");
                });

                currentScanner = qrCodeScannerKir; // Set scanner aktif
            }
        }

        // Event listeners for switching tabs and managing scanners
        document.getElementById("scan-barang-tab").addEventListener("click", function() {
            startScanningBarang();
        });

        document.getElementById("scan-kir-tab").addEventListener("click", function() {
            startScanningKir();
        });

        // Automatically start scanning Barang on page load
        startScanningBarang();

        // Mendengarkan perubahan ukuran layar untuk memperbarui qrbox dan fps
        window.addEventListener('resize', function() {
            if (currentScanner) {
                currentScanner.stop().catch(() => {});
                if (currentScanner === qrCodeScannerBarang) {
                    startScanningBarang();
                } else if (currentScanner === qrCodeScannerKir) {
                    startScanningKir();
                }
            }
        });
    </script>
</main>

</html>
<?php
include('component/footer.php');
