<?php
$pdf_file = 'assets/UTS TBO.pdf';

if (isset($_GET['download']) && $_GET['download'] === 'true') {
    // Periksa apakah file PDF ada di server
    if (file_exists($pdf_file)) {
        // Set header untuk memaksa browser mengunduh file
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($pdf_file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($pdf_file));
        readfile($pdf_file);
        exit;
    } else {
        echo 'File tidak ditemukan.';
    }
}
?>

<!DOCTYPE html>
<?php include("component/header.php"); ?>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Umum</title>
    <link rel="stylesheet" href="styles.css"> <!-- Ganti dengan path ke file CSS Anda -->
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .card-header {
            font-size: 1.5em;
            font-weight: bold;
        }

        .card-body {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin-bottom: 20px;
        }

        iframe {
            width: 70%;
            height: 600px;
            border: none;
            max-width: 70%;
        }

        .download-btn {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .download-btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .card-header {
                font-size: 1.2em;
            }

            iframe {
                height: 600px;
            }

            .download-btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            iframe {
                height: 300px;
            }
        }
    </style>
</head>

<body>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Panduan Penggunaan Ruangku</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Panduan Penggunaan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- Card preview PDF -->
        <div class="card">
            <div class="card-header">Pratinjau</div>
            <form method="get" action="panduan_umum.php" style="margin-top: 20px;">
                <button type="submit" name="download" value="true" class="btn btn-primary btn-sm">
                    <i class="bi bi-download"></i> Unduh File
                </button>
            </form>
            <div class="card-body">
                <!-- Iframe untuk menampilkan preview PDF -->
                <iframe src="assets/UTS TBO.pdf#view=FitH"></iframe>
            </div>
        </div>
    </main>
</body>
<?php include("component/footer.php"); ?>

</html>