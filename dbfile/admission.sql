-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 08:36 AM
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
-- Database: `admission`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deduplication_logs`
--

CREATE TABLE `deduplication_logs` (
  `id` int(11) NOT NULL,
  `new_applicant_id` int(11) NOT NULL,
  `matched_applicant_id` int(11) NOT NULL,
  `match_reason` text DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deduplication_logs`
--

INSERT INTO `deduplication_logs` (`id`, `new_applicant_id`, `matched_applicant_id`, `match_reason`, `score`, `created_at`) VALUES
(1, 14, 10, 'Same full address, Already applied this year', 200, '2025-09-06 08:12:18'),
(2, 14, 11, 'Same full address, Already applied this year', 200, '2025-09-06 08:12:18'),
(3, 14, 12, 'Same full address, Already applied this year', 200, '2025-09-06 08:12:18'),
(4, 14, 13, 'Same full address, Already applied this year', 200, '2025-09-06 08:12:18'),
(5, 17, 16, 'Same full name and birthday, Same full name and barangay, Same birthday and barangay, Already applied this year', 350, '2025-09-06 08:14:31'),
(6, 18, 16, 'Same full name and barangay, Same full address, Already applied this year', 270, '2025-09-06 08:15:16'),
(7, 18, 17, 'Same full name and barangay, Same full address, Already applied this year', 270, '2025-09-06 08:15:16'),
(8, 19, 18, 'Same birthday and barangay, Same full address', 140, '2025-09-06 08:15:25'),
(9, 19, 17, 'Same birthday and barangay, Same full address', 140, '2025-09-06 08:15:25'),
(10, 20, 19, 'Same full name and birthday, Same full name and barangay, Same birthday and barangay, Same full address, Already applied this year', 430, '2025-09-06 08:15:49'),
(11, 20, 18, 'Same full name and birthday, Same full name and barangay, Same birthday and barangay, Same full address, Already applied this year', 430, '2025-09-06 08:15:49'),
(12, 20, 17, 'Same full name and birthday, Same full name and barangay, Same birthday and barangay, Same full address, Already applied this year', 430, '2025-09-06 08:15:49'),
(13, 21, 19, 'Same full name and birthday, Same full name and barangay, Same birthday and barangay, Same full address, Already applied this year', 1080, '2025-09-06 08:22:09'),
(14, 21, 20, 'Same full name and birthday, Same full name and barangay, Same birthday and barangay, Same full address, Already applied this year', 1080, '2025-09-06 08:22:09'),
(15, 21, 18, 'Same birthday and barangay, Same full address', 1080, '2025-09-06 08:22:09'),
(16, 21, 17, 'Same full address', 1080, '2025-09-06 08:22:09'),
(17, 22, 16, 'Same full address, Already applied this year', 440, '2025-09-06 08:24:23'),
(18, 22, 17, 'Already applied this year', 440, '2025-09-06 08:24:23'),
(19, 22, 18, 'Already applied this year', 440, '2025-09-06 08:24:23');

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

CREATE TABLE `email_config` (
  `id` int(145) NOT NULL,
  `email` varchar(145) DEFAULT NULL,
  `password` varchar(145) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_config`
--

INSERT INTO `email_config` (`id`, `email`, `password`, `created_at`, `updated_at`) VALUES
(2, 'tupadstarita00@gmail.com', 'euxp mhwh vtri xvpe', '2024-09-24 14:23:13', '2025-09-06 08:52:25');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(14) NOT NULL,
  `user_id` int(14) NOT NULL,
  `activity` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `activity`, `created_at`) VALUES
(79, 62, 'Has Successfully Signed In', '2025-07-27 04:55:42'),
(80, 62, 'Has Successfully Signed In', '2025-07-27 05:01:25'),
(81, 62, 'Has Successfully Signed In', '2025-07-27 05:05:41'),
(82, 62, 'Has Successfully Signed In', '2025-07-27 05:17:38'),
(83, 62, 'Has Successfully Signed In', '2025-07-27 05:19:52'),
(84, 62, 'Has Successfully Signed In', '2025-07-27 05:27:55'),
(85, 62, 'Has Successfully Signed In', '2025-07-28 10:25:32'),
(86, 62, 'Has Successfully Signed In', '2025-07-30 07:22:13'),
(87, 62, 'Has Successfully Signed In', '2025-07-30 09:29:01'),
(88, 62, 'Has Successfully Signed In', '2025-07-30 09:30:47'),
(89, 62, 'Has Successfully Signed In', '2025-09-01 07:12:58'),
(90, 62, 'Has Successfully Signed In', '2025-09-03 07:14:57'),
(91, 62, 'Has Successfully Signed In', '2025-09-03 07:35:29'),
(92, 62, 'Has Successfully Signed In', '2025-09-03 07:54:26'),
(93, 62, 'Has Successfully Signed In', '2025-09-03 08:31:27'),
(94, 62, 'Has Successfully Signed In', '2025-09-06 06:14:45'),
(95, 62, 'Has Successfully Signed In', '2025-09-06 08:58:46');

-- --------------------------------------------------------

--
-- Table structure for table `tupad_applications`
--

CREATE TABLE `tupad_applications` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `birth_date` date NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `employment_status` varchar(100) NOT NULL,
  `income_level` varchar(100) NOT NULL,
  `income_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `barangay` varchar(100) DEFAULT NULL,
  `status` varchar(30) DEFAULT 'Pending',
  `program_year` int(11) DEFAULT NULL,
  `full_name_norm` varchar(255) DEFAULT NULL,
  `address_norm` varchar(255) DEFAULT NULL,
  `barangay_norm` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tupad_applications`
--

INSERT INTO `tupad_applications` (`id`, `full_name`, `address`, `birth_date`, `phone_number`, `employment_status`, `income_level`, `income_amount`, `created_at`, `barangay`, `status`, `program_year`, `full_name_norm`, `address_norm`, `barangay_norm`) VALUES
(23, 'Alan John C. Capati', '186, songco st., dampe, floridablanca, pampanga', '2004-12-21', '09128540863', 'Unemployed', 'Below minimum wage', 8000.00, '2025-09-06 08:28:04', 'Becuran', 'Unique', NULL, NULL, NULL, NULL),
(24, 'Alan B. Capati', '185, songco st., dampe, floridablanca, pampanga', '1969-08-14', '09299530404', 'Unemployed', 'Below minimum wage', 8000.00, '2025-09-06 08:30:05', 'Becuran', 'Unique', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(400) DEFAULT NULL,
  `status` enum('not_active','active') NOT NULL DEFAULT 'not_active',
  `tokencode` varchar(400) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(64) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `status`, `tokencode`, `created_at`, `reset_token`, `token_expiry`) VALUES
(62, 'alan', 'ajjohn152129@gmail.com', '202cb962ac59075b964b07152d234b70', 'active', NULL, '2025-07-27 04:55:29', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deduplication_logs`
--
ALTER TABLE `deduplication_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tupad_applications`
--
ALTER TABLE `tupad_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deduplication_logs`
--
ALTER TABLE `deduplication_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `tupad_applications`
--
ALTER TABLE `tupad_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
