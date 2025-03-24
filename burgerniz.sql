-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2025 at 08:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `burgerniz`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu_burger`
--

CREATE TABLE `menu_burger` (
  `kode_burger` int(100) NOT NULL,
  `nama_burger` varchar(100) NOT NULL,
  `harga` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_burger`
--

INSERT INTO `menu_burger` (`kode_burger`, `nama_burger`, `harga`) VALUES
(1, 'Orniz', 20000),
(2, 'Blapaniz', 35000),
(3, 'Valoniz', 50000),
(4, 'Baniz', 25000),
(5, 'Dodaaniz', 35000),
(6, 'Veniz', 65000),
(7, 'Chiniz', 39000),
(8, 'Alieniz', 150000);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `kode_pesanan` int(10) NOT NULL,
  `nama_burger` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `tanggal_pesanan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`kode_pesanan`, `nama_burger`, `harga`, `kuantitas`, `total_harga`, `tanggal_pesanan`) VALUES
(27, 'Alieniz', 150000, 1, 150000, '2025-03-16 15:40:32'),
(28, 'Veniz', 65000, 1, 65000, '2025-03-16 15:52:42'),
(29, 'Alieniz', 150000, 2, 300000, '2025-03-16 15:52:42'),
(30, 'Orniz', 20000, 2, 40000, '2025-03-16 15:52:42'),
(31, 'Orniz', 20000, 1, 20000, '2025-03-19 01:39:37'),
(32, 'Dodaaniz', 35000, 2, 70000, '2025-03-19 01:39:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu_burger`
--
ALTER TABLE `menu_burger`
  ADD PRIMARY KEY (`kode_burger`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`kode_pesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu_burger`
--
ALTER TABLE `menu_burger`
  MODIFY `kode_burger` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `kode_pesanan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
