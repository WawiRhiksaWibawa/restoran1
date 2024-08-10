-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2024 at 01:14 PM
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
-- Database: `restoran`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` varchar(200) NOT NULL,
  `kode_menu` varchar(200) NOT NULL,
  `nama_menu` varchar(200) NOT NULL,
  `gambar_menu` varchar(200) NOT NULL,
  `deskripsi_menu` longtext NOT NULL,
  `harga_menu` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `kode_menu`, `nama_menu`, `gambar_menu`, `deskripsi_menu`, `harga_menu`, `created_at`) VALUES
('28697684e9', 'MEVI-8207', 'Sashimi Set', 'SASHIMI-SET.jpg', 'sashimi', '70000', '2024-08-06 12:48:34.023681'),
('397274fa18', 'URCV-3295', 'Miso Soup', 'MISO-SOUP-2.jpg', 'miso', '30000', '2024-08-06 12:48:15.338755'),
('481ee963ff', 'HWYI-2018', 'Sunrise Mojito', 'SUNRISE-MOJITO-1.jpg', 'mojito', '15000', '2024-08-09 10:42:01.033044'),
('89beaac6fa', 'XQPW-4873', 'Ocha', 'OCHA.jpg', 'afafa', '10000', '2024-08-08 03:57:40.930615'),
('a986a59b10', 'MVCS-3492', 'Blue Ocean', 'BLUE-OCEAN.jpg', 'afafafaefafafafafa', '20000', '2024-08-02 11:53:23.020829'),
('cede744f49', 'JKLU-7109', 'Unagi Shrimp Roll ', 'unagi.jpg', 'unagiiiiiiii', '50000', '2024-08-01 07:44:11.569140'),
('e9b64fae11', 'BUDT-4091', 'Tempura Karage', 'TEMPURA-KARAGE.jpg', 'tempuraaaa', '20000', '2024-08-06 12:48:00.498457');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` varchar(200) NOT NULL,
  `kode_pembayaran` varchar(200) DEFAULT NULL,
  `kode_pesanan` varchar(200) NOT NULL,
  `id_pelanggan` varchar(200) NOT NULL,
  `harga_pembayaran` varchar(200) NOT NULL,
  `metode_pembayaran` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `id_users` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` varchar(200) NOT NULL,
  `kode_pesanan` varchar(200) NOT NULL,
  `nama_user` varchar(200) NOT NULL,
  `id_menu` varchar(200) NOT NULL,
  `nama_menu` varchar(200) NOT NULL,
  `harga_menu` varchar(200) NOT NULL,
  `jumlah_menu` varchar(200) NOT NULL,
  `status_pesanan` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `status_menu` varchar(50) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reset_pw`
--

CREATE TABLE `reset_pw` (
  `reset_id` int(20) NOT NULL,
  `reset_code` varchar(200) NOT NULL,
  `reset_token` varchar(200) NOT NULL,
  `reset_email` varchar(200) NOT NULL,
  `reset_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reset_pw`
--

INSERT INTO `reset_pw` (`reset_id`, `reset_code`, `reset_token`, `reset_email`, `reset_status`, `created_at`) VALUES
(1, '63KU9QDGSO', '4ac4cee0a94e82a2aedc311617aa437e218bdf68', 'sysadmin@icofee.org', 'Pending', '2020-08-17 15:20:14.318643');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama_user` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','pelanggan','kasir','koki') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `email`, `nama_user`, `password`, `user_type`, `created_at`) VALUES
(1, 'admin@gmail.com', 'admin', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 'admin', '2024-08-08 03:22:40'),
(2, 'pelanggan@gmail.com', 'pelanggan', '6441e963ef204911e4cb5032d5c2398025372868', 'pelanggan', '2024-08-08 03:22:40'),
(3, 'kasir@gmail.com', 'kasir', '22a44e2ff721590111588f73cbb865dd8079d9ab', 'kasir', '2024-08-08 03:22:40'),
(4, 'koki@gmail.com', 'koki', '26db3141dfa7e002f0f34ed9a53c2e909e072dac', 'koki', '2024-08-08 03:22:40'),
(14, 'alwi@gmail.com', 'alwi', '34c08aef4e92e6cb2f873e16ce0b93387a071a1b', 'pelanggan', '2024-08-09 10:38:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `order` (`kode_pesanan`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `ProductOrder` (`id_menu`),
  ADD KEY `fk_users_pesanan` (`id_users`);

--
-- Indexes for table `reset_pw`
--
ALTER TABLE `reset_pw`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reset_pw`
--
ALTER TABLE `reset_pw`
  MODIFY `reset_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `ProductOrder` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_pesanan` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
