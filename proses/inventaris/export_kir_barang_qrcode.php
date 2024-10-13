<?php
// Include PhpSpreadsheet dan Mpdf
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf as PdfWriter;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

// Mulai session dan koneksi ke database
session_start();
include('../../koneksi/koneksi.php');
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);


// Ambil data lokasi
$id_lokasi = $_GET['id_lokasi']; // Parameter id_lokasi
$sql_lokasi = "SELECT * FROM lokasi WHERE id_lokasi = '$id_lokasi'";
$result_lokasi = mysqli_query($conn, $sql_lokasi);
$rowlokasi = mysqli_fetch_assoc($result_lokasi);

// Buat objek Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
$sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

// **Header dan Logo**
$sheet->setCellValue('C1', 'PEMERINTAH KABUPATEN BREBES');
$sheet->setCellValue('C2', 'DINAS KOMUNIKASI INFORMATIKA DAN STATISTIK');
$sheet->setCellValue('C3', 'KARTU INVENTARIS RUANGAN');
$sheet->mergeCells('C1:J1');
$sheet->mergeCells('C2:J2');
$sheet->mergeCells('C3:J3');
$sheet->mergeCells('A1:B3');
$sheet->getStyle('C1:C4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('C1:C4')->getFont()->setBold(true);

// Tambahkan logo
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('brebes.png'); // Pastikan path logo benar
$drawing->setWidth(60);
$drawing->setCoordinates('A1');
$drawing->setWorksheet($sheet);

// **Bagian Informasi Lokasi**
$sheet->setCellValue('A5', 'Sub Unit Organisasi');
$sheet->setCellValue('C5', ': DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK');
$sheet->setCellValue('A6', 'Pengelola Barang');
$sheet->setCellValue('C6', ': DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK');
$sheet->setCellValue('A7', 'Ruangan');
$sheet->setCellValue('C7', ': ' . strtoupper($rowlokasi['nama_lokasi']));
$sheet->setCellValue('A8', 'Per Tanggal');
$sheet->setCellValue('C8', ': ' . date('d F Y'));
$sheet->setCellValue('I8', 'No. Kode Lokasi');
$sheet->setCellValue('K8', ': ' . $rowlokasi['id_lokasi']);

$sheet->mergeCells('A5:B5');
$sheet->mergeCells('A6:B6');
$sheet->mergeCells('A7:B7');
$sheet->mergeCells('A8:B8');
$sheet->mergeCells('I8:J8');
$sheet->mergeCells('K8:M8');

$sheet->mergeCells('C5:G5');
$sheet->mergeCells('C6:G6');
$sheet->mergeCells('C7:G7');
$sheet->mergeCells('C8:G8');

// **Header Tabel Barang**
$headers = [
    'No', 'Jenis Barang / Nama Barang', 'Merk/Model', 'No. Seri Pabrik', 
    'Ukuran', 'Bahan', 'Tahun Pembelian', 'No. Kode Barang', 
    'Jumlah Barang', 'Harga Beli', 'Kondisi Barang'
];
$sheet->fromArray($headers, NULL, 'A10');

$sheet->mergeCells('K10:M10');
$sheet->mergeCells('A10:A11');
$sheet->mergeCells('B10:B11');
$sheet->mergeCells('C10:C11');
$sheet->mergeCells('D10:D11');
$sheet->mergeCells('E10:E11');
$sheet->mergeCells('F10:F11');
$sheet->mergeCells('G10:G11');
$sheet->mergeCells('H10:H11');
$sheet->mergeCells('I10:I11');
$sheet->mergeCells('J10:J11');
$sheet->mergeCells('K10:K11');
$sheet->mergeCells('L10:L11');
$sheet->mergeCells('M10:M11');

$sheet->setCellValue('K11', 'Baik (B)');
$sheet->setCellValue('L11', 'Kurang Baik (KB)');
$sheet->setCellValue('M11', 'Rusak Berat (RB)');
$headers_num = [
    '1', '2', '3', '4', '5', '6','7', '8', '9','10', '11', '12','13'
];
$sheet->fromArray($headers_num, NULL, 'A12'); 

// Style Header Tabel
$headerStyle = [
    'font' => ['bold' => true, 'size' => 9],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E1F2']]
];
$sheet->getStyle('A10:K10')->applyFromArray($headerStyle);
$sheet->getStyle('A1:M9')->applyFromArray([
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_NONE]
    ]
]);

// **Isi Data Barang**
$rowNum = 13;
$no = 1;

// Ambil data barang dan hitung berdasarkan kode_barang
$sql_barang = "
    SELECT 
        kode_barang, 
        nama_barang, 
        merk, 
        no_pabrik, 
        ukuran_CC, 
        bahan, 
        YEAR(tgl_pembelian) AS tahun_pembelian, 
        SUM(CASE WHEN kondisi_barang = 'baik' THEN 1 ELSE 0 END) AS jml_baik,
        SUM(CASE WHEN kondisi_barang = 'kurang baik' THEN 1 ELSE 0 END) AS jml_kurang_baik,
        SUM(CASE WHEN kondisi_barang = 'rusak' THEN 1 ELSE 0 END) AS jml_rusak,
        COUNT(*) AS total_register,
        harga_awal
    FROM 
        data_barang
    WHERE 
        id_ruang_sekarang = '$id_lokasi'
    GROUP BY 
        kode_barang, nama_barang, merk, no_pabrik, ukuran_CC, bahan, tahun_pembelian, harga_awal
";

$result_barang = mysqli_query($conn, $sql_barang);
while ($row = mysqli_fetch_assoc($result_barang)) {
    $sheet->setCellValue('A' . $rowNum, $no);
    $sheet->setCellValue('B' . $rowNum, $row['nama_barang']);
    $sheet->setCellValue('C' . $rowNum, $row['merk']);
    $sheet->setCellValue('D' . $rowNum, $row['no_pabrik']);
    $sheet->setCellValue('E' . $rowNum, $row['ukuran_CC']);
    $sheet->setCellValue('F' . $rowNum, $row['bahan']);
    $sheet->setCellValue('G' . $rowNum, $row['tahun_pembelian']);
    $sheet->setCellValue('H' . $rowNum, $row['kode_barang']);
    $sheet->setCellValue('I' . $rowNum, $row['total_register']);
    $sheet->setCellValue('J' . $rowNum, $row['harga_awal']);
    $sheet->setCellValue('K' . $rowNum, $row['jml_baik']);
    $sheet->setCellValue('L' . $rowNum, $row['jml_kurang_baik']);
    $sheet->setCellValue('M' . $rowNum, $row['jml_rusak']);
    $rowNum++;
    $no++;
}

// **Atur Lebar Kolom**
$sheet->getColumnDimension('A')->setWidth(4.42);
$sheet->getColumnDimension('B')->setWidth(23.57+0.71);
$sheet->getColumnDimension('C')->setWidth(19+0.71);
$sheet->getColumnDimension('D')->setWidth(11.14);
$sheet->getColumnDimension('E')->setWidth(9.29);
$sheet->getColumnDimension('F')->setWidth(12+0.71);
$sheet->getColumnDimension('G')->setWidth(9.14+0.71);
$sheet->getColumnDimension('H')->setWidth(14.78+0.71);
$sheet->getColumnDimension('I')->setWidth(8.14+0.71);
$sheet->getColumnDimension('J')->setWidth(9.29+0.71);
$sheet->getColumnDimension('K')->setWidth(5.86+0.71);
$sheet->getColumnDimension('L')->setWidth(5.86+0.71);
$sheet->getColumnDimension('M')->setWidth(5.86+0.71);

$headerStyle = [
    'font' => ['bold' => true],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true // Menambahkan wrap text
    ],
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'D9E1F2']
    ]
];
$sheet->getStyle('A10:M12')->applyFromArray($headerStyle);

$dataStyle = [
    'font' => ['size' => 8], // Menambahkan ukuran font 8
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true // Menambahkan wrap text
    ],
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    ]
];
$dataStyle2 = [
    'font' => ['size' => 8], // Menambahkan ukuran font 8
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true // Menambahkan wrap text
    ],
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    ]
];
$sheet->getStyle('A13:A' . ($rowNum - 1))->applyFromArray($dataStyle);
$sheet->getStyle('D13:M' . ($rowNum - 1))->applyFromArray($dataStyle);
$sheet->getStyle('B13:C' . ($rowNum - 1))->applyFromArray($dataStyle2);

// Konfigurasi PDF menggunakan Mpdf
$writer = new Dompdf($spreadsheet);;

// Header untuk mengunduh file PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="KIR_' . $rowlokasi['nama_lokasi'] . '_' . date('Ymd') . '.pdf"');
$writer->save('php://output');
exit;
?>