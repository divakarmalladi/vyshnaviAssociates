-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2023 at 06:09 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vyshnaviassociates`
--

-- --------------------------------------------------------

--
-- Table structure for table `va_clients`
--

CREATE TABLE `va_clients` (
  `client_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `aadhar_number` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `type_of_project` varchar(20) NOT NULL,
  `login_id` varchar(30) NOT NULL,
  `customer_id` varchar(20) NOT NULL,
  `alloted_id` varchar(30) NOT NULL,
  `customer_status` tinyint(4) NOT NULL,
  `status` enum('0','1','2','3') NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `contact_email` varchar(60) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `va_clients`
--

INSERT INTO `va_clients` (`client_id`, `customer_name`, `address`, `reference`, `aadhar_number`, `date_of_birth`, `type_of_project`, `login_id`, `customer_id`, `alloted_id`, `customer_status`, `status`, `contact_number`, `contact_email`, `created_date`, `updated_date`) VALUES
(1, 'MALLADI DIWAKAR SATYA VARMA', '#201, Kakinada', '788', '858585858585', '1992-02-12', 'Panchayat', '2023VY001', '2023VY0MD001', '2023VY0002', 1, '1', '8507498433', '', '2023-03-07 12:40:39', '2023-03-16 10:38:31'),
(3, 'Ravi Kishore', '1-585, Amalapuram', '2023VY0008', '748596748596', '1998-02-02', 'Municipality', '2023VY0009', '2023VY0RK002', '2023VY0004', 1, '1', '8596857485', '', '2023-03-07 16:12:18', '2023-03-07 16:12:58');

-- --------------------------------------------------------

--
-- Table structure for table `va_clients_notes`
--

CREATE TABLE `va_clients_notes` (
  `note_id` bigint(20) NOT NULL,
  `notes` text NOT NULL,
  `checklist` varchar(100) NOT NULL,
  `customer_id` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `va_client_documents`
--

CREATE TABLE `va_client_documents` (
  `doc_id` bigint(20) NOT NULL,
  `customer_id` varchar(30) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_path` varchar(200) NOT NULL,
  `actual_file_name` varchar(200) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `checklist` varchar(100) NOT NULL,
  `subchecklist` varchar(5) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `file_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `va_users`
--

CREATE TABLE `va_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_password` varchar(256) NOT NULL,
  `login_id` varchar(60) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `user_type` tinyint(2) NOT NULL,
  `user_status` enum('0','1','2') NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `va_users`
--

INSERT INTO `va_users` (`user_id`, `user_name`, `user_email`, `user_password`, `login_id`, `phone_number`, `user_type`, `user_status`, `created_date`, `updated_date`) VALUES
(1, 'Admin', 'admin@vyshnavi-associates.com', '8991cfeb2153c9bbc45f6810952857f46ef10e737b81935e613794be588a4c5f51ae77e668c9e804cad1b8826064df878cc2f5c52dd810ef8c32fc2468c30b81fe019078ad127a1b0ec33fb8af8c1986ad3ea19546bd', '2023VY001', '8899001122', 1, '1', '2023-02-03 12:19:58', '2023-03-07 10:37:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `va_clients`
--
ALTER TABLE `va_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `va_clients_notes`
--
ALTER TABLE `va_clients_notes`
  ADD PRIMARY KEY (`note_id`);

--
-- Indexes for table `va_client_documents`
--
ALTER TABLE `va_client_documents`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `va_users`
--
ALTER TABLE `va_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `va_clients`
--
ALTER TABLE `va_clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `va_clients_notes`
--
ALTER TABLE `va_clients_notes`
  MODIFY `note_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `va_client_documents`
--
ALTER TABLE `va_client_documents`
  MODIFY `doc_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `va_users`
--
ALTER TABLE `va_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
