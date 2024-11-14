<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>QR Code Scanner</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <script src="./node_modules/html5-qrcode/html5-qrcode.min.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f7f7f7;
        }

        .scanner-container {
            text-align: center;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        #qr-reader {
            width: 100%;
            height: 300px;
        }

        .qr-result {
            margin-top: 20px;
            font-size: 1.2em;
            color: #333;
        }

        .btn-start-scan {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-start-scan:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="scanner-container">
        <h2>Scan QR Code</h2>
        <div id="qr-reader"></div>
        <button class="btn-start-scan" id="start-scan-btn">Start Scanning</button>
        <div class="qr-result" id="result"></div>
    </div>

    <script>
        // Initialize the QR Code scanner
        const qrCodeScanner = new Html5Qrcode("qr-reader");

        // Start scanning when the button is clicked
        document.getElementById("start-scan-btn").addEventListener("click", function() {
            qrCodeScanner.start(
                { facingMode: "environment" }, // Use the rear camera
                {
                    fps: 10, // Scan at 10 frames per second
                    qrbox: 250 // Set the scanning box size
                },
                function(qrCodeMessage) {
                    // Display the scanned result
                    document.getElementById("result").innerText = "Scanned QR Code: " + qrCodeMessage;
                    qrCodeScanner.stop(); // Stop scanning after successful scan
                },
                function(errorMessage) {
                    // Handle scanning errors
                    console.log(errorMessage);
                }
            ).catch(function(error) {
                console.error(error);
                alert("Error starting the camera. Please try again.");
            });
        });
    </script>

</body>
</html>
