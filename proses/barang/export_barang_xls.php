<?php
// Include PhpSpreadsheet
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;

session_start();
include('../../koneksi/koneksi.php');
$templateFile = 'DAFTAR_BARANG_TEMPLATE.xlsx';
$spreadsheet = IOFactory::load($templateFile);
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A4', 'Periode s/d Tahun ' . date('Y'));

$sql = "SELECT * FROM data_barang";
$result = mysqli_query($conn, $sql);

$rowNum = 14;
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $rowNum, $no);
    $sheet->setCellValue('B' . $rowNum, $row['id_barang_pemda']);
    $sheet->setCellValue('C' . $rowNum, $row['kode_barang']);
    $sheet->setCellValue('D' . $rowNum, $row['no_regristrasi']);
    $sheet->setCellValue('E' . $rowNum, $row['nama_ruang_asal']);
    $sheet->setCellValue('F' . $rowNum, $row['id_ruang_asal']);
    $sheet->setCellValue('G' . $rowNum, $row['nama_barang']);
    $sheet->setCellValue('H' . $rowNum, $row['tempat_ruang_asal']);
    $sheet->setCellValue('I' . $rowNum, $row['bidang_ruang_asal']);
    $sheet->setCellValue('J' . $rowNum, $row['merk']. ' ' . $row['type']);
    $sheet->setCellValue('K' . $rowNum, $row['ukuran_CC']);
    $sheet->setCellValue('L' . $rowNum, $row['bahan']);
    $tgl_pembelian = $row['tgl_pembelian']; 
    $formatDate = date('d/m/Y', strtotime($tgl_pembelian)); 
    $sheet->setCellValue('M' . $rowNum, $formatDate);
    $sheet->setCellValue('N' . $rowNum, $row['no_pabrik']);
    $sheet->setCellValue('O' . $rowNum, $row['no_rangka']);
    $sheet->setCellValue('P' . $rowNum, $row['no_mesin']);
    $sheet->setCellValue('Q' . $rowNum, $row['no_polisi']);
    $sheet->setCellValue('R' . $rowNum, $row['no_bpkb']);
    $sheet->setCellValue('T' . $rowNum, $row['harga_awal']);
    $sheet->setCellValue('u' . $rowNum, $row['kondisi_barang']);
    $sheet->setCellValue('v' . $rowNum, $row['keterangan']);
    $rowNum++;
    $no++;
}
$dataStyle = [
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    ]
];
$sheet->getStyle('A14:v' . ($rowNum - 1))->applyFromArray($dataStyle);
$formatter = new IntlDateFormatter(
    'id_ID',
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    'Asia/Jakarta',
    IntlDateFormatter::GREGORIAN,
    'd MMMM yyyy'
);

$date = $formatter->format(new DateTime());
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="' . $date . '_daftar_barang.xlsx"');
$writer->save('php://output');
exit;
?>                                                                                           