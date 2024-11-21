<?php
include('koneksi/koneksi.php');
// Include library Twilio
require __DIR__ . '/vendor/autoload.php';

use Twilio\Rest\Client;

// Twilio Credentials
$sid = 'AC2c6ce63072b5e78fe44c9f9b271d7884';
$token = '7e3ed6ea6654ca2da9584a47b3a9a320';
$twilio_number = '+6285719387201';
$admin_number = '+6285771583145'; // Gunakan format internasional


// Query data kendaraan
$query = "SELECT id_barang_pemda, nama_barang, masa_stnk 
          FROM data_barang 
          WHERE status_stnk = 'Belum Lunas'";
$result = mysqli_query($conn, $query);


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id_barang = $row['id_barang_pemda'];
        $nama_barang = $row['nama_barang'];
        $masa_stnk = $row['masa_stnk'];

        // Hitung sisa hari
        $tanggal_sekarang = new DateTime();
        $tanggal_masa_stnk = new DateTime($masa_stnk);
        $selisih_hari = $tanggal_sekarang->diff($tanggal_masa_stnk)->days;

        // Periksa apakah notifikasi perlu dikirim
        if (in_array($selisih_hari, [30, 8, 7, 6, 5, 4, 3, 2, 1])) {
            // Buat pesan
            $pesan = "Pengingat Pajak STNK Kendaraan:\n" .
                "ID: $id_barang\n" .
                "Nama: $nama_barang\n" .
                "Masa STNK: $masa_stnk\n" .
                "Segera lakukan pembayaran pajak sebelum habis.";

            // Kirim pesan via Twilio
            $client = new Client($sid, $token);
            try {
                $client->messages->create(
                    $admin_number, // Nomor penerima
                    [
                        'from' => $twilio_number,
                        'body' => $pesan
                    ]
                );
                echo "Pesan dikirim untuk kendaraan $nama_barang (H-$selisih_hari).\n";
            } catch (Exception $e) {
                echo "Gagal mengirim pesan: " . $e->getMessage() . "\n";
            }
        }
    }
} else {
    echo "Tidak ada kendaraan dengan pajak mendekati masa berlaku habis.\n";
}
