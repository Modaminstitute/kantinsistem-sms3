-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 06:26 AM
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
-- Database: `kantin_pradita_v4`
--

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `tenant_id`, `nama`, `harga`, `gambar`) VALUES
(1, 1, 'Nasi Goreng Elinco', 25000.00, 'nasi-goreng-elinco.jpg'),
(2, 1, 'Ayam Bakar Elinco', 30000.00, 'ayam-bakar.jpeg'),
(3, 1, 'Es Teh Elinco', 10000.00, 'es-teh.jpg'),
(4, 2, 'Burger Crot', 20000.00, 'burger.jpg'),
(5, 2, 'Fries Crot', 15000.00, 'fries.jpg'),
(6, 2, 'Milkshake Crot', 18000.00, 'milkshake.jpg'),
(7, 3, 'Bakmi Ayam', 22000.00, 'bakmi.jpg'),
(8, 3, 'Bakmi Goreng', 20000.00, 'mi-goreng.jpg'),
(9, 3, 'Es Jeruk Bakmi AY', 8000.00, 'es-jeruk.jpg'),
(10, 4, 'Es Teh Manis', 8000.00, 'es-teh-manis.jpg'),
(11, 4, 'Es Teh Jeruk', 10000.00, 'es-teh-jeruk.jpg'),
(12, 4, 'Es Teh Susu', 12000.00, 'es-teh-susu.jpeg'),
(13, 5, 'Kebab Ayam', 25000.00, 'chicken-kebab.jpg'),
(14, 5, 'Kebab Daging Sapi', 28000.00, 'beef-kebab.jpeg\r\n'),
(15, 5, 'Kebab Sayur', 20000.00, 'kebab-sayur.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `status` enum('Menunggu','Dikemas','Selesai') DEFAULT 'Menunggu',
  `tanggal_pemesanan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `user_id`, `menu_id`, `jumlah`, `total_harga`, `status`, `tanggal_pemesanan`) VALUES
(3, NULL, 4, 5, 100000.00, 'Menunggu', '2024-12-18 04:23:37'),
(4, NULL, 6, 2, 36000.00, 'Menunggu', '2024-12-18 04:25:12'),
(5, NULL, 6, 7, 126000.00, 'Menunggu', '2024-12-18 04:25:27'),
(6, NULL, 6, 7, 126000.00, 'Menunggu', '2024-12-18 04:33:41'),
(7, 1, 10, 1, 8000.00, 'Menunggu', '2024-12-18 04:33:56'),
(9, 1, 1, 7, 175000.00, 'Menunggu', '2024-12-18 04:55:42');

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

CREATE TABLE `tenant` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`id`, `nama`) VALUES
(1, 'Elinco'),
(2, 'Crot Brothers'),
(3, 'Bakmi AY'),
(4, 'Es Teh Nusantara'),
(5, 'Kebab Pradita');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'nicholas', '$2y$10$eGUk2EvmOwWPLFwemdOgSuZvqilAQ0T72BO7GlCzkaZTSthEaLE22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenant` (`id`);

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
