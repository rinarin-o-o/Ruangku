<?php include('koneksi/koneksi.php'); ?>

<!-- default -->
<?php

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search_query = "";
$search_params = [];
$param_types = "";

if (!empty($_GET['query'])) {
  $search = '%' . mysqli_real_escape_string($conn, $_GET['query']) . '%';
  $search_query = "(id_barang_pemda LIKE ? OR kode_barang LIKE ? OR nama_barang LIKE ?)";
  array_push($search_params, $search, $search, $search);
  $param_types .= "sss";
}

$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'data_barang';
switch ($active_tab) {
  case 'barang_kurang_baik':
    $tab_condition = "kondisi_barang = 'Kurang Baik'";
    break;
  case 'barang_rusak':
    $tab_condition = "kondisi_barang = 'Rusak Berat'";
    break;
  default:
    $tab_condition = "";
}

$combined_condition = "";
if ($search_query && $tab_condition) {
  $combined_condition = "WHERE $search_query AND $tab_condition";
} elseif ($search_query) {
  $combined_condition = "WHERE $search_query";
} elseif ($tab_condition) {
  $combined_condition = "WHERE $tab_condition";
}

$sql = "SELECT id_barang_pemda, kondisi_barang, keterangan, harga_awal, no_regristrasi, 
               tgl_pembelian, kode_barang, harga_total, nama_barang 
        FROM data_barang 
        $combined_condition
        LIMIT ?, ?";

$stmt = mysqli_prepare($conn, $sql);

$param_types .= "ii";
array_push($search_params, $start, $limit);

mysqli_stmt_bind_param($stmt, $param_types, ...$search_params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$count_sql = "SELECT COUNT(*) AS total FROM data_barang $combined_condition";
$count_stmt = mysqli_prepare($conn, $count_sql);

if (!empty($search_query)) {
  mysqli_stmt_bind_param($count_stmt, substr($param_types, 0, -2), ...array_slice($search_params, 0, -2));
}

mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);

$range = 2;
$start_page = max(1, $page - $range);
$end_page = min($total_pages, $page + $range);
?>

<script>
  function toggleClearButton() {
    const searchInput = document.getElementById('search-input');
    const clearButton = document.getElementById('clear-button');
    clearButton.style.display = searchInput.value ? 'inline' : 'none';
  }

  function clearSearch() {
    const searchInput = document.getElementById('search-input');
    searchInput.value = '';
    window.location.href = 'data_barang.php?tab=<?= $active_tab; ?>&limit=<?= $limit; ?>';
  }
  document.addEventListener('DOMContentLoaded', toggleClearButton);
</script>