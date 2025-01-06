-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 05, 2025 at 04:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apotek`
--

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `deleted` char(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `category`, `stock`, `price`, `deleted`) VALUES
(1, 'Paracetamol', 'Pain Reliever', 50, 1000.00, ''),
(2, 'Ibuprofen', 'Pain Reliever', 30, 2000.00, ''),
(3, 'Amoxicillin', 'Antibiotic', 70, 5000.00, ''),
(4, 'Cetirizine', 'Antihistamine', 100, 1500.00, ''),
(5, 'Loperamide', 'Antidiarrheal', 20, 2500.00, ''),
(6, 'Omeprazole', 'Antacid', 40, 3000.00, ''),
(7, 'Salbutamol', 'Bronchodilator', 25, 3500.00, ''),
(8, 'Metformin', 'Diabetes', 60, 4000.00, ''),
(9, 'Amlodipine', 'Hypertension', 45, 4500.00, ''),
(10, 'Vitamin C', 'Supplement', 150, 1000.00, ''),
(11, 'Diclofenac', 'Pain Reliever', 80, 1200.00, ''),
(12, 'Ranitidine', 'Antacid', 35, 2800.00, ''),
(13, 'Ciprofloxacin', 'Antibiotic', 90, 4800.00, ''),
(14, 'Clarithromycin', 'Antibiotic', 55, 5100.00, ''),
(15, 'Azithromycin', 'Antibiotic', 85, 6000.00, ''),
(16, 'Tetracycline', 'Antibiotic', 40, 5800.00, ''),
(17, 'Doxycycline', 'Antibiotic', 95, 5700.00, ''),
(18, 'Hydrochlorothiazide', 'Diuretic', 25, 3000.00, ''),
(19, 'Losartan', 'Hypertension', 65, 3500.00, ''),
(20, 'Simvastatin', 'Cholesterol', 50, 3400.00, ''),
(21, 'Prednisolone', 'Steroid', 100, 1500.00, ''),
(22, 'Aspirin', 'Pain Reliever', 120, 900.00, ''),
(23, 'Atorvastatin', 'Cholesterol', 30, 4400.00, ''),
(24, 'Candesartan', 'Hypertension', 45, 4700.00, ''),
(25, 'Gabapentin', 'Neuropathy', 20, 3200.00, ''),
(26, 'Morphine', 'Pain Reliever', 15, 7500.00, ''),
(27, 'Furosemide', 'Diuretic', 80, 2000.00, ''),
(28, 'Clopidogrel', 'Antiplatelet', 25, 2300.00, ''),
(29, 'Spironolactone', 'Diuretic', 50, 2800.00, ''),
(30, 'Carbamazepine', 'Epilepsy', 60, 2600.00, ''),
(31, 'Valproate', 'Epilepsy', 55, 2500.00, ''),
(32, 'Loratadine', 'Antihistamine', 70, 1800.00, ''),
(33, 'Albuterol', 'Bronchodilator', 40, 3100.00, ''),
(34, 'Esomeprazole', 'Antacid', 90, 2900.00, ''),
(35, 'Warfarin', 'Anticoagulant', 35, 2200.00, ''),
(36, 'Rivaroxaban', 'Anticoagulant', 25, 5100.00, ''),
(37, 'Apixaban', 'Anticoagulant', 45, 5200.00, ''),
(38, 'Dabigatran', 'Anticoagulant', 30, 5300.00, ''),
(39, 'Enoxaparin', 'Anticoagulant', 20, 7500.00, ''),
(40, 'Metoprolol', 'Hypertension', 50, 4400.00, ''),
(41, 'Bisoprolol', 'Hypertension', 60, 4200.00, ''),
(42, 'Propranolol', 'Hypertension', 40, 4100.00, ''),
(43, 'Carvedilol', 'Hypertension', 35, 4300.00, ''),
(44, 'Lisinopril', 'Hypertension', 90, 4600.00, ''),
(45, 'Ramipril', 'Hypertension', 55, 4500.00, ''),
(46, 'Perindopril', 'Hypertension', 70, 4700.00, ''),
(47, 'Captopril', 'Hypertension', 80, 4400.00, ''),
(48, 'Enalapril', 'Hypertension', 75, 4300.00, ''),
(49, 'Nifedipine', 'Hypertension', 65, 4200.00, ''),
(50, 'Verapamil', 'Hypertension', 50, 4100.00, ''),
(51, 'Diltiazem', 'Hypertension', 55, 4300.00, ''),
(52, 'Methotrexate', 'Rheumatoid Arthritis', 20, 9500.00, ''),
(53, 'Sulfasalazine', 'Rheumatoid Arthritis', 25, 8500.00, ''),
(54, 'Hydroxychloroquine', 'Rheumatoid Arthritis', 30, 8000.00, ''),
(55, 'Chloroquine', 'Antimalarial', 40, 7500.00, ''),
(56, 'Artemether', 'Antimalarial', 35, 7200.00, ''),
(57, 'Lumefantrine', 'Antimalarial', 25, 7000.00, ''),
(58, 'Quinine', 'Antimalarial', 20, 6900.00, ''),
(59, 'Ivermectin', 'Antiparasitic', 45, 6800.00, ''),
(60, 'Albendazole', 'Antiparasitic', 60, 6700.00, ''),
(61, 'Mebendazole', 'Antiparasitic', 70, 6600.00, ''),
(62, 'Praziquantel', 'Antiparasitic', 55, 6500.00, ''),
(63, 'Clomiphene', 'Fertility', 50, 6400.00, ''),
(64, 'Letrozole', 'Fertility', 45, 6300.00, ''),
(65, 'Tamoxifen', 'Cancer', 25, 6200.00, ''),
(66, 'Anastrozole', 'Cancer', 20, 6100.00, ''),
(67, 'Exemestane', 'Cancer', 15, 6000.00, ''),
(68, 'Paclitaxel', 'Cancer', 10, 5900.00, ''),
(69, 'Docetaxel', 'Cancer', 8, 5800.00, ''),
(70, 'Doxorubicin', 'Cancer', 5, 5700.00, ''),
(71, 'Cisplatin', 'Cancer', 4, 5600.00, ''),
(72, 'Carboplatin', 'Cancer', 6, 5500.00, ''),
(73, 'Etoposide', 'Cancer', 7, 5400.00, ''),
(74, 'Imatinib', 'Cancer', 3, 5300.00, ''),
(75, 'Dasatinib', 'Cancer', 2, 5200.00, ''),
(76, 'Nilotinib', 'Cancer', 1, 5100.00, ''),
(77, 'Sorafenib', 'Cancer', 9, 5000.00, ''),
(78, 'Sunitinib', 'Cancer', 11, 4900.00, ''),
(79, 'Bevacizumab', 'Cancer', 12, 4800.00, ''),
(80, 'Trastuzumab', 'Cancer', 13, 4700.00, ''),
(81, 'Rituximab', 'Cancer', 14, 4600.00, ''),
(82, 'Cetuximab', 'Cancer', 16, 4500.00, ''),
(83, 'Panitumumab', 'Cancer', 18, 4400.00, ''),
(84, 'Fluorouracil', 'Cancer', 19, 4300.00, ''),
(85, 'Capecitabine', 'Cancer', 17, 4200.00, ''),
(86, 'Gemcitabine', 'Cancer', 22, 4100.00, ''),
(87, 'Vincristine', 'Cancer', 21, 4000.00, ''),
(88, 'Vinblastine', 'Cancer', 23, 3900.00, ''),
(89, 'Erlotinib', 'Cancer', 24, 3800.00, ''),
(90, 'Gefitinib', 'Cancer', 26, 3700.00, ''),
(91, 'Crizotinib', 'Cancer', 27, 3600.00, ''),
(92, 'Ceritinib', 'Cancer', 28, 3500.00, ''),
(93, 'Alectinib', 'Cancer', 29, 3400.00, ''),
(94, 'Lorlatinib', 'Cancer', 30, 3300.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager','user') NOT NULL DEFAULT 'user',
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `isActive`, `created`) VALUES
(1, 'komang', '$2y$10$8e3.EOtp4b3kC6ob3S/DfeKW/cyv7ewq/AGHyuUPlDf8PMqbo7t3a', 'user', 1, '2025-01-04 09:49:02'),
(2, 'komeng', '$2y$10$IXSrSS4DdPU/2W5bq2lDcOyDHx8nxRryZc0x/9G9k2ihSGJDRvtei', 'admin', 1, '2025-01-04 09:54:26'),
(3, 'komeng_damain', '$2y$10$WIsjiTzp9RssikuAtVRsW.6V8dFbIcXcVC2Q/2gicHaXDTshQOISS', 'user', 1, '2025-01-04 10:32:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
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
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
