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
-- Table structure for table `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender_id` varchar(20) NOT NULL,
  `contacts` text NOT NULL,
  `message` text NOT NULL,
  `status` enum('sent','failed') DEFAULT 'failed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sms_logs`
--

INSERT INTO `sms_logs` (`id`, `user_id`, `sender_id`, `contacts`, `message`, `status`, `created_at`) VALUES
(45, 19, 'GREL BASIC', '0550190460', 'Hi', 'sent', '2025-07-27 18:37:01'),
(46, 19, 'GREL BASIC', '0550190460', 'test', 'sent', '2025-07-28 09:01:11'),
(47, 19, 'GREL BASIC', '0550190460', 'HI', 'sent', '2025-07-28 09:25:44'),
(48, 19, 'GREL BASIC', '0550190460', 'test', 'sent', '2025-07-28 09:41:12'),
(49, 19, 'GREL BASIC', '0550190460', 'HI', 'sent', '2025-07-28 12:21:36'),
(50, 19, 'GREL BASIC', '0550190460', 'Hi', 'sent', '2025-07-28 12:22:51'),
(51, 19, 'GREL BASIC', '0550190460', 'hi', 'sent', '2025-07-30 00:57:10'),
(52, 19, 'GREL BASIC', '0550190460', 'hi', 'sent', '2025-07-30 00:58:37'),
(53, 19, 'GREL BASIC', '0550190460', 'hi', 'sent', '2025-07-30 01:06:36'),
(54, 19, 'GREL BASIC', '0550190460', 'hi', 'sent', '2025-07-30 01:08:07'),
(55, 19, 'GREL BASIC', '0550190460', 'Hello, testing', 'sent', '2025-08-16 14:47:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD CONSTRAINT `sms_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
