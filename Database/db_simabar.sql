-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 13, 2024 at 01:16 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_admin` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `foto_admin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_admin`, `foto_admin`) VALUES
('ADM001', 'admindinkominfotikbbs@gmail.com', 'dinkominfotikbbs12345', 'Yoga', 'admin.png'),
('ADM002', 'admin', 'admin', 'admin', 'logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `barang_rusak`
--

CREATE TABLE `barang_rusak` (
  `id_barang_rusak` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_barang_pemda` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `kode_barang` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_barang` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `desk_kerusakan` text COLLATE utf8mb4_general_ci,
  `tgl_kerusakan` date DEFAULT NULL,
  `nama_ruang_sekarang` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bidang_ruang_sekarang` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_ruang_sekarang` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_rusak`
--

INSERT INTO `barang_rusak` (`id_barang_rusak`, `id_barang_pemda`, `kode_barang`, `nama_barang`, `desk_kerusakan`, `tgl_kerusakan`, `nama_ruang_sekarang`, `bidang_ruang_sekarang`, `tempat_ruang_sekarang`) VALUES
('RSK000001', 'PMD0000006', '1.3.2.05.003.004.006', 'Mesin Deasel', 'Rusak, tidak bisa beroperasi', '2024-09-01', 'Gudang', NULL, 'Dinkominfotik Kab. Brebes');

-- --------------------------------------------------------

--
-- Table structure for table `data_barang`
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
  `nama_ruang_sekarang` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_updated` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_barang`
--

INSERT INTO `data_barang` (`id_barang_pemda`, `kode_barang`, `nama_barang`, `no_regristrasi`, `kode_pemilik`, `id_ruang_asal`, `nama_ruang_asal`, `bidang_ruang_asal`, `tempat_ruang_asal`, `id_ruang_sekarang`, `bidang_ruang_sekarang`, `tempat_ruang_sekarang`, `tgl_pembelian`, `tgl_pembukuan`, `merk`, `type`, `kategori`, `ukuran_CC`, `no_pabrik`, `no_rangka`, `no_bpkb`, `bahan`, `no_mesin`, `no_polisi`, `kondisi_barang`, `masa_manfaat`, `harga_awal`, `harga_total`, `keterangan`, `foto_barang`, `nama_ruang_sekarang`, `is_updated`) VALUES
('PMD0000001', '1.3.2.05.003.001.001', 'Meja Kerja Pegawai Non struktural', '1', '12', '12.11.09.21.01.01.03', 'Ruang 14', 'Bidang Komunikasi dan Kehumasan', 'Dinkominfotik Kab. Brebes', '12.11.09.21.01.01.03', '', 'Dinkominfotik Kab. Brebes', '1976-01-30', '1976-01-30', 'Meja Tulis', '', 'Peralatan', '', '', '', '', 'Kayu', '', '', 'Baik', '60', 70000.00, 70000.00, '', '1325318.jpeg', 'Ruang 14', 0),
('PMD0000002', '1.3.2.05.003.001.001', 'Meja Kerja Pegawai Non struktural', '2', '12', '12.11.09.21.01.01.03', 'Ruang 14', 'Bidang Komunikasi dan Kehumasan', 'Dinkominfotik Kab. Brebes', '12.11.09.21.01.01.03', '', 'Dinkominfotik Kab. Brebes', '1976-01-30', '1976-01-30', 'Meja Tulis', '', 'Peralatan', '', '', '', '', 'Kayu', '', '', 'Rusak', '60', 70000.00, 70000.00, '', NULL, 'Ruang 14', 0),
('PMD0000003', '1.3.2.05.003.004.003', 'Meja Rapat', '1', '10', '12.11.09.21.01.01.01', 'Ruang Operasional', NULL, 'Dinkominfotik Kab. Brebes', '12.11.09.21.01.01.03', 'Bidang Komunikasi dan Kehumasan', 'Dinkominfotik Kab. Brebes', '2024-09-01', '2024-09-01', 'Meja', NULL, 'Peralatan', NULL, NULL, NULL, NULL, 'Besi', NULL, NULL, 'Baik', '100 Bulan', 79000.00, 79000.00, NULL, NULL, 'Ruang 14', 0),
('PMD0000004', '1.3.2.05.003.004.004', 'PC kantor', '1', '12', '12.11.09.21.01.01.07', 'Ruang Data Center', 'Bidang Innformatika', 'Dinkominfotik Kab. Brebes', '12.11.09.21.01.01.09', NULL, 'Dinkominfotik Kab. Brebes', '2024-05-14', '2024-06-18', 'Lenovo', NULL, 'Mesin dan Elektronik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Baik', '32 Bulan', 5000000.00, 15000000.00, NULL, NULL, 'Ruang Sekretariat', 0),
('PMD0000005', '1.3.2.05.003.004.005', 'Sepeda Motor', '1', '12', '12.11.09.21.01.01.04', 'Parkiran', NULL, 'Dinkominfotik Kab. Brebes', '12.11.09.21.01.01.04', NULL, 'Dinkominfotik Kab. Brebes', '2024-01-16', '2024-01-16', 'Honda Revo', NULL, 'kendaraan', NULL, NULL, NULL, NULL, 'Besi', NULL, 'G7890XH', 'Baik', NULL, 19000000.00, 19970000.00, NULL, NULL, 'Parkiran', 0),
('PMD0000006', '1.3.2.05.003.004.006', 'Mesin Deasel', '1', '12', '12.11.09.21.01.01.05', 'Gudang', '', 'Dinkominfotik Kab. Brebes', '12.11.09.21.01.01.04', '', 'Dinkominfotik Kab. Brebes', '2020-09-09', '2020-09-09', '', '', 'Mesin dan Elektronik', '', '', '', '', 'Besi', '', '', 'Rusak', '12', 3000000.00, 3000000.00, '', NULL, 'Parkiran', 0);

-- --------------------------------------------------------

--
-- Table structure for table `data_pemeliharaan`
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
-- Dumping data for table `data_pemeliharaan`
--

INSERT INTO `data_pemeliharaan` (`id_pemeliharaan`, `id_barang_pemda`, `kode_barang`, `desk_pemeliharaan`, `perbaikan`, `tgl_perbaikan`, `lama_perbaikan`, `biaya_perbaikan`) VALUES
('MNT0000001', 'PMD0000004', '1.3.2.05.003.004.004', 'Hardisk Rusak', 'Pembelian Hardisk', '2024-07-09', '3 hari', 1000000.00),
('MNT0000002', 'PMD0000005', '1.3.2.05.003.004.005', 'Servis', 'Pembelian Oli', '2024-05-13', '1 hari', 750000.00),
('MNT0000003', 'PMD0000005', '1.3.2.05.003.004.005', 'Servis', 'pembelian dan penggantian kampas, knalpot', '2024-08-13', '2 hari', 120000.00),
('MNT0000004', 'PMD0000005', '1.3.2.05.003.004.005', '', '', '2024-10-09', '1', 100000.00);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kendaraan`
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
-- Dumping data for table `jadwal_kendaraan`
--

INSERT INTO `jadwal_kendaraan` (`id_jadwal_kendaraan`, `id_barang_pemda`, `kendaraan`, `penanggungjawab`, `tgl_mulai`, `tgl_selesai`, `waktu_mulai`, `waktu_selesai`, `acara`, `pengguna`) VALUES
('VHC00000001', 'PMD0000005', 'Sepeda Motor Honda Revo G7890XH ', 'Kabid Humas', '2024-09-09', '2024-09-09', '13:00:00', '19:00:00', 'Berkunjung ke Radio FM', 'Bidang Komunikasi dan Kehumasan'),
('VHC00000002', 'PMD0000005', 'Sepeda Motor Honda Revo G7890XH', 'Kabid Umpeg', '2023-03-10', '2025-10-10', '07:00:00', '21:43:00', 'Bolak balik rumah', 'Pegawai D');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_ruang`
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
-- Dumping data for table `jadwal_ruang`
--

INSERT INTO `jadwal_ruang` (`id_jadwal_ruang`, `id_lokasi`, `nama_lokasi`, `penanggungjawab`, `tgl_mulai`, `tgl_selesai`, `waktu_mulai`, `waktu_selesai`, `acara`, `pengguna`) VALUES
('SPC00000001', '12.11.09.21.01.01.01', 'Ruang Operasional ', 'Sekretariat', '2024-09-09', '2024-09-09', '13:00:00', '19:00:00', 'Rapat koordinasi sosialisasi SIMABAR', 'Peserta kegiatan');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
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
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `nama_lokasi`, `bid_lokasi`, `tempat_lokasi`, `kategori_lokasi`, `desk_lokasi`) VALUES
('12.11.09.21.01.01.01', 'Ruang Operasional', NULL, 'Dinkominfotik Kab. Brebes', 'ruangan', 'Ruang operasional digunakan untuk pertemuan internal, diskusi kebijakan, rapat, dan pertemuan dengan stakeholder eksternal, serta dilengkapi dengan perangkat teknologi untuk mendukung berbagai kegiatan.'),
('12.11.09.21.01.01.02', 'Ruang tamu', NULL, 'Dinkominfotik Kab. Brebes', 'ruangan', 'Digunakan untuk menyambut dan melayani tamu, menyediakan tempat yang nyaman untuk pertemuan, diskusi, atau penerimaan pengunjung.'),
('12.11.09.21.01.01.03', 'Ruang 14', 'Bidang Komunikasi dan Kehumasan', 'Dinkominfotik Kab. Brebes', 'ruangan', 'Ruang Bid Humas'),
('12.11.09.21.01.01.04', 'Parkiran', NULL, 'Dinkominfotik Kab. Brebes', 'fasilitas_umum', 'tempat parkir'),
('12.11.09.21.01.01.05', 'Gudang', NULL, 'Dinkominfotik Kab. Brebes', 'fasilitas_umum', 'Gudang Barang'),
('12.11.09.21.01.01.06', 'Dapur', NULL, 'Dinkominfotik Kab.Brebes', 'fasilitas_umum', 'dapur'),
('12.11.09.21.01.01.07', 'Ruang Data Center', 'Bidang Informatika', 'Dinkominfotik Kab. Brebes', 'ruangan', NULL),
('12.11.09.21.01.01.08', 'Ruang Produksi', 'Bidang Komunikasi dan Kehumasan', 'Dinkominfotik Kab.Brebes', 'ruangan', NULL),
('12.11.09.21.01.01.09', 'Ruang Sekretariat', NULL, 'Dinkominfotik Kab. Brebes', 'ruangan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mutasi_barang`
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

--
-- Dumping data for table `mutasi_barang`
--

INSERT INTO `mutasi_barang` (`id_mutasi`, `id_barang_pemda`, `ruang_asal`, `ruang_tujuan`, `tgl_mutasi`, `penanggungjawab`, `kode_barang`, `nama_barang`, `jenis_mutasi`, `keterangan`) VALUES
('MTS0000001', 'PMD0000003', 'Ruang Operasional - - Dinkominfotik Kab. Brebes', 'Ruang 14 - Bidang Komunikasi dan Kehumasan - Dinkominfotik Kab. Brebes', '2024-10-09', 'Pegawai Ab', '1.3.2.05.003.004.003', 'Meja Rapat', 'Pemindahan', ''),
('MTS0000002', 'PMD0000004', 'Ruang Data Center - Bidang Innformatika - Dinkominfotik Kab. Brebes', 'Ruang Sekretariat - - Dinkominfotik Kab. Brebes', '2024-10-09', 'Pegawai B', '1.3.2.05.003.004.004', 'PC kantor', 'Pemindahan', NULL),
('MTS0000003', 'PMD0000001', 'Ruang Operasional -  - Dinkominfotik Kab. Brebes', 'Ruang Produksi - Bidang Komunikasi dan Kehumasan - Dinkominfotik Kab.Brebes', '2024-10-09', '-', '1.3.2.05.003.001.001', 'Meja Kerja Pegawai Non struktural', '', '-'),
('MTS0000004', 'PMD0000001', 'Ruang Produksi - Bidang Komunikasi dan Kehumasan - Dinkominfotik Kab.Brebes', 'Ruang 14 - Bidang Komunikasi dan Kehumasan - Dinkominfotik Kab. Brebes', '2024-10-09', '-', '1.3.2.05.003.001.001', 'Meja Kerja Pegawai Non struktural', '', '-'),
('MTS0000005', 'PMD0000006', 'Gudang -  - Dinkominfotik Kab. Brebes', 'Parkiran -  - Dinkominfotik Kab. Brebes', '2024-10-09', '-', '1.3.2.05.003.004.006', 'Mesin Deasel', '', '-'),
('MTS0000006', 'PMD0000001', 'Ruang 14 - Bidang Komunikasi dan Kehumasan - Dinkominfotik Kab. Brebes', 'Ruang Data Center - Bidang Informatika - Dinkominfotik Kab. Brebes', '2024-10-12', '-', '1.3.2.05.003.001.001', 'Meja Kerja Pegawai Non struktural', '', '-'),
('MTS0000007', 'PMD0000001', 'Ruang Data Center - Bidang Informatika - Dinkominfotik Kab. Brebes', 'Ruang Sekretariat -  - Dinkominfotik Kab. Brebes', '2024-10-12', '-', '1.3.2.05.003.001.001', 'Meja Kerja Pegawai Non struktural', '', '-'),
('MTS0000008', 'PMD0000001', 'Ruang Sekretariat -  - Dinkominfotik Kab. Brebes', 'Ruang 14 - Bidang Komunikasi dan Kehumasan - Dinkominfotik Kab. Brebes', '2024-10-12', '-', '1.3.2.05.003.001.001', 'Meja Kerja Pegawai Non struktural', '', '-');

-- --------------------------------------------------------

--
-- Table structure for table `pemilik`
--

CREATE TABLE `pemilik` (
  `Kode_pemilik` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pemilik` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemilik`
--

INSERT INTO `pemilik` (`Kode_pemilik`, `nama_pemilik`) VALUES
('10', 'Dinkominfotik Kab. Brebes'),
('12', 'Pemerintah Kab/Kota');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `barang_rusak`
--
ALTER TABLE `barang_rusak`
  ADD PRIMARY KEY (`id_barang_rusak`),
  ADD KEY `fk_barang_rusak` (`id_barang_pemda`);

--
-- Indexes for table `data_barang`
--
ALTER TABLE `data_barang`
  ADD PRIMARY KEY (`id_barang_pemda`);

--
-- Indexes for table `data_pemeliharaan`
--
ALTER TABLE `data_pemeliharaan`
  ADD PRIMARY KEY (`id_pemeliharaan`),
  ADD KEY `fk_pemeliharaan` (`id_barang_pemda`);

--
-- Indexes for table `jadwal_kendaraan`
--
ALTER TABLE `jadwal_kendaraan`
  ADD PRIMARY KEY (`id_jadwal_kendaraan`),
  ADD KEY `fk_kendaraan` (`id_barang_pemda`);

--
-- Indexes for table `jadwal_ruang`
--
ALTER TABLE `jadwal_ruang`
  ADD PRIMARY KEY (`id_jadwal_ruang`),
  ADD KEY `fk_ruang` (`id_lokasi`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `mutasi_barang`
--
ALTER TABLE `mutasi_barang`
  ADD PRIMARY KEY (`id_mutasi`),
  ADD KEY `fk_mutasi` (`id_barang_pemda`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_rusak`
--
ALTER TABLE `barang_rusak`
  ADD CONSTRAINT `fk_barang_rusak` FOREIGN KEY (`id_barang_pemda`) REFERENCES `data_barang` (`id_barang_pemda`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_pemeliharaan`
--
ALTER TABLE `data_pemeliharaan`
  ADD CONSTRAINT `fk_pemeliharaan` FOREIGN KEY (`id_barang_pemda`) REFERENCES `data_barang` (`id_barang_pemda`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `jadwal_kendaraan`
--
ALTER TABLE `jadwal_kendaraan`
  ADD CONSTRAINT `fk_kendaraan` FOREIGN KEY (`id_barang_pemda`) REFERENCES `data_barang` (`id_barang_pemda`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `jadwal_ruang`
--
ALTER TABLE `jadwal_ruang`
  ADD CONSTRAINT `fk_ruang` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `mutasi_barang`
--
ALTER TABLE `mutasi_barang`
  ADD CONSTRAINT `fk_mutasi` FOREIGN KEY (`id_barang_pemda`) REFERENCES `data_barang` (`id_barang_pemda`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
