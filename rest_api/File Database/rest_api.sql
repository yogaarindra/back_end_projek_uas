-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2025 at 04:08 AM
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
-- Database: `rest_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `prodi` enum('Sistem Informasi','Teknologi Informasi','Sistem Komputer','Bisnis Digital') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nama`, `prodi`) VALUES
(1, 'Jane Smith', 'Sistem Informasi'),
(2, 'Alice', 'Teknologi Informasi'),
(3, 'Martha', 'Sistem Komputer'),
(4, 'Janet', 'Bisnis Digital'),
(5, 'Monika', 'Sistem Informasi');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('superadmin','user') NOT NULL DEFAULT 'user',
  `auth_token` varchar(255) DEFAULT NULL,
  `expired_token` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `auth_token`, `expired_token`) VALUES
(1, 'Johndoe', '$2y$10$qAy/5WI3dKfkeERwaXULYe71zgAtGRjMBFUYXQvTpcjxo/HL9Lv.K', 'superadmin', NULL, NULL),
(2, 'JaneSmith', '$2y$10$M7kXUm.HhkdX5n325viB5O2ljvBrA.rFn0KdzaLVuzJjkclTItmeq', 'user', NULL, NULL),
(3, 'Aliceee', '$2y$10$dV91R54r3TKdpVjjKGLKJOMqIzu02FV9h1akd4n4/CMA5snbHOThu', 'user', NULL, NULL),
(4, 'MarthaSkye', '$2y$10$JqlpWKgJUb8PVWKj2s8HOeBxqr5tuhxUx8O5dT7KpR20D/6fp3QQK', 'user', NULL, NULL),
(5, 'JanetSintia', '$2y$10$y547YKyNfcLIVHlTpZ5SDeZaWR3MleongnedkeoX0R6heRCHgQjrq', 'user', NULL, NULL),
(6, 'Monikarisma', '$2y$10$0dqP6cLbjWMFjcrGMuUdNOkXk1ZFrB1sV2G0RzrDBvgUH96/2kMUS', 'user', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `auth_token` (`auth_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
