<?php
include 'koneksi/koneksi.php'; // Koneksi ke database

$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 20;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$start = ($page - 1) * $limit;

$search_query = "";
$search_params = [];
$param_types = "";

if (!empty($_GET['query'])) {
  $search = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';
  $search_query = "WHERE b.nama_barang LIKE ? OR b.kode_barang LIKE ? OR b.id_barang_pemda LIKE ?";
  $search_params = [$search, $search, $search, $search];
  $param_types = "ssss";
}

$id_lokasi = isset($_GET['id_lokasi']) ? $_GET['id_lokasi'] : 0;

$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '';

// Query untuk mendapatkan nama_lokasi berdasarkan id_lokasi
$query_lokasi = "SELECT bid_lokasi FROM lokasi WHERE id_lokasi = ?";
$stmt_lokasi = mysqli_prepare($conn, $query_lokasi);
mysqli_stmt_bind_param($stmt_lokasi, "s", $id_lokasi);
mysqli_stmt_execute($stmt_lokasi);
$result_lokasi = mysqli_stmt_get_result($stmt_lokasi);
$nama_ruang = mysqli_fetch_assoc($result_lokasi)['bid_lokasi'] ?? '';

// Query untuk mendapatkan data barang dengan atau tanpa tanggal
if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
  $query = "SELECT b.id_barang_pemda, b.kode_barang, b.nama_barang, b.kategori, b.merk, b.no_pabrik, b.ukuran_CC, 
              b.bahan, b.tgl_pembelian, b.harga_awal, b.kondisi_barang 
              FROM data_barang b
              WHERE b.id_ruang_sekarang = ? 
              AND b.tgl_pembelian BETWEEN ? AND ? $search_query
              LIMIT ?, ?";
  $param_types = "sssii";
  $search_params = array_merge([$id_lokasi, $tanggal_mulai, $tanggal_akhir], $search_params, [$start, $limit]);
} else {
  $query = "SELECT b.id_barang_pemda, b.kode_barang, b.nama_barang, b.kategori, b.merk, b.no_pabrik, b.ukuran_CC, 
              b.bahan, b.tgl_pembelian, b.harga_awal, b.kondisi_barang  
              FROM data_barang b
              WHERE b.id_ruang_sekarang = ? $search_query
              LIMIT ?, ?";
  $param_types = "sii";
  $search_params = array_merge([$id_lokasi], $search_params, [$start, $limit]);
}

$stmt = mysqli_prepare($conn, $query);

if (!empty($param_types) && !empty($search_params)) {
  mysqli_stmt_bind_param($stmt, $param_types, ...$search_params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$count_sql = "SELECT COUNT(*) AS total FROM data_barang b WHERE b.id_ruang_sekarang = ? $search_query";
$count_stmt = mysqli_prepare($conn, $count_sql);
$count_param_types = "s";
$count_search_params = [$id_lokasi];
if (!empty($search_query)) {
  $count_param_types .= "s";
  $count_search_params[] = $search;
}
mysqli_stmt_bind_param($count_stmt, $count_param_types, ...$count_search_params);
mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);

$range = 2;
$start_page = max(1, $page - $range);
$end_page = min($total_pages, $page + $range);
?>