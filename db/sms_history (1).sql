-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2025 at 07:29 AM
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
-- Database: `sms-sender`
--

-- --------------------------------------------------------

--
-- Table structure for table `sms_history`
--

CREATE TABLE `sms_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipient` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `status` enum('success','failed') NOT NULL,
  `response` text DEFAULT NULL,
  `sms_limit` int(11) DEFAULT NULL,
  `sms_used` int(11) DEFAULT 0,
  `sent_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sms_history`
--

INSERT INTO `sms_history` (`id`, `user_id`, `recipient`, `message`, `status`, `response`, `sms_limit`, `sms_used`, `sent_at`) VALUES
(135, 19, '-', '-', 'success', 'Free SMS assigned', 1, 0, '2025-08-16 14:47:47'),
(136, 19, '0550190460', 'Hello, testing', 'success', '{\"status\":\"success\",\"code\":\"2000\",\"message\":\"messages sent successfully\",\"summary\":{\"_id\":\"7CB7B510-B03B-4C2F-B7EF-4BD7CDE9457E\",\"message_id\":\"20250816233550190460V2\",\"type\":\"API QUICK SMS\",\"total_sent\":1,\"contacts\":1,\"total_rejected\":0,\"numbers_sent\":[\"0550190460\"],\"credit_used\":1,\"credit_left\":1174}}', 1, 1, '2025-08-16 14:47:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sms_history`
--
ALTER TABLE `sms_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sms_history`
--
ALTER TABLE `sms_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
