<?php
include('koneksi/koneksi.php');

// Halaman
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search_query = "";
$search_params = [];
$param_types = "";

// Mengecek apakah ada input pencarian
if (!empty($_GET['query'])) {
    $search = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';
    $search_query = "WHERE id_barang_pemda LIKE ? OR nama_barang LIKE ? OR kode_barang LIKE ? OR merk LIKE ?";
    array_push($search_params, $search, $search, $search, $search);
    $param_types .= "ssss"; // Tambahkan empat "s" untuk empat LIKE parameter
}

$sql = "SELECT * FROM data_barang WHERE kategori = 'Barang Bergerak (Kendaraan)' $search_query LIMIT ?, ?";
$stmt = mysqli_prepare($conn, $sql);

// Tambahkan tipe untuk dua parameter limit dan offset
$param_types .= "ii";
array_push($search_params, $start, $limit);

// Bind parameter sesuai dengan tipe dan jumlah
mysqli_stmt_bind_param($stmt, $param_types, ...$search_params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


$count_sql = "SELECT COUNT(*) AS total FROM data_barang WHERE kategori = 'Barang Bergerak (Kendaraan)' $search_query ";
$count_stmt = mysqli_prepare($conn, $count_sql);

if (!empty($search_query)) {
    mysqli_stmt_bind_param($count_stmt, substr($param_types, 0, -2), ...array_slice($search_params, 0, -2)); // Only bind search params
}

// Query untuk mengambil kendaraan yang status pajaknya belum lunas
$query_unpaid_tax = "SELECT * FROM data_barang WHERE kategori = 'Barang Bergerak (Kendaraan)' AND status_stnk = 'Belum Lunas'";
$result_unpaid_tax = mysqli_query($conn, $query_unpaid_tax);

// Menyimpan hasil query dalam array
$unpaid_tax_vehicles = [];
while ($row = mysqli_fetch_assoc($result_unpaid_tax)) {
    $unpaid_tax_vehicles[] = $row;
}

// Menentukan jumlah kendaraan yang pajaknya belum lunas
$count_unpaid_tax = count($unpaid_tax_vehicles);


// Query untuk mengambil kendaraan yang status no polisi tidak aktif
$query_unpaid_tax2 = "SELECT * FROM data_barang WHERE kategori = 'Barang Bergerak (Kendaraan)' AND status_no_polisi = 'Tidak aktif'";
$result_unpaid_tax2 = mysqli_query($conn, $query_unpaid_tax2);

// Menyimpan hasil query dalam array
$unpaid_tax_vehicles2 = [];
while ($row = mysqli_fetch_assoc($result_unpaid_tax2)) {
    $unpaid_tax_vehicles2[] = $row;
}

// Menentukan jumlah kendaraan yang no polisi tidak aktif
$count_unpaid_tax2 = count($unpaid_tax_vehicles2);





mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);

$end = min($start + $limit, $total_records);
$showing_text = "Menampilkan " . ($start + 1) . " hingga " . $end . " dari " . $total_records . " entri";

$offset = $start;
$no = $offset + 1;

$visible_pages = 3;
$start_page = max(1, $page - floor($visible_pages / 2));
$end_page = min($total_pages, $page + floor($visible_pages / 2));

if ($page <= ceil($visible_pages / 2)) {
    $end_page = min($total_pages, $visible_pages);
}
if ($page > $total_pages - floor($visible_pages / 2)) {
    $start_page = max(1, $total_pages - $visible_pages + 1);
}
?>