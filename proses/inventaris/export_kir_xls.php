<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

session_start();
include('../../koneksi/koneksi.php');

// Ambil data lokasi
$id_lokasi = $_GET['id_lokasi'];
$sql_lokasi = "SELECT * FROM lokasi WHERE id_lokasi = '$id_lokasi'";
$result_lokasi = mysqli_query($conn, $sql_lokasi);
$rowlokasi = mysqli_fetch_assoc($result_lokasi);

$templateFile = 'KIR_TEMPLATE.xlsx';
$spreadsheet = IOFactory::load($templateFile);

$sheet1 = $spreadsheet->getSheetByName('KIR TABEL');
if ($sheet1 === null) {
    die("Sheet 'KIR QRCODE' tidak ditemukan dalam template.");
}
$sql_barang = "
    SELECT 
        kode_barang, nama_barang, merk, no_pabrik, ukuran_CC, bahan, 
        YEAR(tgl_pembelian) AS tahun_pembelian, 
        SUM(CASE WHEN kondisi_barang = 'baik' THEN 1 ELSE 0 END) AS jml_baik,
        SUM(CASE WHEN kondisi_barang = 'kurang baik' THEN 1 ELSE 0 END) AS jml_kurang_baik,
        SUM(CASE WHEN kondisi_barang = 'rusak' THEN 1 ELSE 0 END) AS jml_rusak,
        COUNT(*) AS total_register, SUM(harga_awal) AS total_harga_awal
    FROM data_barang
    WHERE id_ruang_sekarang = '$id_lokasi'
    GROUP BY kode_barang, nama_barang, merk, no_pabrik, ukuran_CC, bahan, tahun_pembelian
";

$result_barang = mysqli_query($conn, $sql_barang);
if (!$result_barang) {
    die("Query gagal: " . mysqli_error($conn));
}

$formatter = new IntlDateFormatter(
    'id_ID', 
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    'Asia/Jakarta',
    IntlDateFormatter::GREGORIAN,
    'd MMMM yyyy'
);

$date = $formatter->format(new DateTime());

$rowNum = 14;
$no = 1;
$sheet1->setCellValue('C9', ': ' . strtoupper($rowlokasi['bid_lokasi']));
$sheet1->setCellValue('K8', ': ' . $date);
$sheet1->setCellValue('K9', ': ' . $rowlokasi['nama_lokasi']);

while ($row = mysqli_fetch_assoc($result_barang)) {
    $sheet1->setCellValue('A' . $rowNum, $no);
    $sheet1->setCellValue('B' . $rowNum, $row['nama_barang']);
    $sheet1->setCellValue('C' . $rowNum, $row['merk']);
    $sheet1->setCellValue('D' . $rowNum, $row['no_pabrik']);
    $sheet1->setCellValue('E' . $rowNum, $row['ukuran_CC']);
    $sheet1->setCellValue('F' . $rowNum, $row['bahan']);
    $sheet1->setCellValue('G' . $rowNum, $row['tahun_pembelian']);
    $sheet1->setCellValue('H' . $rowNum, $row['kode_barang']);
    $sheet1->setCellValue('I' . $rowNum, $row['total_register']);
    $sheet1->setCellValue('J' . $rowNum, $row['total_harga_awal']);
    $sheet1->setCellValue('K' . $rowNum, $row['jml_baik']);
    $sheet1->setCellValue('L' . $rowNum, $row['jml_kurang_baik']);
    $sheet1->setCellValue('M' . $rowNum, $row['jml_rusak']);
    $rowNum++;
    $no++;
}

$totalRow = $rowNum;
$sheet1->setCellValue('A' . $totalRow, 'Jumlah');
$sheet1->mergeCells('A' . $totalRow . ':H' . $totalRow);

$sheet1->setCellValue('I' . $totalRow, '=SUM(I14:I' . ($totalRow - 1) . ')');
$sheet1->setCellValue('J' . $totalRow, '=SUM(J14:J' . ($totalRow - 1) . ')');
$sheet1->setCellValue('K' . $totalRow, '=SUM(K14:K' . ($totalRow - 1) . ')');
$sheet1->setCellValue('L' . $totalRow, '=SUM(L14:L' . ($totalRow - 1) . ')');
$sheet1->setCellValue('M' . $totalRow, '=SUM(M14:M' . ($totalRow - 1) . ')');

$dataStyle = [
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    ]
];
$dataStyle3 = [
    'font' => [
        'bold' => true,
        'size' => 9,
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_RIGHT,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
];

$sheet1->getStyle('A14:M' . ($rowNum))->applyFromArray($dataStyle);
$sheet1->getStyle('A' . $totalRow . ':H' . $totalRow)->applyFromArray($dataStyle3);

$sheet2 = $spreadsheet->getSheetByName('KIR QRCODE');
if ($sheet2 === null) {
    die("Sheet 'KIR QRCODE' tidak ditemukan dalam template.");
}

$sheet2->setCellValue('C9', ': ' . strtoupper($rowlokasi['bid_lokasi']));
$sheet2->setCellValue('K8', ': ' . $date);
$sheet2->setCellValue('K9', ': ' . $rowlokasi['nama_lokasi']);

$drawing = new Drawing();
$drawing->setName('qrcodes');
$drawing->setPath('qrcodes/ruang/inventaris_' . $rowlokasi['bid_lokasi'] . '.png');
$drawing->setWidth(480); 
$drawing->setCoordinates('D11');
$drawing->setWorksheet($sheet2);

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="KIR_' . $rowlokasi['bid_lokasi'] . '_' . $date . '.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit();
?>