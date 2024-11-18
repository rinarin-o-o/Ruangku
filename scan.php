<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code</title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            background-color: #000;
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .container {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            z-index: 100;
        }

        #qrResult {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 18px;
            font-weight: bold;
            color: lime;
            z-index: 101;
        }

        #errorMessage {
            position: absolute;
            top: 60px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 16px;
            color: red;
            z-index: 101;
        }

        .scan-box {
            border: 2px solid lime;
            position: absolute;
            z-index: 101;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <video id="camera" autoplay></video>
    <canvas id="canvas"></canvas>
    <div class="container">
        <p id="qrResult">Mencari QR Code...</p>
        <p id="errorMessage"></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>

    <script>
        const videoElement = document.getElementById('camera');
        const canvasElement = document.getElementById('canvas');
        const canvasContext = canvasElement.getContext('2d');
        const qrResult = document.getElementById('qrResult');
        const errorMessage = document.getElementById('errorMessage');

        // Setting up video stream
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then((stream) => {
                videoElement.srcObject = stream;
                videoElement.play();
                requestAnimationFrame(scanQRCode); // Start scanning once video is playing
            })
            .catch((error) => {
                console.error('Error accessing camera:', error);
                errorMessage.textContent = "Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan.";
            });

        // Function to scan QR Code from video stream
        function scanQRCode() {
            if (videoElement.readyState === videoElement.HAVE_ENOUGH_DATA) {
                // Set canvas size equal to video feed size
                canvasElement.width = videoElement.videoWidth;
                canvasElement.height = videoElement.videoHeight;

                // Draw the current video frame onto the canvas
                canvasContext.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);

                // Get the image data from the canvas
                const imageData = canvasContext.getImageData(0, 0, canvasElement.width, canvasElement.height);
                const code = jsQR(imageData.data, canvasElement.width, canvasElement.height);

                if (code) {
                    // If QR Code is detected, display the result
                    qrResult.textContent = 'QR Code ditemukan: ' + code.data;

                    // Draw the QR Code location on the canvas
                    canvasContext.beginPath();
                    canvasContext.lineWidth = 10;
                    canvasContext.strokeStyle = 'lime';
                    canvasContext.rect(code.getBoundingBox().topLeft.x, code.getBoundingBox().topLeft.y,
                        code.getBoundingBox().bottomRight.x - code.getBoundingBox().topLeft.x,
                        code.getBoundingBox().bottomRight.y - code.getBoundingBox().topLeft.y);
                    canvasContext.stroke();

                    // Process the QR Code data
                    cekQRCode(code.data);
                } else {
                    // If no QR Code is found, continue scanning
                    qrResult.textContent = 'Mencari QR Code...';
                }
            }
            requestAnimationFrame(scanQRCode); // Continue scanning
        }

        function cekQRCode(qrData) {
            console.log('QR Code yang dideteksi:', qrData); // Log QR Code yang ditemukan
            fetch(`cek_qrcode.php?qrcode=${encodeURIComponent(qrData)}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Respons dari server:', data); // Log respons dari server
                    if (data.isLocation) {
                        console.log('Arahkan ke qrcode_inventaris.php');
                        window.location.href = `qrcode_inventaris.php?id_lokasi=${data.id_lokasi}`;
                    } else if (data.isItem) {
                        console.log('Arahkan ke qrcode_detail_barang.php');
                        window.location.href = `qrcode_detail_barang.php?id_barang_pemda=${data.id_barang_pemda}`;
                    } else {
                        console.log('QR Code tidak valid.');
                        qrResult.textContent = "QR Code tidak valid.";
                    }
                })
                .catch(error => {
                    console.error('Kesalahan saat memeriksa QR Code:', error);
                    qrResult.textContent = "Terjadi kesalahan saat memproses QR Code.";
                });
        }
    </script>
</body>

</html>