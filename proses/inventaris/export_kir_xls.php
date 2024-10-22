<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

session_start();
include('../../koneksi/koneksi.php');

// Ambil data lokasi
$id_lokasi = $_GET['id_lokasi'];
$sql_lokasi = "SELECT * FROM lokasi WHERE id_lokasi = '$id_lokasi'";
$result_lokasi = mysqli_query($conn, $sql_lokasi);
$rowlokasi = mysqli_fetch_assoc($result_lokasi);

// Buat objek Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet1 = $spreadsheet->getActiveSheet();
$sheet1->setTitle('KIR TABEL');
$spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');

// **Header dan Logo**
$sheet1->setCellValue('C1', 'PEMERINTAH KABUPATEN BREBES');
$sheet1->setCellValue('C2', 'DINAS KOMUNIKASI INFORMATIKA DAN STATISTIK');
$sheet1->setCellValue('C3', 'KARTU INVENTARIS RUANGAN');
$sheet1->mergeCells('C1:J1');
$sheet1->mergeCells('C2:J2');
$sheet1->mergeCells('C3:J3');
$sheet1->mergeCells('A1:B3');
$sheet1->getStyle('C1:C4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet1->getStyle('C1:C4')->getFont()->setBold(true);
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('qrcodes/brebes.png');
$drawing->setWidth(60);
$drawing->setCoordinates('A1');
$drawing->setWorksheet($sheet1);

$sheet1->setCellValue('A5', 'Sub Unit Organisasi');
$sheet1->setCellValue('A6', 'Pengelola Barang');
$sheet1->setCellValue('A7', isset($rowlokasi['bid_lokasi']) ? 'Ruangan' : 'Ruangan');
$sheet1->setCellValue('A8', 'Per Tanggal');
$sheet1->setCellValue('C5', ': DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK');
$sheet1->setCellValue('C6', ': DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK');
$sheet1->setCellValue('C7', ': ' . strtoupper($rowlokasi['bid_lokasi']));
$sheet1->setCellValue('C8', ': ' . date('d F Y'));
$sheet1->setCellValue('I8', 'No. Kode Lokasi');
$sheet1->setCellValue('K8', ': ' . $rowlokasi['nama_lokasi']);

$sheet1->mergeCells('A5:B5');
$sheet1->mergeCells('A6:B6');
$sheet1->mergeCells('A7:B7');
$sheet1->mergeCells('A8:B8');
$sheet1->mergeCells('I8:J8');
$sheet1->mergeCells('K8:M8');
$sheet1->mergeCells('C5:G5');
$sheet1->mergeCells('C6:G6');
$sheet1->mergeCells('C7:G7');
$sheet1->mergeCells('C8:G8');

// **Header Kolom Tabel**
$headers = [
    'No', 'Jenis Barang / Nama Barang', 'Merk/Model', 'No. Seri Pabrik', 
    'Ukuran', 'Bahan', 'Tahun Pembelian', 'No. Kode Barang', 
    'Jumlah Barang', 'Harga Beli', 'Kondisi Barang'
];
$sheet1->fromArray($headers, NULL, 'A10');

$headers_num = [
    '1', '2', '3', '4', '5', '6','7', '8', '9','10', '11', '12','13'
];
$sheet1->fromArray($headers_num, NULL, 'A12'); 

$sheet1->mergeCells('K10:M10');
$sheet1->mergeCells('A10:A11');
$sheet1->mergeCells('B10:B11');
$sheet1->mergeCells('C10:C11');
$sheet1->mergeCells('D10:D11');
$sheet1->mergeCells('E10:E11');
$sheet1->mergeCells('F10:F11');
$sheet1->mergeCells('G10:G11');
$sheet1->mergeCells('H10:H11');
$sheet1->mergeCells('I10:I11');
$sheet1->mergeCells('J10:J11');
$sheet1->mergeCells('K10:K11');
$sheet1->mergeCells('L10:L11');
$sheet1->mergeCells('M10:M11');

$sheet1->setCellValue('K11', 'Baik (B)');
$sheet1->setCellValue('L11', 'Kurang Baik (KB)');
$sheet1->setCellValue('M11', 'Rusak Berat (RB)');

// Style Header
$headerStyle = [
    'font' => ['bold' => true, 'size' => 9],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E1F2']]
];
$sheet1->getStyle('A10:M12')->applyFromArray($headerStyle);

// **Isi Data Barang**
$rowNum = 13;
$no = 1;

// Ambil data barang
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

// Isi data barang ke dalam tabel
$rowNum = 13; // Baris awal pengisian data
$no = 1; // Nomor urut

// Loop untuk mengisi data barang
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

// Baris untuk menampilkan jumlah total
$totalRow = $rowNum; // Baris setelah data terakhir
$sheet1->setCellValue('A' . $totalRow, 'Jumlah');
$sheet1->mergeCells('A' . $totalRow . ':H' . $totalRow); // Menggabungkan kolom A hingga H untuk label "Jumlah"

// Mengisi total dengan formula SUM()
$sheet1->setCellValue('I' . $totalRow, '=SUM(I13:I' . ($totalRow - 1) . ')');
$sheet1->setCellValue('J' . $totalRow, '=SUM(J13:J' . ($totalRow - 1) . ')');
$sheet1->setCellValue('K' . $totalRow, '=SUM(K13:K' . ($totalRow - 1) . ')');
$sheet1->setCellValue('L' . $totalRow, '=SUM(L13:L' . ($totalRow - 1) . ')');
$sheet1->setCellValue('M' . $totalRow, '=SUM(M13:M' . ($totalRow - 1) . ')');

// **Atur Lebar Kolom**
$sheet1->getColumnDimension('A')->setWidth(4.42);
$sheet1->getColumnDimension('B')->setWidth(23.57+0.71);
$sheet1->getColumnDimension('C')->setWidth(19+0.71);
$sheet1->getColumnDimension('D')->setWidth(11.14);
$sheet1->getColumnDimension('E')->setWidth(9.29);
$sheet1->getColumnDimension('F')->setWidth(12+0.71);
$sheet1->getColumnDimension('G')->setWidth(9.14+0.71);
$sheet1->getColumnDimension('H')->setWidth(14.78+0.71);
$sheet1->getColumnDimension('I')->setWidth(8.14+0.71);
$sheet1->getColumnDimension('J')->setWidth(9.29+0.71);
$sheet1->getColumnDimension('K')->setWidth(5.86+0.71);
$sheet1->getColumnDimension('L')->setWidth(5.86+0.71);
$sheet1->getColumnDimension('M')->setWidth(5.86+0.71);

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
$sheet1->getStyle('A10:M12')->applyFromArray($headerStyle);

$dataStyle = [
    'font' => ['size' => 8],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true
    ],
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    ]
];
$dataStyle2 = [
    'font' => ['size' => 8],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true
    ],
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
$sheet1->getStyle('A13:A' . ($rowNum - 1))->applyFromArray($dataStyle);
$sheet1->getStyle('D13:M' . ($rowNum - 1))->applyFromArray($dataStyle);
$sheet1->getStyle('B13:C' . ($rowNum - 1))->applyFromArray($dataStyle2);
$sheet1->getStyle('I' . $totalRow . ':M' . $totalRow)->applyFromArray($dataStyle);
$sheet1->getStyle('A' . $totalRow . ':H' . $totalRow)->applyFromArray($dataStyle3);

$writer = new Xls($spreadsheet);
$bid_lokasi = $rowlokasi['bid_lokasi'] ?? 'Lokasi_Tidak_Diketahui'; 
$date = date('Y-m-d');

$sheet2 = $spreadsheet->createSheet(1);
$sheet2->setTitle('KIR QRCode');

// **Header dan Logo**
$sheet2->setCellValue('C1', 'PEMERINTAH KABUPATEN BREBES');
$sheet2->setCellValue('C2', 'DINAS KOMUNIKASI INFORMATIKA DAN STATISTIK');
$sheet2->setCellValue('C3', 'KARTU INVENTARIS RUANGAN');
$sheet2->mergeCells('C1:K1');
$sheet2->mergeCells('C2:K2');
$sheet2->mergeCells('C3:K3');
$sheet2->mergeCells('A1:B3');
$sheet2->getStyle('C1:C4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet2->getStyle('C1:C4')->getFont()->setBold(true);
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('qrcodes/brebes.png');
$drawing->setWidth(60);
$drawing->setCoordinates('A1');
$drawing->setWorksheet($sheet2);
$drawing2 = new Drawing();
$drawing2->setName('qrcodes');
$drawing2->setPath('qrcodes/ruang/inventaris_'.$bid_lokasi.'.png');
$drawing2->setWidth(480);
$drawing2->setCoordinates('D10');
$drawing2->setWorksheet($sheet2);

$sheet2->setCellValue('A5', 'Sub Unit Organisasi');
$sheet2->setCellValue('A6', 'Pengelola Barang');
$sheet2->setCellValue('A7', isset($rowlokasi['bid_lokasi']) ? 'Ruangan' : 'Ruangan');
$sheet2->setCellValue('A8', 'Per Tanggal');
$sheet2->setCellValue('C5', ': DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK');
$sheet2->setCellValue('C6', ': DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK');
$sheet2->setCellValue('C7', ': ' . strtoupper($rowlokasi['bid_lokasi']));
$sheet2->setCellValue('C8', ': ' . date('d F Y'));
$sheet2->setCellValue('I8', 'No. Kode Lokasi');
$sheet2->setCellValue('K8', ': ' . $rowlokasi['nama_lokasi']);

$sheet2->mergeCells('A5:B5');
$sheet2->mergeCells('A6:B6');
$sheet2->mergeCells('A7:B7');
$sheet2->mergeCells('A8:B8');
$sheet2->mergeCells('I8:J8');
$sheet2->mergeCells('K8:M8');
$sheet2->mergeCells('C5:G5');
$sheet2->mergeCells('C6:G6');
$sheet2->mergeCells('C7:G7');
$sheet2->mergeCells('C8:G8');

$sheet2->getColumnDimension('B')->setWidth(10.29+0.71);
$sheet2->getColumnDimension('G')->setWidth(18.86+0.71);

// nama file dinamis
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="KIR_' . $bid_lokasi . '_' . $date . '.xls"');
header('Cache-Control: max-age=0');
// Simpan dan kirim file Excel ke output
$writer->save('php://output');
exit();

?>
