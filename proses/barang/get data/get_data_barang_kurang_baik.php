<?php
include('koneksi/koneksi.php');
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;
$search_query = "";
$search_params = [];
$param_types = "";

if (!empty($_GET['query'])) {
    $search = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';
    $search_query = "AND (id_barang_pemda LIKE ? OR kode_barang LIKE ? OR nama_barang LIKE ?)";
    array_push($search_params, $search, $search, $search);
    $param_types .= "sss";
}

$sql_kurang = "SELECT * FROM data_barang WHERE kondisi_barang = 'Kurang Baik' $search_query LIMIT ?, ?";
$stmt_kurang = mysqli_prepare($conn, $sql_kurang);
if (!empty($_GET['query'])) {
    mysqli_stmt_bind_param($stmt_kurang, "sssii", $search, $search, $search, $start, $limit);
} else {
    mysqli_stmt_bind_param($stmt_kurang, "ii", $start, $limit);
}
mysqli_stmt_execute($stmt_kurang);
$result_kurang = mysqli_stmt_get_result($stmt_kurang);

$count_sql = "SELECT COUNT(*) AS total FROM data_barang WHERE kondisi_barang = 'Kurang Baik' $search_query";
$count_stmt = mysqli_prepare($conn, $count_sql);

if (!empty($_GET['query'])) {
    mysqli_stmt_bind_param($count_stmt, "sss", $search, $search, $search);
}

mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);

$range = 2;
$start_page = max(1, $page - $range);
$end_page = min($total_pages, $page + $range);
?>
