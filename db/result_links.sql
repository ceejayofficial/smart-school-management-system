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
-- Table structure for table `result_links`
--

CREATE TABLE `result_links` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `ref_code` varchar(50) DEFAULT NULL,
  `full_message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `result_links`
--

INSERT INTO `result_links` (`id`, `user_id`, `phone`, `ref_code`, `full_message`, `created_at`) VALUES
(1, 3, '233550190460', 'bba86d084191', 'Hi, your ward My Name\'s results for Term 3 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nPromoted to: JSH 2\nView: /view_result.php?ref=bba86d084191', '2025-07-19 08:21:10'),
(2, 3, '233550190460', 'f1864baec179', 'Hi, your ward My Name\'s results for Term 3 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nPromoted to: JSH 2\nView: /view_result.php?ref=f1864baec179', '2025-07-19 08:22:33'),
(3, 3, '233550190460', 'a9dcb083556c', 'Hi, your ward My Name\'s results for Term 3 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nPromoted to: JSH 2\nView: https://smssmartsender.com/view_result.php?ref=a9dcb083556c', '2025-07-19 08:24:40'),
(4, 3, '233550190460', 'fea8a5cbec28', 'Hi, your ward My Name\'s results for Term 3 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nView: https://smssmartsender.com/view_result.php?ref=fea8a5cbec28', '2025-07-19 08:25:22'),
(5, 3, '233550190460', '6790d6285d03', 'Hi, your ward My Name\'s results for Term 3 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nView: https://smssmartsender.com/view_result.php?ref=6790d6285d03', '2025-07-19 08:26:30'),
(6, 3, '233550190460', '2a9a35037483', 'Hi, your ward My Name\'s results for Term 3 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nView: http://localhost/view_result.php?ref=2a9a35037483', '2025-07-19 08:31:13'),
(7, 3, '233550190460', 'efbc02d29bbd', 'Hi, your ward My Name\'s results for Term 3 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nView: http://localhost/view_result.php?ref=233550190460', '2025-07-19 08:43:58'),
(8, 3, '233550190460', '3009f5615ee0', 'Hi, your ward My Name\'s results for Term 3 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nPromoted to: JHS2\nView: http://localhost/view_result.php?ref=233550190460', '2025-07-19 10:40:57'),
(9, 3, '233551868454', '885a4f71f1d7', 'Hi, your ward Testing\'s results for Term 2 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nView: http://localhost/view_result.php?ref=233551868454', '2025-07-19 11:49:44'),
(10, 3, '233550190460', 'dc4846093e16', 'Hi, your ward My Name\'s results for Term 2 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nView: http://localhost/view_result.php?ref=233550190460', '2025-07-19 15:35:25'),
(11, 3, '233550190460', '483113ce1ba5', 'Hi, your ward My Name\'s results for Term 2 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nView: http://localhost/view_result.php?ref=233550190460', '2025-07-19 15:38:58'),
(12, 3, '233550190460', '7304fb47d649', 'Hi, your ward My Name\'s results for Term 2 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nView: http://localhost/view_result.php?ref=233550190460', '2025-07-19 15:57:17'),
(13, 3, '233550190460', '531e17dad283', 'Hi, your ward My Name\'s results for Term 2 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nView: http://localhost/view_result.php?ref=233550190460', '2025-07-19 16:15:08'),
(14, 3, '233544505209', 'cc6928e334cb', 'Hi, your ward My Name\'s results for Term 2 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nView: http://localhost/view_result.php?ref=233544505209', '2025-07-19 16:59:30'),
(15, 3, '233550190460', 'b2600a16980f', 'Hi, your ward My Name\'s results for Term 2 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nPromoted to: JHS3\nView: http://localhost/view_result.php?ref=233550190460', '2025-07-21 07:17:55'),
(16, 19, '233550190460', 'f31d35a5904b', 'Hi, your ward My Name\'s results for Term 2 are:\nENGLISH: 85\nRME: 78\nMATH: 90\nSCIENCE: 88\nICT: 84\nENGLISH: 87.4\nFANTE: 88.2\nSOCIAL: 89\nBDT: 89.8\nFRENCH: 90.6\nPromoted to: JHS3\nView: http://localhost/view_result.php?ref=233550190460', '2025-07-28 12:29:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `result_links`
--
ALTER TABLE `result_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ref_code` (`ref_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `result_links`
--
ALTER TABLE `result_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
