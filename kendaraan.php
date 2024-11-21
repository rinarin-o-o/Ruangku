<?php
include("component/header.php");
include("proses/kendaraan/get_data_kendaraan.php");
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Kendaraan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
                <li class="breadcrumb-item">Penggunaan</li>
                <li class="breadcrumb-item active">Kendaraan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="card">
        <div class="card-body" style="padding-top: 20px;">
            <div class="table-responsive">
                <table class="table table-bordered" style="font-size: 14px;">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th scope="col" style="width: 5%;">No</th>
                            <th scope="col" style="width: 10%;">ID Pemda</th>
                            <th scope="col" style="width: 20%;">Kendaraan</th>
                            <th scope="col" style="width: 15%;">No Polisi</th>
                            <th scope="col" style="width: 15%;">Pengguna</th>
                            <th scope="col" style="width: 20%;">Status Pajak</th>
                            <th scope="col" style="width: 20%;">Status Aktif</th>
                            <th scope="col" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr class='text-center'>";
                            echo "<th scope='row'>{$no}</th>";
                            echo "<td>{$row['id_barang_pemda']}</td>";
                            echo "<td>{$row['nama_barang']}</td>";
                            echo "<td>{$row['no_polisi']}</td>";
                            echo "<td>{$row['pengguna']}</td>";
                            if ($row['status_stnk'] == 'Lunas') {
                                echo "<td><span class='badge rounded-pill bg-success'>{$row['status_stnk']}</span></td>";
                            } else {
                                echo "<td><span class='badge rounded-pill bg-danger'>{$row['status_stnk']}</span></td>";
                            }
                            if ($row['status_no_polisi'] == 'Aktif') {
                                echo "<td><span class='badge rounded-pill bg-success'>{$row['status_no_polisi']}</span></td>";
                            } else {
                                echo "<td><span class='badge rounded-pill bg-danger'>{$row['status_no_polisi']}</span></td>";
                            }
                            echo "<td>
                    <a href='frm_edit_kendaraan.php?id_barang_pemda={$row['id_barang_pemda']}' class='btn btn-warning btn-sm' title='Edit'>
                    <i class='bi bi-pencil'></i>
                    </a>
                    </td>";
                            echo "</tr>";
                            $no++;
                        }
                        ?>


                    </tbody>
                </table>
                <?php if ($total_records > $limit) : ?>
                    <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                        <ul class="pagination">
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= ($page > 1) ? ($page - 1) : 1 ?><?= isset($_GET['filter']) ? '&filter=' . $_GET['filter'] : '' ?>" aria-label="Sebelumnya" title="Sebelumnya">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>

                            <?php
                            if ($start_page > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            for ($i = $start_page; $i <= $end_page; $i++) {
                                echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">';
                                echo '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
                                echo '</li>';
                            }
                            if ($end_page < $total_pages) {
                                if ($end_page < $total_pages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                            }
                            ?>

                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= ($page < $total_pages) ? ($page + 1) : $total_pages ?><?= isset($_GET['filter']) ? '&filter=' . $_GET['filter'] : '' ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div> <!-- end table -->
        </div>
    </div> <!-- card lokasi -->
</main>

<?php include("component/footer.php"); ?>