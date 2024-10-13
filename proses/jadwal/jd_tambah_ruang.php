<?php
include('../../koneksi/koneksi.php');
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dengan validasi dasar
    $id_lokasi = mysqli_real_escape_string($conn, $_POST['id_lokasi']);
    $nama_lokasi = mysqli_real_escape_string($conn, $_POST['nama_lokasi']);
    $tgl_mulai = mysqli_real_escape_string($conn, $_POST['tgl_mulai']);
    $waktu_mulai = mysqli_real_escape_string($conn, $_POST['waktu_mulai']);
    $tgl_selesai = mysqli_real_escape_string($conn, $_POST['tgl_selesai']);
    $waktu_selesai = mysqli_real_escape_string($conn, $_POST['waktu_selesai']);
    $acara = mysqli_real_escape_string($conn, $_POST['acara']);
    $pengguna = mysqli_real_escape_string($conn, $_POST['pengguna']); // Pastikan ini angka
    $penanggungjawab = mysqli_real_escape_string($conn, $_POST['penanggungjawab']); // Pastikan ini angka

    // Cek apakah ada ID yang duplikat
    $loop_count = 0; // Tambahkan penghitung loop
    $max_loop = 10;  // Set batas maksimal loop

    do {
        // Buat ID Pemeliharaan baru secara otomatis
        $query_max_id = "SELECT MAX(id_jadwal_ruang) AS max_id FROM jadwal_ruang";
        $result_max_id = mysqli_query($conn, $query_max_id);
        $row_max_id = mysqli_fetch_assoc($result_max_id);
        
        // Jika ada ID pemeliharaan, ambil angkanya lalu increment
        if ($row_max_id['max_id']) {
            $last_id = $row_max_id['max_id'];
            $number = (int)substr($last_id, 3) + 1; // Ambil angka setelah 'MNT' dan tambah 1
        } else {
            $number = 1; // Jika belum ada data, mulai dari 1
        }

        // Format ID menjadi 'MNT' diikuti angka 8 digit
        $new_id_jadwal_ruang = 'VHC' . str_pad($number, 8, '0', STR_PAD_LEFT);
        
        // Cek apakah ID yang dihasilkan sudah ada
        $check_query = "SELECT COUNT(*) as count FROM jadwal_ruang WHERE id_jadwal_ruang = '$new_id_jadwal_ruang'";
        $check_result = mysqli_query($conn, $check_query);
        $check_row = mysqli_fetch_assoc($check_result);
        
        $loop_count++; // Tambahkan hitungan loop
        
        // Jika sudah lebih dari batas loop, tampilkan error
        if ($loop_count > $max_loop) {
            $_SESSION['error'] = 'Gagal mendapatkan ID unik setelah beberapa percobaan.';
            header('Location: ../../jd_frm_tambah_ruang.php');
            exit();
        }
        
    } while ($check_row['count'] > 0); // Ulangi sampai mendapatkan ID yang unik

    // Query untuk memasukkan data pemeliharaan
    $query = "INSERT INTO jadwal_ruang (id_jadwal_ruang, id_lokasi, nama_lokasi, tgl_mulai, waktu_mulai, tgl_selesai, waktu_selesai, acara, pengguna, penanggungjawab)
    VALUES ('$new_id_jadwal_ruang', '$id_lokasi', '$nama_lokasi', '$tgl_mulai', '$waktu_mulai', '$tgl_selesai', '$waktu_selesai', '$acara', '$pengguna', '$penanggungjawab')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Set session success flag dan redirect ke Data_pemeliharaan.php
        $_SESSION['success'] = true;
        header('Location: ../../jadwal_ruang.php');
        exit();
    } else {
        // Tampilkan pesan error yang lebih informatif
        $_SESSION['error'] = 'Terjadi kesalahan saat menyimpan data: ' . mysqli_error($conn);
        header('Location: ../../jd_frm_tambah_ruang.php');
        exit();
    }
}

// Tutup koneksi
mysqli_close($conn);
?>
