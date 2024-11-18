<?php
ob_start();
session_start();
include('../../koneksi/koneksi.php');

// Ambil data lokasi
$id_lokasi = $_GET['id_lokasi'];
$sql_lokasi = "SELECT * FROM lokasi WHERE id_lokasi = '$id_lokasi'";
$result_lokasi = mysqli_query($conn, $sql_lokasi);
$rowlokasi = mysqli_fetch_assoc($result_lokasi);

// Ambil data barang
$sql_barang = "
    SELECT id_barang_pemda, kode_barang, no_regristrasi, tgl_pembelian, nama_barang, merk 
    FROM data_barang 
    WHERE id_ruang_sekarang = '$id_lokasi'
";
$result_barang = mysqli_query($conn, $sql_barang);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Barang <?php echo $rowlokasi['bid_lokasi']; ?></title>
    <style>
        @page {
            size: A4;
            margin: 20px;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            background-color: #f2f2f2;
        }

        .card {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .column {
            width: 48%;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        table {
            border: 1px solid black;
            width: 100%;
            margin-bottom: 10px;
        }

        th, td {
            border: 0.3 solid black;
            padding: 2px;
            text-align: center;
        }

        .qrcode {
            padding:0px;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

        .brebes-img img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .kode-barang {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="card">
        <?php
        require_once('../qrcode/qrlib.php');
        $folder = "qrcodes/barang";

        while ($row = mysqli_fetch_assoc($result_barang)) {
            $id_barang_pemda = $row['id_barang_pemda'];
            $kode_barang = $row['kode_barang'];
            $no_regristrasi = $row['no_regristrasi'];
            $tgl_pembelian = $row['tgl_pembelian'];
            $nama_barang = $row['nama_barang'];
            $merk = $row['merk'];
            
            $filename = "$folder/qrcode_" . $id_barang_pemda . "_" . $no_regristrasi . ".png";
            if (!file_exists($filename)) {
                QRcode::png($id_barang_pemda, $filename, "M", 12, 2);
            }
        ?>
            <div class="column">
                <table>
                <colgroup>
                        <col style="width: 25px;">
                        <col style="width: 250px;">
                        <col style="width: 10px;">
                        <col>
                    </colgroup>
                    <tbody>
                        <tr>
                            <td rowspan="4" class="brebes-img" style="vertical-align: middle;">
                                <img src="qrcodes/brebes.png" alt="Logo Brebes">
                                <br>
                                <span style="font-size: 10px; margin-top: 5px; display: inline-block;"><?php echo date('Y'); ?></span>
                            </td>
                            <td colspan="2" class="kode-barang" style="padding-bottom:3px"><?php echo $id_barang_pemda; ?></td>
                            <td rowspan="4" style="vertical-align: middle; width: 90px; height: 90px;">
                                <img src="<?php echo $filename; ?>" alt="QR Code" class="qrcode">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="kode-barang" style="vertical-align: top;"><?php echo $kode_barang; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: left; height:20px; padding-left: 5px"><?php echo $nama_barang; ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; font-size: 11.5px; padding-left: 5px"><?php echo $tgl_pembelian; ?></td>
                            <td style="font-size: 11.5px;"><?php echo $no_regristrasi; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</body>

</html>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;


$date = date('Y-m-d');

try {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="label_barang_' . $rowlokasi['bid_lokasi'] . '_' . $date . '.pdf"'); // Attachment untuk otomatis download

    $html2pdf = new Html2Pdf();
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);

    // Gunakan 'D' agar file otomatis ter-download
    $html2pdf->output('label_barang_' . $rowlokasi['bid_lokasi'] . '_' . $date . '.pdf', 'D');
} catch (Html2PdfException $e) {
    echo ExceptionFormatter::getHtmlMessage($e);
}

?>