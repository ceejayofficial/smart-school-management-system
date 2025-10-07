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
-- Table structure for table `sms_results`
--

CREATE TABLE `sms_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `semester` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('success','failed') DEFAULT 'failed',
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sms_results`
--

INSERT INTO `sms_results` (`id`, `user_id`, `phone`, `student_name`, `semester`, `message`, `status`, `sent_at`) VALUES
(53, 3, '233550190460', 'My Name', 'Term 3', 'Hi, your ward My Name\'s results for Term 3 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nPromoted to: JHS2\nView: http://localhost/view_result.php?ref=233550190460', 'success', '2025-07-19 10:40:57'),
(60, 3, '233550190460', 'My Name', 'Term 2', 'Hi, your ward My Name\'s results for Term 2 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nView: http://localhost/view_result.php?ref=233550190460', 'success', '2025-07-19 15:57:17'),
(61, 4, '233550190460', 'My Name', 'Term 2', 'Hi, your ward My Name\'s results for Term 2 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nView: http://localhost/view_result.php?ref=233550190460', 'success', '2025-07-19 16:15:08'),
(62, 4, '233544505209', 'My Name', 'Term 2', 'Hi, your ward My Name\'s results for Term 2 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nView: http://localhost/view_result.php?ref=233544505209', 'success', '2025-07-19 16:59:30'),
(63, 4, '233550190460', 'My Name', 'Term 2', 'Hi, your ward My Name\'s results for Term 2 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nPromoted to: JHS3\nView: http://localhost/view_result.php?ref=233550190460', 'success', '2025-07-21 07:17:55'),
(64, 19, '233550190460', 'My Name', 'Term 2', 'Hi, your ward My Name\'s results for Term 2 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nPromoted to: JHS3\nView: http://localhost/view_result.php?ref=233550190460', 'success', '2025-07-28 12:29:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sms_results`
--
ALTER TABLE `sms_results`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sms_results`
--
ALTER TABLE `sms_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
