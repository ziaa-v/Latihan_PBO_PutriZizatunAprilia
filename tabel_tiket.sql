-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2026 at 07:57 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_latihan_pbo_trpl1b_putrizizatunaprilia`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_tiket`
--

CREATE TABLE `tabel_tiket` (
  `id_tiket` int NOT NULL,
  `nama_film` varchar(100) DEFAULT NULL,
  `jadwal_tayang` datetime DEFAULT NULL,
  `jumlah_kursi` int DEFAULT NULL,
  `harga_dasar_tiket` int DEFAULT NULL,
  `jenis_studio` enum('Regular','IMAX','Velvet') DEFAULT NULL,
  `tipe_audio` varchar(50) DEFAULT NULL,
  `lokasi_baris` varchar(50) DEFAULT NULL,
  `kacamata_3d_id` varchar(50) DEFAULT NULL,
  `efek_gerak_fitur` varchar(100) DEFAULT NULL,
  `bantal_selimut_pack` varchar(50) DEFAULT NULL,
  `layanan_butler` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_tiket`
--

INSERT INTO `tabel_tiket` (`id_tiket`, `nama_film`, `jadwal_tayang`, `jumlah_kursi`, `harga_dasar_tiket`, `jenis_studio`, `tipe_audio`, `lokasi_baris`, `kacamata_3d_id`, `efek_gerak_fitur`, `bantal_selimut_pack`, `layanan_butler`) VALUES
(1, 'Avengers Endgame', '2026-06-20 13:00:00', 2, 50000, 'Regular', 'Dolby Atmos', 'A1', NULL, NULL, NULL, NULL),
(2, 'Spider-Man No Way Home', '2026-06-20 15:00:00', 3, 50000, 'Regular', 'Dolby Atmos', 'A2', NULL, NULL, NULL, NULL),
(3, 'The Batman', '2026-06-20 17:00:00', 1, 50000, 'Regular', 'Stereo', 'A3', NULL, NULL, NULL, NULL),
(4, 'Doctor Strange', '2026-06-20 19:00:00', 4, 50000, 'Regular', 'Dolby Atmos', 'A4', NULL, NULL, NULL, NULL),
(5, 'Black Panther', '2026-06-21 10:00:00', 2, 50000, 'Regular', 'Stereo', 'B1', NULL, NULL, NULL, NULL),
(6, 'Thor Love and Thunder', '2026-06-21 12:00:00', 3, 50000, 'Regular', 'Dolby Atmos', 'B2', NULL, NULL, NULL, NULL),
(7, 'Captain Marvel', '2026-06-21 14:00:00', 1, 50000, 'Regular', 'Stereo', 'B3', NULL, NULL, NULL, NULL),
(8, 'Ant-Man Quantumania', '2026-06-21 16:00:00', 2, 50000, 'Regular', 'Dolby Atmos', 'B4', NULL, NULL, NULL, NULL),
(9, 'Guardians Galaxy Vol.3', '2026-06-21 18:00:00', 4, 50000, 'Regular', 'Stereo', 'C1', NULL, NULL, NULL, NULL),
(10, 'Shang-Chi', '2026-06-21 20:00:00', 2, 50000, 'Regular', 'Dolby Atmos', 'C2', NULL, NULL, NULL, NULL),
(11, 'Avatar The Way of Water', '2026-06-22 10:00:00', 2, 80000, 'IMAX', NULL, NULL, 'IMX001', 'Motion Seat', NULL, NULL),
(12, 'Jurassic World Dominion', '2026-06-22 13:00:00', 3, 80000, 'IMAX', NULL, NULL, 'IMX002', 'Motion Seat', NULL, NULL),
(13, 'Top Gun Maverick', '2026-06-22 16:00:00', 2, 80000, 'IMAX', NULL, NULL, 'IMX003', 'Surround Vibration', NULL, NULL),
(14, 'Transformers Rise of the Beasts', '2026-06-22 19:00:00', 4, 80000, 'IMAX', NULL, NULL, 'IMX004', 'Motion Seat', NULL, NULL),
(15, 'Interstellar', '2026-06-22 21:00:00', 2, 80000, 'IMAX', NULL, NULL, 'IMX005', 'Surround Vibration', NULL, NULL),
(16, 'Titanic', '2026-06-23 10:00:00', 2, 100000, 'Velvet', NULL, NULL, NULL, NULL, 'Premium Pack', 'Ya'),
(17, 'La La Land', '2026-06-23 13:00:00', 2, 100000, 'Velvet', NULL, NULL, NULL, NULL, 'Premium Pack', 'Ya'),
(18, 'The Notebook', '2026-06-23 16:00:00', 3, 100000, 'Velvet', NULL, NULL, NULL, NULL, 'Premium Pack', 'Ya'),
(19, 'Frozen II', '2026-06-23 19:00:00', 2, 100000, 'Velvet', NULL, NULL, NULL, NULL, 'Premium Pack', 'Ya'),
(20, 'Moana', '2026-06-23 21:00:00', 4, 100000, 'Velvet', NULL, NULL, NULL, NULL, 'Premium Pack', 'Ya');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_tiket`
--
ALTER TABLE `tabel_tiket`
  ADD PRIMARY KEY (`id_tiket`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_tiket`
--
ALTER TABLE `tabel_tiket`
  MODIFY `id_tiket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
