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
$sheet->setCellValue('D3', 'LAPORAN ASET/BARANG');

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
$sheet->setCellValue('A5', 'Tanggal Cetak: ' . date('d-m-Y'));

// Atur header untuk kolom tabel
$headers = [
    'No', 'ID Barang Pemda', 'Kode Barang', 'Nama Barang', 'Lokasi Asal',
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
$sheet->getStyle('A7:Q7')->applyFromArray($headerStyle);

// Query untuk mengambil semua kolom dari tabel data_barang
$sql = "SELECT * FROM data_barang";
$result = mysqli_query($conn, $sql);

// Mulai memasukkan data hasil query dari baris ke-8
$rowNum = 8; // Baris mulai data
$no = 1; // Inisialisasi nomor urut
while ($row = mysqli_fetch_assoc($result)) {
    // Ukuran font dibuat 8
    $sheet->setCellValue('A' . $rowNum, $no);
    $sheet->setCellValue('B' . $rowNum, $row['id_barang_pemda']);
    $sheet->setCellValue('C' . $rowNum, $row['kode_barang']);
    $sheet->setCellValue('D' . $rowNum, $row['nama_barang']);
    $sheet->setCellValue('E' . $rowNum, $row['nama_ruang_asal'] . ' ' . $row['bidang_ruang_asal'] . ' ' . $row['tempat_ruang_asal']);
    $sheet->setCellValue('F' . $rowNum, date('d/m/Y', strtotime($row['tgl_pembelian'])));
    $sheet->setCellValue('G' . $rowNum, "Rp " . number_format($row['harga_awal'], 2, ',', '.'));
    $sheet->setCellValue('H' . $rowNum, $row['merk']);
    $sheet->setCellValue('I' . $rowNum, $row['type']);
    $sheet->setCellValue('J' . $rowNum, $row['kategori']);
    $sheet->setCellValue('K' . $rowNum, $row['ukuran_CC']);
    $sheet->setCellValue('L' . $rowNum, $row['no_pabrik']);
    $sheet->setCellValue('M' . $rowNum, $row['no_rangka']);
    $sheet->setCellValue('N' . $rowNum, $row['no_bpkb']);
    $sheet->setCellValue('O' . $rowNum, $row['bahan']);
    $sheet->setCellValue('P' . $rowNum, $row['no_mesin']);
    $sheet->setCellValue('Q' . $rowNum, $row['no_polisi']);
    $rowNum++;
    $no++;
}

// Atur lebar kolom secara manual
$sheet->getColumnDimension('A')->setWidth(3.71); 
$sheet->getColumnDimension('B')->setWidth(10.42);
$sheet->getColumnDimension('C')->setWidth(8.86 + 0.71);
$sheet->getColumnDimension('D')->setWidth(15.29 + 0.71);
$sheet->getColumnDimension('E')->setWidth(10.29 + 0.71);
$sheet->getColumnDimension('F')->setWidth(8.57 + 0.71);
$sheet->getColumnDimension('G')->setWidth(10 + 0.71);
$sheet->getColumnDimension('H')->setWidth(8.29 + 0.71);
$sheet->getColumnDimension('I')->setWidth(4.86 + 0.71);
$sheet->getColumnDimension('J')->setWidth(7 + 0.71);
$sheet->getColumnDimension('K')->setWidth(6.57 + 0.71);
$sheet->getColumnDimension('L')->setWidth(5.71 + 0.71);
$sheet->getColumnDimension('M')->setWidth(6.29 + 0.71);
$sheet->getColumnDimension('N')->setWidth(6.29 + 0.71);
$sheet->getColumnDimension('O')->setWidth(5.86 + 0.71);
$sheet->getColumnDimension('P')->setWidth(6.29 + 0.71);
$sheet->getColumnDimension('Q')->setWidth(7 + 0.71);

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
$sheet->getStyle('A7:Q7')->applyFromArray($headerStyle);

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
$sheet->getStyle('A8:Q' . ($rowNum - 1))->applyFromArray($dataStyle);

// Simpan file Excel dan kirimkan ke browser untuk diunduh
$writer = new Xls($spreadsheet);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="data_barang.xls"');
$writer->save('php://output');
exit;
?>
