-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 29 Okt 2024 pada 01.36
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_simabar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_admin` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `foto_admin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_admin`, `foto_admin`) VALUES
('ADM001', 'admindinkominfotikbbs@gmail.com', '$2y$10$pd.s7ifPPX9bFbMGvV1J/u/VIZho8uqwyQ9oqOitrocu7UkwI3P5O', 'Yoga', 'admin.png'),
('ADM002', 'admin', '$2y$10$pd.s7ifPPX9bFbMGvV1J/u/VIZho8uqwyQ9oqOitrocu7UkwI3P5O', 'admin', 'logo.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_barang`
--

CREATE TABLE `data_barang` (
  `id_barang_pemda` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `kode_barang` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_barang` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `no_regristrasi` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode_pemilik` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_ruang_asal` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_ruang_asal` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bidang_ruang_asal` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_ruang_asal` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_ruang_sekarang` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bidang_ruang_sekarang` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_ruang_sekarang` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_pembelian` date DEFAULT NULL,
  `tgl_pembukuan` date DEFAULT NULL,
  `merk` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ukuran_CC` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_pabrik` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_rangka` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_bpkb` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bahan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_mesin` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_polisi` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kondisi_barang` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `masa_manfaat` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `harga_awal` decimal(15,2) DEFAULT NULL,
  `harga_total` decimal(15,2) DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `foto_barang` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_ruang_sekarang` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_barang`
--

INSERT INTO `data_barang` (`id_barang_pemda`, `kode_barang`, `nama_barang`, `no_regristrasi`, `kode_pemilik`, `id_ruang_asal`, `nama_ruang_asal`, `bidang_ruang_asal`, `tempat_ruang_asal`, `id_ruang_sekarang`, `bidang_ruang_sekarang`, `tempat_ruang_sekarang`, `tgl_pembelian`, `tgl_pembukuan`, `merk`, `type`, `kategori`, `ukuran_CC`, `no_pabrik`, `no_rangka`, `no_bpkb`, `bahan`, `no_mesin`, `no_polisi`, `kondisi_barang`, `masa_manfaat`, `harga_awal`, `harga_total`, `keterangan`, `foto_barang`, `nama_ruang_sekarang`) VALUES
('21010010012000057', '1.3.2.05.001.005.003', 'Papan Visual / Papan Nama', '7', '12', 'belum17', '', 'Mall Pelayanan Publik ( Setda Lama )', 'Mall Pelayanan Publik ( Setda Lama )', 'belum17', 'Mall Pelayanan Publik ( Setda Lama )', 'Mall Pelayanan Publik ( Setda Lama )', '2017-01-30', '2017-01-30', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 60109000.00, 85000.00, '', '', ''),
('21010010012000366', '1.3.2.10.002.004.033', 'Peralatan jaringan lainnya', '4', '12', 'belum13', '', 'Kelurahan Brebes', 'Kelurahan Brebes', 'belum13', 'Kelurahan Brebes', 'Kelurahan Brebes', '2014-01-30', '2014-01-30', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 8833000.00, 0.00, '', '', ''),
('21010010012000367', '1.3.2.10.002.004.033', 'Peralatan jaringan lainnya', '5', '12', 'belum14', '', 'Kelurahan Gandasuli', 'Kelurahan Gandasuli', 'belum14', 'Kelurahan Gandasuli', 'Kelurahan Gandasuli', '2014-01-30', '2014-01-30', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 8833000.00, 0.00, '', '', ''),
('21010010012000368', '1.3.2.10.002.004.033', 'Peralatan jaringan lainnya', '6', '12', 'belum16', '', 'Kelurahan Pasarbatang', 'Kelurahan Pasarbatang', 'belum16', 'Kelurahan Pasarbatang', 'Kelurahan Pasarbatang', '2014-01-30', '2014-01-30', '', '', '', '', '', '', '', '', '', '', 'Rusak', '', 8833000.00, 0.00, '', '', ''),
('21010010012000369', '1.3.2.10.002.004.033', 'Peralatan jaringan lainnya', '7', '12', 'belum15', '', 'Kelurahan Limbanganwetan', 'Kelurahan Limbanganwetan', 'belum15', 'Kelurahan Limbanganwetan', 'Kelurahan Limbanganwetan', '2014-01-30', '2014-01-30', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 8833000.00, 0.00, '', '', ''),
('21010010012000370', '1.3.2.10.002.004.033', 'Peralatan jaringan lainnya', '8', '12', 'belum15', '', 'Kelurahan Limbanganwetan', 'Kelurahan Limbanganwetan', 'belum15', 'Kelurahan Limbanganwetan', 'Kelurahan Limbanganwetan', '2014-01-30', '2014-01-30', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 8833000.00, 0.00, '', '', ''),
('21010010012000519', '1.3.2.10.001.002.001', 'P.C Unit', '31', '12', 'belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'belum12', 'UKK Kab. Brebes', 'Kantor Imigrasi Brebes', '2018-12-28', '2018-12-28', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 12432000.00, 0.00, '', '', ''),
('21010010012000520', '1.3.2.10.001.002.001', 'P.C Unit', '32', '12', 'belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'belum12', 'UKK Kab. Brebes', 'Kantor Imigrasi Brebes', '2018-12-28', '2018-12-28', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 12432000.00, 0.00, '', '', ''),
('21010010012000521', '1.3.2.10.001.002.001', 'P.C Unit', '33', '12', 'belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'belum12', 'UKK Kab. Brebes', 'Kantor Imigrasi Brebes', '2018-12-28', '2018-12-28', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 12432000.00, 0.00, '', '', ''),
('21010010012000522', '1.3.2.10.001.002.001', 'P.C Unit', '34', '12', 'belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'belum12', 'UKK Kab. Brebes', 'Kantor Imigrasi Brebes', '2018-12-28', '2018-12-28', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 12432000.00, 0.00, '', '', ''),
('21010010012000523', '1.3.2.10.001.002.001', 'P.C Unit', '35', '12', 'belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'belum12', 'UKK Kab. Brebes', 'Kantor Imigrasi Brebes', '2018-12-28', '2018-12-28', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 12432000.00, 0.00, '', '', ''),
('21010010012000524', '1.3.2.10.001.002.001', 'P.C Unit', '36', '12', 'belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'belum12', 'UKK Kab. Brebes', 'Kantor Imigrasi Brebes', '2018-12-28', '2018-12-28', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 12432000.00, 0.00, '', '', ''),
('21010010012000525', '1.3.2.10.001.002.001', 'P.C Unit', '37', '12', 'belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'belum12', 'UKK Kab. Brebes', 'Kantor Imigrasi Brebes', '2018-12-28', '2018-12-28', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 12432000.00, 0.00, '', '', ''),
('21010010012000526', '1.3.2.10.001.002.001', 'P.C Unit', '38', '12', 'belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'belum12', 'UKK Kab. Brebes', 'Kantor Imigrasi Brebes', '2018-12-28', '2018-12-28', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 12432000.00, 0.00, '', '', ''),
('21010010012000537', '1.3.2.05.002.006.021', 'Peralatan jaringan lainnya', '9', '12', 'belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'belum12', 'UKK Kab. Brebes', 'Kantor Imigrasi Brebes', '2018-12-28', '2018-12-28', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 7500000.00, 0.00, '', '', ''),
('21010010012000538', '1.3.2.05.002.006.021', 'Peralatan jaringan lainnya', '10', '12', 'belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'belum12', 'UKK Kab. Brebes', 'Kantor Imigrasi Brebes', '2018-12-28', '2018-12-28', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 7500000.00, 0.00, '', '', ''),
('21010010012000539', '1.3.2.05.002.006.021', 'Peralatan jaringan lainnya', '11', '12', 'belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'belum12', 'UKK Kab. Brebes', 'Kantor Imigrasi Brebes', '2018-12-28', '2018-12-28', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 7500000.00, 0.00, '', '', ''),
('21010010012000540', '1.3.2.05.002.006.021', 'Peralatan jaringan lainnya', '12', '12', 'belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'belum12', 'UKK Kab. Brebes', 'Kantor Imigrasi Brebes', '2018-12-28', '2018-12-28', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 7500000.00, 0.00, '', '', ''),
('21010010012000544', '1.3.2.10.001.001.008', 'Komputer Jaringan Lainnya', '1', '12', 'belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'belum12', 'UKK Kab. Brebes', 'Kantor Imigrasi Brebes', '2018-12-28', '2018-12-28', '', '', '', '', '', '', '', '', '', '', 'Baik', '', 44435000.00, 0.00, '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pemeliharaan`
--

CREATE TABLE `data_pemeliharaan` (
  `id_pemeliharaan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_barang_pemda` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode_barang` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `desk_pemeliharaan` text COLLATE utf8mb4_general_ci,
  `perbaikan` text COLLATE utf8mb4_general_ci,
  `tgl_perbaikan` date DEFAULT NULL,
  `lama_perbaikan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `biaya_perbaikan` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_pemeliharaan`
--

INSERT INTO `data_pemeliharaan` (`id_pemeliharaan`, `id_barang_pemda`, `kode_barang`, `desk_pemeliharaan`, `perbaikan`, `tgl_perbaikan`, `lama_perbaikan`, `biaya_perbaikan`) VALUES
('MNT0000001', '21010010012000057', '1.3.2.05.001.005.003', 'rusak papannya jadi...', 'diganti papannya', '2024-10-22', '1', 13000.00),
('MNT0000002', '21010010012000057', '1.3.2.05.001.005.003', 'entah yang rusak apa', 'yang penting ganti ', '2024-10-23', '1', 16000.00),
('MNT0000003', '21010010012000057', '1.3.2.05.001.005.003', '', 'gk tau apa', '2024-10-24', '1', 56000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_kendaraan`
--

CREATE TABLE `jadwal_kendaraan` (
  `id_jadwal_kendaraan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_barang_pemda` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kendaraan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `penanggungjawab` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `acara` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `pengguna` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_kendaraan`
--

INSERT INTO `jadwal_kendaraan` (`id_jadwal_kendaraan`, `id_barang_pemda`, `kendaraan`, `penanggungjawab`, `tgl_mulai`, `tgl_selesai`, `waktu_mulai`, `waktu_selesai`, `acara`, `pengguna`) VALUES
('VHC00000001', NULL, 'Sepeda Motor Honda Revo G7890XH ', 'Kabid Humas', '2024-09-09', '2024-09-09', '13:00:00', '19:00:00', 'Berkunjung ke Radio FM', 'Bidang Komunikasi dan Kehumasan'),
('VHC00000002', NULL, 'Sepeda Motor Honda Revo G7890XH', 'Kabid Umpeg', '2023-03-10', '2025-10-10', '07:00:00', '21:43:00', 'Bolak balik rumah', 'Pegawai D');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_ruang`
--

CREATE TABLE `jadwal_ruang` (
  `id_jadwal_ruang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_lokasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_lokasi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `penanggungjawab` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `acara` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `pengguna` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_ruang`
--

INSERT INTO `jadwal_ruang` (`id_jadwal_ruang`, `id_lokasi`, `nama_lokasi`, `penanggungjawab`, `tgl_mulai`, `tgl_selesai`, `waktu_mulai`, `waktu_selesai`, `acara`, `pengguna`) VALUES
('SPC00000001', NULL, 'Ruang Operasional ', 'Sekretariat', '2024-09-09', '2024-09-09', '13:00:00', '19:00:00', 'Rapat koordinasi sosialisasi SIMABAR', 'Peserta kegiatan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lokasi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `bid_lokasi` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_lokasi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori_lokasi` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `desk_lokasi` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `nama_lokasi`, `bid_lokasi`, `tempat_lokasi`, `kategori_lokasi`, `desk_lokasi`) VALUES
('11', '12.11.09.21.01.01.01', 'Ruang Kepala Dinas', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('12', '12.11.09.21.01.01.01', 'Ruang Sekretariat Dinas', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('13', '12.11.09.21.01.01.01', 'Bidang Informatika Dan Statistik', 'Dinkominfotik Kab. Brebes', 'Ruangan', ''),
('14', '12.11.09.21.01.01.01', 'Bidang Komunikasi Dan Kehumasan ', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('15', '12.11.09.21.01.01.01', 'Sekretariat', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('16', '', 'Radio Singosari RSPD', 'Radio Singosari RSPD', 'ruangan', ''),
('17', '', 'Ruang Rapat ( singosari RSPD )', 'Radio Singosari RSPD', 'Ruangan', ''),
('18', '12.11.09.21.01.01.01', 'Ruang Produksi', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('20', '12.11.09.21.01.01.01	', 'Dapur', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('24', '12.11.09.21.01.01.01', 'Mobil Publikasi', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('25', '', 'Radio News FM', 'Radio News FM', 'ruangan', ''),
('26', '', 'Radio Top FM', 'Radio Top FM', 'ruangan', ''),
('45', '', 'Perbatasan Losari', 'Perbatasan Losari', 'ruangan', ''),
('47', '', 'Rth Taman Juang 45', 'Rth Taman Juang 45', 'ruangan', ''),
('54', '12.11.09.21.01.01.01', 'Mobil Cukai', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('55', '12.11.09.21.01.01.01', 'Operational Room', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('56', '12.11.09.21.01.01.01', 'Record Center / Arsip', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('58', '12.11.09.21.01.01.01', 'Ruang Tamu', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('belum01', '', 'Tol Pejagan Brebes', 'Tol Pejagan Brebes', 'ruangan', ''),
('belum02', '', 'Tol Brexit', 'Tol Brexit', 'ruangan', ''),
('belum03', '', 'Stadion Karangbirahi', 'Stadion Karangbirahi', 'ruangan', ''),
('belum04', '', 'Rth Taman Edukasi', 'Rth Taman Edukasi', 'ruangan', ''),
('belum05', '', 'Pertigaan Jalan Lingkar Pagojengan', 'Pertigaan Jalan Lingkar Pagojengan', 'ruangan', ''),
('belum06', '', 'Alun Alun Brebes', 'Alun Alun Brebes', 'ruangan', ''),
('belum07', '12.11.09.21.01.01.01', 'Data Centre', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('belum08', '', 'Desa Jagalempeni', 'Desa Jagalempeni', 'ruangan', ''),
('belum09', '12.11.09.21.01.01.01', 'Gudang', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('belum10', '12.11.09.21.01.01.01', 'Halaman Dinkominfotik', 'Dinkominfotik Kab. Brebes', 'ruangan', ''),
('belum11', '', 'Halaman Singosari RSPD', 'Radio Singosari RSPD', 'ruangan', ''),
('belum12', '', 'Kantor Imigrasi Brebes', 'UKK Kab. Brebes', 'ruangan', ''),
('belum13', '', 'Kelurahan Brebes', 'Kelurahan Brebes', 'ruangan', ''),
('belum14', '', 'Kelurahan Gandasuli', 'Kelurahan Gandasuli', 'ruangan', ''),
('belum15', '', 'Kelurahan Limbanganwetan', 'Kelurahan Limbanganwetan', 'ruangan', ''),
('belum16', '', 'Kelurahan Pasarbatang', 'Kelurahan Pasarbatang', 'ruangan', ''),
('belum17', '', 'Mall Pelayanan Publik ( Setda Lama )', 'Mall Pelayanan Publik ( Setda Lama )', 'ruangan', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mutasi_barang`
--

CREATE TABLE `mutasi_barang` (
  `id_mutasi` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_barang_pemda` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ruang_asal` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ruang_tujuan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_mutasi` date DEFAULT NULL,
  `penanggungjawab` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode_barang` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_barang` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_mutasi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemilik`
--

CREATE TABLE `pemilik` (
  `Kode_pemilik` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pemilik` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemilik`
--

INSERT INTO `pemilik` (`Kode_pemilik`, `nama_pemilik`) VALUES
('12', 'Pemerintah Kab/Kota');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `data_barang`
--
ALTER TABLE `data_barang`
  ADD PRIMARY KEY (`id_barang_pemda`);

--
-- Indeks untuk tabel `data_pemeliharaan`
--
ALTER TABLE `data_pemeliharaan`
  ADD PRIMARY KEY (`id_pemeliharaan`),
  ADD KEY `fk_pemeliharaan` (`id_barang_pemda`);

--
-- Indeks untuk tabel `jadwal_kendaraan`
--
ALTER TABLE `jadwal_kendaraan`
  ADD PRIMARY KEY (`id_jadwal_kendaraan`),
  ADD KEY `fk_kendaraan` (`id_barang_pemda`);

--
-- Indeks untuk tabel `jadwal_ruang`
--
ALTER TABLE `jadwal_ruang`
  ADD PRIMARY KEY (`id_jadwal_ruang`),
  ADD KEY `fk_ruang` (`id_lokasi`);

--
-- Indeks untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indeks untuk tabel `mutasi_barang`
--
ALTER TABLE `mutasi_barang`
  ADD PRIMARY KEY (`id_mutasi`),
  ADD KEY `fk_mutasi` (`id_barang_pemda`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_pemeliharaan`
--
ALTER TABLE `data_pemeliharaan`
  ADD CONSTRAINT `fk_pemeliharaan` FOREIGN KEY (`id_barang_pemda`) REFERENCES `data_barang` (`id_barang_pemda`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal_kendaraan`
--
ALTER TABLE `jadwal_kendaraan`
  ADD CONSTRAINT `fk_kendaraan` FOREIGN KEY (`id_barang_pemda`) REFERENCES `data_barang` (`id_barang_pemda`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal_ruang`
--
ALTER TABLE `jadwal_ruang`
  ADD CONSTRAINT `fk_ruang` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mutasi_barang`
--
ALTER TABLE `mutasi_barang`
  ADD CONSTRAINT `fk_mutasi` FOREIGN KEY (`id_barang_pemda`) REFERENCES `data_barang` (`id_barang_pemda`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
