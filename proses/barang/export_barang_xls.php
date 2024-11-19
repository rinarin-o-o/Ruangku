<<<<<<< HEAD
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
=======
<?php
// Include PhpSpreadsheet
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

// Mulai session dan koneksi ke database
session_start();
include('../../koneksi/koneksi.php');

// Buat objek Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Atur font untuk seluruh dokumen menjadi Times New Roman
$spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');

// Tambahkan header logo dan judul di baris pertama
$sheet->setCellValue('D1', 'DINAS KOMUNIKASI INFORMATIKA DAN STATISTIK');
$sheet->setCellValue('D2', 'KABUPATEN BREBES');
$sheet->setCellValue('D3', 'DAFTAR ASET/BARANG');
$sheet->mergeCells('A1:B3');
// Menggabungkan beberapa sel untuk judul
$sheet->mergeCells('D1:N1');
$sheet->mergeCells('D2:N2');
$sheet->mergeCells('D3:N3');

// Set alignment ke tengah untuk judul dan ubah ukuran font judul menjadi 12
$sheet->getStyle('D1:D3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('D1:D3')->getFont()->setSize(12);
$sheet->getStyle('D1:D3')->getFont()->setBold(true);

// Tambahkan gambar logo
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setDescription('Logo');
$drawing->setPath('logo.png'); // Path ke gambar logo di server
$drawing->setWidth(70);
$drawing->setHeight(60); // Tinggi gambar dalam pixel
$drawing->setCoordinates('A1'); // Gambar akan dimulai dari sel A1
$drawing->setWorksheet($sheet); // Tambahkan gambar ke sheet

// Tambahkan tanggal cetak di A5
$sheet->setCellValue('A5', 'Per tanggal: ' . date('d F Y'));

// Atur header untuk kolom tabel
$headers = [
    'No', 'ID Pemda', 'Kode Aset', 'Nama Aset', 'Ruang Asal', 'Ruang Sekarang',
    'Tanggal Pembelian', 'Harga Beli', 'Merk', 'Type', 'Kategori', 'Ukuran CC',
    'No. Pabrik', 'No. Rangka', 'No. BPKB', 'Bahan', 'No. Mesin', 'No. Polisi'
];
$sheet->fromArray($headers, NULL, 'A7'); // Memasukkan header di baris ke-7

// Beri warna fill untuk header, alignment center, border untuk tabel, dan ubah ukuran font header menjadi 9
$headerStyle = [
    'font' => ['bold' => true, 'size' => 9],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'D9E1F2']
    ]
];
$sheet->getStyle('A7:R7')->applyFromArray($headerStyle);

$sql = "SELECT * FROM data_barang";
$result = mysqli_query($conn, $sql);

$rowNum = 8; // Baris mulai data
$no = 1; // Inisialisasi nomor urut
while ($row = mysqli_fetch_assoc($result)) {
    // Ukuran font dibuat 8
    $sheet->setCellValue('A' . $rowNum, $no);
    $sheet->setCellValue('B' . $rowNum, $row['id_barang_pemda']);
    $sheet->getStyle('B' . $rowNum)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    $sheet->setCellValue('C' . $rowNum, $row['kode_barang']);
    $sheet->setCellValue('D' . $rowNum, $row['nama_barang']);
    $sheet->setCellValue('E' . $rowNum, $row['id_ruang_asal'].' - '.$row['bidang_ruang_asal']);
    $sheet->setCellValue('F' . $rowNum, $row['id_ruang_sekarang'].' - '.$row['bidang_ruang_sekarang']);
    $sheet->setCellValue('G' . $rowNum, date('d/m/Y', strtotime($row['tgl_pembelian'])));
    $sheet->setCellValue('H' . $rowNum, "Rp " . number_format($row['harga_awal'], 2, ',', '.'));
    $sheet->setCellValue('I' . $rowNum, $row['merk']);
    $sheet->setCellValue('J' . $rowNum, $row['type']);
    $sheet->setCellValue('K' . $rowNum, $row['kategori']);
    $sheet->setCellValue('L' . $rowNum, $row['ukuran_CC']);
    $sheet->setCellValue('M' . $rowNum, $row['no_pabrik']);
    $sheet->setCellValue('N' . $rowNum, $row['no_rangka']);
    $sheet->setCellValue('O' . $rowNum, $row['no_bpkb']);
    $sheet->setCellValue('P' . $rowNum, $row['bahan']);
    $sheet->setCellValue('Q' . $rowNum, $row['no_mesin']);
    $sheet->setCellValue('R' . $rowNum, $row['no_polisi']);
    $rowNum++;
    $no++;
}

// Atur lebar kolom secara manual
$sheet->getColumnDimension('A')->setWidth(3.71); 
$sheet->getColumnDimension('B')->setWidth(15.57 + 0.71);
$sheet->getColumnDimension('C')->setWidth(15 + 0.71);
$sheet->getColumnDimension('D')->setWidth(15.29 + 0.71);
$sheet->getColumnDimension('E')->setWidth(10.29 + 0.71);
$sheet->getColumnDimension('F')->setWidth(10.29 + 0.71);
$sheet->getColumnDimension('G')->setWidth(8.57 + 0.71);
$sheet->getColumnDimension('H')->setWidth(10 + 0.71);
$sheet->getColumnDimension('I')->setWidth(8.29 + 0.71);
$sheet->getColumnDimension('J')->setWidth(4.86 + 0.71);
$sheet->getColumnDimension('K')->setWidth(7 + 0.71);
$sheet->getColumnDimension('L')->setWidth(6.57 + 0.71);
$sheet->getColumnDimension('M')->setWidth(5.71 + 0.71);
$sheet->getColumnDimension('N')->setWidth(6.29 + 0.71);
$sheet->getColumnDimension('O')->setWidth(6.29 + 0.71);
$sheet->getColumnDimension('P')->setWidth(5.86 + 0.71);
$sheet->getColumnDimension('Q')->setWidth(6.29 + 0.71);
$sheet->getColumnDimension('R')->setWidth(7 + 0.71);

// Beri warna fill untuk header, alignment center, border untuk tabel, dan wrap text
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
$sheet->getStyle('A7:R7')->applyFromArray($headerStyle);

// Buat border untuk semua data, alignment center, wrap text, dan ukuran font 8
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
$sheet->getStyle('A8:R' . ($rowNum - 1))->applyFromArray($dataStyle);

// Simpan file Excel dan kirimkan ke browser untuk diunduh
$writer = new Xls($spreadsheet);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="data_barang.xls"');
$writer->save('php://output');
exit;
?>
>>>>>>> 8794dfa5ca3bdc204900f670156ef4a33b0cc6d6
