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
$sheet = $spreadsheet->getActiveSheet();
$spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');

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
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('brebes.png');
$drawing->setWidth(60);
$drawing->setCoordinates('A1');
$drawing->setWorksheet($sheet);

$sheet->setCellValue('A5', 'Sub Unit Organisasi');
$sheet->setCellValue('A6', 'Pengelola Barang');
$sheet->setCellValue('A7', isset($rowlokasi['bid_lokasi']) ? 'Ruangan' : 'Ruangan');
$sheet->setCellValue('A8', 'Per Tanggal');
$sheet->setCellValue('C5', ': DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK');
$sheet->setCellValue('C6', ': DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK');
$sheet->setCellValue('C7', ': ' . strtoupper($rowlokasi['nama_lokasi']));
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

// **Header Kolom Tabel**
$headers = [
    'No', 'Jenis Barang / Nama Barang', 'Merk/Model', 'No. Seri Pabrik', 
    'Ukuran', 'Bahan', 'Tahun Pembelian', 'No. Kode Barang', 
    'Jumlah Barang', 'Harga Beli', 'Kondisi Barang'
];
$sheet->fromArray($headers, NULL, 'A10');

$headers_num = [
    '1', '2', '3', '4', '5', '6','7', '8', '9','10', '11', '12','13'
];
$sheet->fromArray($headers_num, NULL, 'A12'); 

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

// Style Header
$headerStyle = [
    'font' => ['bold' => true, 'size' => 9],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E1F2']]
];
$sheet->getStyle('A10:M12')->applyFromArray($headerStyle);

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
    $sheet->setCellValue('A' . $rowNum, $no);
    $sheet->setCellValue('B' . $rowNum, $row['nama_barang']);
    $sheet->setCellValue('C' . $rowNum, $row['merk']);
    $sheet->setCellValue('D' . $rowNum, $row['no_pabrik']);
    $sheet->setCellValue('E' . $rowNum, $row['ukuran_CC']);
    $sheet->setCellValue('F' . $rowNum, $row['bahan']);
    $sheet->setCellValue('G' . $rowNum, $row['tahun_pembelian']);
    $sheet->setCellValue('H' . $rowNum, $row['kode_barang']);
    $sheet->setCellValue('I' . $rowNum, $row['total_register']);
    $sheet->setCellValue('J' . $rowNum, $row['total_harga_awal']);
    $sheet->setCellValue('K' . $rowNum, $row['jml_baik']);
    $sheet->setCellValue('L' . $rowNum, $row['jml_kurang_baik']);
    $sheet->setCellValue('M' . $rowNum, $row['jml_rusak']);
    $rowNum++;
    $no++;
}

// Baris untuk menampilkan jumlah total
$totalRow = $rowNum; // Baris setelah data terakhir
$sheet->setCellValue('A' . $totalRow, 'Jumlah');
$sheet->mergeCells('A' . $totalRow . ':H' . $totalRow); // Menggabungkan kolom A hingga H untuk label "Jumlah"

// Mengisi total dengan formula SUM()
$sheet->setCellValue('I' . $totalRow, '=SUM(I13:I' . ($totalRow - 1) . ')');
$sheet->setCellValue('J' . $totalRow, '=SUM(J13:J' . ($totalRow - 1) . ')');
$sheet->setCellValue('K' . $totalRow, '=SUM(K13:K' . ($totalRow - 1) . ')');
$sheet->setCellValue('L' . $totalRow, '=SUM(L13:L' . ($totalRow - 1) . ')');
$sheet->setCellValue('M' . $totalRow, '=SUM(M13:M' . ($totalRow - 1) . ')');

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
$sheet->getStyle('A13:A' . ($rowNum - 1))->applyFromArray($dataStyle);
$sheet->getStyle('D13:M' . ($rowNum - 1))->applyFromArray($dataStyle);
$sheet->getStyle('B13:C' . ($rowNum - 1))->applyFromArray($dataStyle2);
$sheet->getStyle('I' . $totalRow . ':M' . $totalRow)->applyFromArray($dataStyle);
$sheet->getStyle('A' . $totalRow . ':H' . $totalRow)->applyFromArray($dataStyle3);

// Buat objek writer untuk menyimpan file dalam format XLS
$writer = new Xls($spreadsheet);
$nama_lokasi = $rowlokasi['nama_lokasi'] ?? 'Lokasi_Tidak_Diketahui'; 
$date = date('Y-m-d');
// nama file dinamis
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="KIR_' . $nama_lokasi . '_' . $date . '.xls"');
header('Cache-Control: max-age=0');
// Simpan dan kirim file Excel ke output
$writer->save('php://output');
exit();

?>
