-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 01:11 AM
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
-- Database: `documents_system_number`
--

-- --------------------------------------------------------

--
-- Table structure for table `document_log`
--

CREATE TABLE `document_log` (
  `id` int(11) NOT NULL,
  `record_date` date NOT NULL,
  `document_number` varchar(255) DEFAULT NULL,
  `document_name` varchar(255) NOT NULL,
  `signer` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `approver` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `document_log`
--

INSERT INTO `document_log` (`id`, `record_date`, `document_number`, `document_name`, `signer`, `department`, `approver`, `file_path`, `upload_date`) VALUES
(15, '2025-04-17', 'LXH/0001', 'ໃບເບີກ', 'ທ້າວ ແອ', 'ພັດທະນາອົງກອນ', 'ທ້າວ ສົມປອງ', 'uploads/ໃບສະຫຼຸບຄ່າໃຊ້ຈ່າຍ_ໂຮງໝໍຫຼັກໄຊ_Moukmany_16042025.pdf', '2025-04-17 13:43:33'),
(17, '2025-04-17', 'LXH/0003', 'ໃບເບີກ', 'ທ້າວ ແອ', 'ພັດທະນາອົງກອນ', 'ດຣ', 'uploads/WhatsApp Image 2025-04-14 at 00.44.08.jpeg', '2025-04-17 13:52:54'),
(18, '2025-04-17', 'LXH/0004', 'ໃບເບີກ', 'ທ້າວ ແອ', 'ພະຍາບານ', 'ທ້າວ ສົມປອງ', 'uploads/Attachment 1_Medical Examination Result (Submission) (2).pdf', '2025-04-17 13:57:47'),
(21, '2025-04-17', 'LXH/0005', 'ໃບອາກອນ', 'ລັດຕະນະໄຊ', 'ການເມືອງ', 'ນາຍພົນ', 'uploads/นาง วๅงนะคอน.pdf', '2025-04-17 16:26:44'),
(22, '2025-04-17', 'LXH/0006', 'ໃບອາກອນ', 'ລັດຕະນະໄຊ', 'ການເມືອງ', 'ນາຍພົນ', 'uploads/Ms Bounhieng.pdf', '2025-04-17 16:41:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `document_log`
--
ALTER TABLE `document_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `document_log`
--
ALTER TABLE `document_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
